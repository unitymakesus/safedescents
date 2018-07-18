var geocoder = require('google-geocoder');
var geo = geocoder({key: 'AIzaSyCbYGfDTIovHfKjfqwGejD54Eds8Wt9TgI'});

export default {
  init() {
    // Get location information from API
    function getLocation() {
      geo.find($('#zip-code').val(), function(err, res) {
        var city = res[0]['locality']['long_name'];
        var state_full = res[0]['province_state']['long_name'];
        var state_abbr = res[0]['province_state']['short_name'];

        console.log(city);
        console.log(state_full);
        console.log(state_abbr);

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
          if (response == false) {
            // Populate not-available form for states without availability
            $('#na-state-name').html(state_full);
          } else {
            // Populate coverage options for state with availability
            $('.buynow .state-name').html(state_full);
            $('.buynow #season-price').html('$' + response['season-pass']['price']);
            $('.buynow #daily-price').html('$' + response['daily-pass']['price']);
            $('.buynow #buy-season').attr('href', '/buy-now/?configuration_id=' + response['season-pass']['id']);
            $('.buynow #buy-daily').attr('href', '/buy-now/?configuration_id=' + response['daily-pass']['id']);
            $('.buynow #season-cid').val(response['season-pass']['id']);
            $('.buynow #daily-cid').val(response['daily-pass']['id']);
            $('.buynow .city').val(city);
            $('.buynow .state').val(state_abbr);
            $('.buynow .zip').val($('#zip-code').val());
          }

          // Show pass options
          $('.zipcode, .passes').addClass('active');
        });
      });
    }

    // Click handler for Buy now toggle
    var $buynow = $('#buy-now-drawer');
    $('.buynow-btn').click(function(event){
      event.stopPropagation();
      $buynow.addClass('open');
    });

    $('body').on('click',function(event) {
      if (!$buynow.is(event.target)
        && $buynow.has(event.target).length === 0){
        $buynow.removeClass('open');
      }
    });

    // Click Handlers for Buy Now header
    $('.check-availability').click(function(event){
      event.preventDefault();
      var form = document.getElementById("checkzipcode");
      if (form.checkValidity()) {
        getLocation();
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
