export default {
  init() {
    $('#map path').on( "click", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var offset = $(this).offset();
        var width = this.getBoundingClientRect().width;

        $(".tooltip").each(function(){
            $(this).hide();
            if($(this).attr('id') == id) {
                $(this).show().css({"top":offset.top,"left":offset.left});
            }
        });
    });
  },
};
