var geocoder = require('google-geocoder');
var geo = geocoder({key: 'AIzaSyCbYGfDTIovHfKjfqwGejD54Eds8Wt9TgI'});

export default {
  init() {
    // JavaScript to be fired on page load
  },

  finalize() {
    var currentTab = 0;
    showTab(currentTab);

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
        const data = {
          action: 'get_state_coverage',
          state_full: state_full,
          _ajax_nonce: sd_vars._ajax_nonce, // eslint-disable-line no-undef
        };
        $.ajax({
          url: sd_vars.ajax_uri,  // eslint-disable-line no-undef
          type: 'POST',
          data,
        })
        .done(function(response, textStatus, jqXHR) {
          // Populate not-available form for states without availability
          $('#na-state-name').html(state_full);

          // Populate coverage options for state with availability
          $('#coverage-state-name').html(state_full);
          $('#coverage-season-pass .price').html('$' + response['season-pass']['price']);
          $('#coverage-daily-pass .price').html('$' + response['daily-pass']['price']);
        });
      });
    }


    // Set up next and previous form tabs
    function showTab(n){
      var tabs = $('.form-tab');
      $(tabs[n]).css('display', 'block');

      if (n == 0) {
        $('#prev-btn').css('display', 'none');
      } else {
        $('#prev-btn').css('display', 'inline-block');
      }

      stepIndicator(n);
    }


    // Show the next or previous form tab
    function nextPrev(n) {
      var tabs = $('.form-tab');

      $(tabs[currentTab]).css('display', 'none');

      currentTab = currentTab + n;

      if (currentTab >= tabs.length) {
        console.log('complete form')
      }
      showTab(currentTab);
    }


    // Show the progress indication
    function stepIndicator(n) {
      var steps = $('#progressbar li');
      $(steps).removeClass('active');
      $(steps[n]).addClass('active');
    }


    $.validator.setDefaults({
      debug: true,
      success: "valid",
      error: "invalid",
    });

    // Click Handlers for form
    $('#next-btn').click(function(){
      event.preventDefault();

      var form = $( "#buynowform" );
      form.validate();

      if(form.valid() == false) {
        form.valid();
      } else {
        getLocation();
        nextPrev(1);
      }
    });

    $('#prev-btn').click(function(){
      event.preventDefault();
      nextPrev(-1);
    })

    $('#add-skier').click(function(){
      event.preventDefault();

      var skier = $('.new-skier:first').clone();
      skier.children('p').text("Another Skier");
      skier.children('input').val("");
      $(skier).appendTo('.skier-container');
    })
  },
};
