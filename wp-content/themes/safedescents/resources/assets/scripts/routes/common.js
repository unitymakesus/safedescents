var geocoder = require('google-geocoder');
var geo = geocoder({key: 'AIzaSyCbYGfDTIovHfKjfqwGejD54Eds8Wt9TgI'});

export default {
  init() {
    // Sticky header
    $(window).scroll(function() {
      if ( $(window).scrollTop() >= 1 ) {
        $('header .site-header').addClass('fixed');
      } else {
        $('header .site-header').removeClass('fixed');
      }
    });

    // Get location information from API
    function getLocation(zip) {
      geo.find(zip.val(), function(err, res) {
        var city;
        if(res[0]['locality']){
          city = res[0]['locality']['long_name'];
        } else {
          city = res[0]['neighborhood']['long_name'];
        }
        var state_full = res[0]['administrative_area_level_1']['long_name'];
        var state_abbr = res[0]['administrative_area_level_1']['short_name'];

        // AJAX to get product matching state_full name
        $.ajax({
          url: sd_vars.ajax_uri,  // eslint-disable-line no-undef
          type: 'POST',
          data: {
            action: 'get_state_coverage',
            state_full: state_full,
            _ajax_nonce: sd_vars._ajax_nonce, // eslint-disable-line no-undef
          },
        })
        .done(function(response, textStatus, jqXHR) {
          // Remove loading icon
          $('#zip-loading').addClass('hidden');

          if (response) {
            // Populate coverage options for state with availability
            $('.buynow .state-name').html(state_full);
            if ("season-pass" in response) {
              $('.buynow #season-price').html('$' + response['season-pass']['price']);
              $('.buynow #buy-season').attr('href', '/buy-now/?configuration_id=' + response['season-pass']['id']);
              $('.buynow #season-cid').val(response['season-pass']['id']);
              $('.buynow .variation.season').addClass('avail');
            }
            if ("daily-pass" in response) {
              $('.buynow #daily-price').html('$' + response['daily-pass']['price']);
              $('.buynow #buy-daily').attr('href', '/buy-now/?configuration_id=' + response['daily-pass']['id']);
              $('.buynow #daily-cid').val(response['daily-pass']['id']);
              $('.buynow .variation.daily').addClass('avail');
            }
            $('.buynow .city').val(city);
            $('.buynow .state').val(state_abbr);
            $('.buynow .zip').val(zip.val());
          } else {
            // Populate not-available form for states without availability
            $('.passes .variation').hide();
            $('.passes .not-avail').show();
          }

          // Show pass options
          $('.zipcode, .passes').addClass('active');
        });
      });
    }

    // Click handler for Buy now toggle
    var $buynow = $('#buy-now-drawer');
    $('.buynow-desktop a').click(function(event){
      event.preventDefault();
      $('body').addClass('buy-now-drawer-open');
    });

    $('body').on('click',function(event) {
      if ($('body').hasClass('buy-now-drawer-open') && !$buynow.is(event.target) && $buynow.has(event.target).length === 0 && !($('.buynow-btn a').is(event.target)) && $('.buynow-btn a').has(event.target).length === 0) {
        $('body').removeClass('buy-now-drawer-open');
      }
    });

    // Input mask on zip field
    $('input[name="zip-code"]').inputmask("99999");

    // Validate zipcode form
    $('form.zipcode').validate();

    // Click Handlers for Buy Now header
    $('.check-availability').click(function(event){
      event.preventDefault();
      $(this).addClass('hidden');
      $('#zip-loading').removeClass('hidden');
      var zip = $(this).prev('input[name="zip-code"]');
      if (zip.valid()) {
        getLocation(zip);
      } else {
        // TODO what now?
      }
    });
  },
  finalize() {
      // Mobile Nav
      $('.nav-trigger').click(function(event) {
        event.preventDefault();
        $('.nav').animate({width: 'toggle'});
        $(this).toggleClass('closed');
      });
  },
};
