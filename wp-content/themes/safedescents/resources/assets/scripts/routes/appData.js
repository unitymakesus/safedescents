var geocoder = require('google-geocoder');
var geo = geocoder({key: 'AIzaSyCbYGfDTIovHfKjfqwGejD54Eds8Wt9TgI'});

export default {
  init() {
    // JavaScript to be fired on page load
  },

  finalize() {
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
          $('.state-name').html(state_full);
          $('.season-price').html('$' + response['season-pass']['price']);
          $('.daily-price').html('$' + response['daily-pass']['price']);
        });
      });
    }

    $.validator.setDefaults({
      debug: true,
      success: "valid",
      error: "invalid",
    });

    // Click Handlers for form
    $('.check-availability').click(function(){
      event.preventDefault();

      var form = $( "#buynow" );
      form.validate();

      if(form.valid() == false) {
        form.valid();
      }
      else {
        getLocation();
        $('.zipcode, .passes').addClass('active');
      }
    });
  },
};
