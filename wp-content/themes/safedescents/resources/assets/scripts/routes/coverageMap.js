export default {
  init() {
    $('#map path').on( "click", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');

        var offset = $(this).offset();
        var height = $(this).height();
        var width = $(this).width();
        var top = offset.top + height + "px";
        var left = offset.left + width + "px";

        $(".tooltip").each(function(){
            $(this).hide();
            if($(this).attr('id') == id) {
                $(this).show().css({"top":top,"left":left});
            }
        });
    });
  },
};
