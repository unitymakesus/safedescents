export default {
  init() {
    // JavaScript to be fired on checkout page
  },
  finalize() {

    // Stick sidebar to fixed position when it reaches top of screen on scroll
    var distance = $('#sticky-cart').offset().top;
    $(window).scroll(function() {
      if ( $(window).scrollTop() >= distance ) {
        $('#sticky-cart').addClass('fixed');
      } else {
        $('#sticky-cart').removeClass('fixed');
      }
    });

    // Jquery Validator
    $(function() {
      $('#buynowform').validate({
        ignore:':hidden',
        errorElement:'div',
        errorClass: 'help',
        onfocusout: function(element) {
          this.element(element);
          var $this = $(this)[0].currentElements.closest('.form-step');
          if(this.element(element) == true) {
            validateForm($this);
          }
        },
      })
    });

    // Handle Stripe Checkout
    var stripeHandler = StripeCheckout.configure({  // eslint-disable-line no-undef
      key: $('#stripe-data').attr('data-key'),
      name: 'Safe Descents Insurance',
      allowRememberMe: false,
      token: function(token) {
        $('input#stripe-token').val(token.id);
        $('#buynowform').submit();
      },
    });

    // Test Form Validation
    function validateForm($this) {
      console.log($('#buynowform').valid())
      if($('#buynowform').valid() == true){
        $($this.closest('.form-step')).find('button[data-button-type=next]').removeClass('disabled');
        $($this.closest('.form-step')).find('#stripe-submit').removeClass('disabled');
      } else {
        $(this).find('button[data-button-type=next]').addClass('disabled');
        $(this).find('#stripe-submit').addClass('disabled');
      }
    }

    // Click Handler on Buttons
    $('.form-step').on('click', 'button[data-button-type=next]', function(e) {
      e.preventDefault();
      var thisSection = $(this).closest('.form-step');

      if(!($(this)).hasClass('disabled')) {
        nextStep(thisSection);
      }
    });

    $('.form-step').on('click', 'button[data-button-type=prev]', function(e) {
      e.preventDefault();
      var thisSection = $(this).closest('.form-step');
      prevStep(thisSection);
    });

    $('.form-step').on('click', '#stripe-submit', function(e) {
      e.preventDefault();

      if(!($(this)).hasClass('disabled')) {
        var config = {
          amount: parseInt($('#stripe-data').attr('data-amount')),
          description: $('#stripe-data').attr('data-description'),
          email: $('#billing_email').val(),
        }

        console.log(config)
        stripeHandler.open(config);
      }
    });

    // Move to Next or Prev Step
    function nextStep(thisSection){
      var thisStep = Number(thisSection.attr('data-section-number'));
      var nextStepN = thisStep+1;
      var nextStepT = $('.form-progress .progress-step[data-step-current]').next().html();

      // Hide this section
      thisSection.addClass('hidden').attr('aria-hidden', 'true');

      // Show next section
      $('.form-step[data-section-number="' + nextStepN + '"]').removeClass('hidden').attr('aria-hidden', 'false');

      // Change progress step
      $('.form-progress').attr('aria-valuenow', nextStepN);
      $('.form-progress').attr('aria-valuetext', 'Step ' + nextStepN + ' of 3: ' + nextStepT);
      $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-complete', '')
        .next().removeAttr('data-step-incomplete').attr('data-step-current', '');

      // Add details to summary
      var sectionID = thisSection.attr('id');
      var configPrice = $('.coverage-info input[name="config_price"]').val();

      switch (sectionID) {
        case "trip-details" :
          var diffDays = 1;

          if ($('input[name="date-range"]').length) {
            // Get date range
            var dateRangePretty = $('input[name="date-range"]').next().val();
            $('#sticky-cart dd.dates').html(dateRangePretty);
            $('#sticky-cart .dates').removeClass('hidden');

            // Calculate # of days
            var dateRange = $('input[name="date-range"]').val();
            var dateArray = dateRange.split(" to ");
            var startDate = new Date(dateArray[0]);
            var endDate = new Date(dateArray[1]);
            var diffMS = endDate.getTime() - startDate.getTime();
            diffDays = Math.round(diffMS/(1000*60*60*24));
            $('.coverage-info input[name="config_quantity"]').val(diffDays);
            $('#sticky-cart dd.length').html(diffDays);
            $('#sticky-cart .length').removeClass('hidden');
          }

          // Calculate subtotal
          $('#sticky-cart .subtotal').html(configPrice * diffDays);

          break;

        case "skier-details" :
          // Calculate number of skiers
          var number = $('.skier-container').length;
          $('#sticky-cart dd.number').html(number);
          $('#sticky-cart .number').removeClass('hidden');

          // Calculate total
          var configDays = $('input[name="config_quantity"]').val();
          var total = configPrice * configDays * number;
          $('#sticky-cart dd.total').html('$' + total);
          $('#sticky-cart .total').removeClass('hidden');

          // Get all config options
          var state = $('#sticky-cart dd.state').html();
          var plan = $('#sticky-cart dd.plan').html();
          var days = $('#sticky-cart dd.length').html();

          var description = state + ': ' + plan;

          // add # of days
          if (days.length) {
            description = description + '(' + days + ' days)';
          }

          // add # of insured
          description = description + ' x ' + number;

          // Setup Stripe data
          $('#stripe-checkout [name="item_amount"]').val(total*100);
          $('#stripe-data').attr('data-description', description);
          $('#stripe-data').attr('data-amount', total*100);

          break;
      }
    }

    function prevStep(thisSection){
      var thisStep = Number(thisSection.attr('data-section-number'));
      var prevStepN = thisStep-1;
      var prevStepT = $('.form-progress .progress-step[data-step-current]').prev().html();

      // Hide this section
      thisSection.addClass('hidden').attr('aria-hidden', 'true');

      // Show next section
      $('.form-step[data-section-number="' + prevStepN + '"]').removeClass('hidden').attr('aria-hidden', 'false');

      // Change progress step
      $('.form-progress').attr('aria-valuenow', prevStepN);
      $('.form-progress').attr('aria-valuetext', 'Step ' + prevStepN + ' of 3: ' + prevStepT);
      $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-complete', '')
        .prev().removeAttr('data-step-incomplete').attr('data-step-current', '');
    }

    // Add flatpickr to date fields
    $('input[name="date-range"]').flatpickr({
      altInput: true,
      altFormat: 'n/d/Y',
      dateFormat: 'Y-m-d',
      mode: 'range',
      minDate: 'today',
    });

    // Input mask on birthdate fields
    $('input[id="birthdate"]').inputmask("99/99/9999",{ "placeholder": "dd/mm/yyyy" });

    // Add Additional Skier
    $(function() {
      var skierCount = 1;
      var counter = 1;
      var skierTemplate = $(".skier-container:first").clone();

      $('#add-skier').on('click', function(e){
        e.preventDefault();
        counter += 90;

        $('#add-skier').css('transform', 'rotate(' + counter + 'deg)');
        //increment
        skierCount++;
        // element width
        var width = $(".skier-container:first").width();
        //loop through each input
        skierTemplate.clone().find(':input').each(function(){
            //set id to store the updated section number
            var newId = this.id + skierCount;
            //update for label
            $(this).prev().attr('for', newId);
            //update id
            this.id = newId;
        }).end().insertBefore('#add-skier').hide().slideDown('slow');
        $('input[data-inputmask]').inputmask("99/99/9999",{ "placeholder": "dd/mm/yyyy" });
        // var $this = $(this).closest('.form-step');
        // validateForm($this);
        return false;
      });

      // Remove Additional Skier
      $(document).on('click','.remove-skier',function(){
        var container = $(this).closest('.skier-container');
        $(container).remove();
      });
    });

    // Different Address on Billing
    $('#new-billing').on("change", function (e){
        if(this.checked){
          $('.billing-address-same').slideDown();
        } else {
          $('.billing-address-same').slideUp();
        }
    });

    // Close Stripe Checkout on page navigation
    $(window).on('popstate', function() {
      stripeHandler.close();
    });

  },
};
