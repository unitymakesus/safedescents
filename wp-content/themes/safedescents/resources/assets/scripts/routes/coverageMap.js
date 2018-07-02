export default {
  init() {

    // On click of map path
    $('#map path').on( "click", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');

        // Get SVG path dimentions
        var pathWidth = $(this)[0].getBoundingClientRect().width;
        var pathHeight = $(this)[0].getBoundingClientRect().height;

        // Get and Set SVG path coordinates
        var offset = $(this).offset();
        var centerX = offset.left + pathWidth/2;
        var centerY = offset.top + pathHeight/2;

        // Loop through tooltips
        $(".tooltip").each(function(){
            $(this).hide();

            // Set tooltip dimensions
            var tipWidth = $(this).width()/2;
            var tipHeight = $(this).height()+10;

            // Check if path matches WooCommerce data
            if($(this).attr('id') == id) {
                // Show tooltip and position it centered
                $(this).show().css({"top":centerY-tipHeight,"left":centerX-tipWidth});
            }
        });
    });
  },
};
