export default {
  init() {

    // On click of map path
    $('#map path').on( "click", function(e) {
        // Prevent click and clean Tooltip values
        e.preventDefault();
        $('.tooltip').hide();
        $('.state').remove();

        // Get SVG path dimentions
        var pathWidth = $(this)[0].getBoundingClientRect().width;
        var pathHeight = $(this)[0].getBoundingClientRect().height;

        // Get and Set SVG path coordinates
        var offset = $(this).offset();
        var left = offset.left + pathWidth/2;
        var top = offset.top + pathHeight/2;

        // Set variables for Tooltip
        var id = $(this).attr('id');
        var found;

        $(".tooltip").map(function() {
          if(id == $(this).attr('data-state')) {
            found = $(this);
          }
        })

        if(found) {
          var tipWidth = $(found).width()/2;
          var tipHeight = $(found).height();
          $(found).show().css({"top":top-tipHeight-40,"left":left-tipWidth});
        } else {
          $('.not-available').show().css({"top":top-200,"left":left-180});
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
