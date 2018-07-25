export default {
  finalize() {
    // On click of tooltip close button
    $('.tooltip').on('click', '.close', function(e) {
      $('.tooltip').hide();
    });

    // On click of map path
    $('#map path').on( "click", function(e) {
        // Prevent click and clean Tooltip values
        e.preventDefault();
        $('.state').remove();

        // Get SVG path dimentions
        var pathWidth = $(this)[0].getBoundingClientRect().width;
        var pathHeight = $(this)[0].getBoundingClientRect().height;

        // Get click coordinates
        var left = e.pageX;
        var top = e.pageY;

        // Set variables for Tooltip
        var id = $(this).attr('id');
        var found, tipWidth, tipHeight;
        var notfound = $('.state-list .not-available');
        var close = '<span class="close" aria-hidden="true">x</span>';

        $(".state-list > div").map(function() {
          if(id == $(this).attr('data-state')) {
            found = $(this);
          }
        })

        if(found) {
          tipHeight = $(found).height();
          $('.map-container .tooltip').removeClass('not-available').html(close + found.html()).show().css({"top":top-tipHeight-40,"left":left-100});
        } else {
          tipHeight = $(notfound).height();
          $('.map-container .tooltip').html(close + notfound.html()).addClass('not-available').show().css({"top":top-tipHeight-40,"left":left-150});
          $('.not-available select.your-state').val(id);
        }
    });

    if ($(window).width() < 767) {
      $('.state-name ').click(function(){
        var tip = $(this).next('.variation');
        tip.slideToggle();
      })
    }
  },
};
