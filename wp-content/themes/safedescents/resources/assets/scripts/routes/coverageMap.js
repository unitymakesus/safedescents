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
        var centerX = offset.left + pathWidth/2;
        var centerY = offset.top + pathHeight/2;

        console.log(centerX, centerY);

        // Set variables for Tooltip
        var id = $(this).attr('id');
        var found;
        var tipWidth;
        var tipHeight;

        $(".tooltip").map(function() {
          tipWidth = $(this).width()/2;
          tipHeight = $(this).height()/2;

          if(id == $(this).attr('data-state')) {
            found = $(this);
          }
        })

        if(found) {
          $(found).show().css({"top":centerY-tipHeight,"left":centerX-tipWidth});
        } else {
          $('.not-available').show().css({"top":centerY-tipHeight,"left":centerX-tipWidth});
          console.log(id);
          $('.not-available select.your-state').val(id);
        }
    });
  },
};
