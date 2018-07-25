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

    //define counter
    var skierCount = 1;
    var counter = 1;
    var skierTemplate = $(".skier-container:first").clone();

    $('#add-skier').click(function(e){
      e.preventDefault();

      counter += 90;
      $('#add-skier').css('transform', 'rotate(' + counter + 'deg)')

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
      return false;
    });

    // Check if all fields in section are valid
    function compareValid($this) {
      $('#buynowform').validate({errorElement:'div', errorClass: 'help'});
      let thisSection = $this.closest('.form-step');
      var fields = $this.find(":input");

      if (fields.valid()) {
        $this.find('button[data-button-type=next]').removeClass('disabled');
      } else {
        $this.find('button[data-button-type=next]').addClass('disabled');
      }
    }

    // Validate section when radio buttons change
    $('form .form-section').on('change', 'input[type="radio"]', function() {
      var thisSection = $(this).closest('.form-step');
      compareValid(thisSection);
    })

    // Validate section when each field loses focus
    $('form .form-section').on('blur', '[required]', function() {
      var thisSection = $(this).closest('.form-step');
      compareValid(thisSection);
    });

    /**
     * Button handlers
     */
    // Multi-page form pagination and progress functions
    $('.form-step').on('click', '.btn', function(e) {
      var thisSection = $(this).closest('.form-step');

      // Handle disabled buttons
      if (($(this)).hasClass('disabled')) {
        e.preventDefault();
        compareValid(thisSection);

        // Don't allow click
        return false;
      }

      // Next button handler
      if ($(this).attr('data-button-type') == "next") {
        e.preventDefault();

        let thisStep = Number(thisSection.attr('data-section-number'));
        let nextStepN = thisStep+1;
        let nextStepT = $('.form-progress .progress-step[data-step-current]').next().html();

        // Hide this section
        thisSection.addClass('hidden').attr('aria-hidden', 'true');

        // Show next section
        $('.form-step[data-section-number="' + nextStepN + '"]').removeClass('hidden').attr('aria-hidden', 'false');

        // Change progress step
        $('.form-progress').attr('aria-valuenow', nextStepN);
        $('.form-progress').attr('aria-valuetext', 'Step ' + nextStepN + ' of 3: ' + nextStepT);
        $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-complete', '')
          .next().removeAttr('data-step-incomplete').attr('data-step-current', '');

        $(this).next('.loading-spinner').remove();
      }
    });

    // Progress step click functions
    $('.form-progress').on('click', '.progress-step[data-step-complete]', function() {
      let thisSection = $('.form-step[aria-hidden="false"]');
      let currentIndex = $('.form-progress .progress-step[data-step-current]').index();
      let currentStepN = currentIndex+1;
      let targetIndex = $(this).index();
      let targetStepN = targetIndex+1;
      let targetStepT = $(this).html();

      // Hide this section
      thisSection.addClass('hidden').attr('aria-hidden', 'true');

      // Show target section
      $('.form-step[data-section-number="' + targetStepN + '"]').removeClass('hidden').attr('aria-hidden', 'false');

      // Change progress step
      $('.form-progress').attr('aria-valuenow', targetStepN);
      $('.form-progress').attr('aria-valuetext', 'Step ' + targetStepN + ' of 3: ' + targetStepT);
      $('.form-progress').attr('aria-valuetext', 'Step ' + targetStepN + ' of 3: ' + targetStepT);

      // If current step is before the target step, set attr to complete,
      // otherwise set attr to incomplete
      if (currentStepN > targetStepN) {
        $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-complete', '');
      } else {
        $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-incomplete', '');
      }

      $(this).removeAttr('data-step-complete').attr('data-step-current', '');
    });



  },
};
