export default {
  init() {
    $('#map path').on( "click", function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var offset = $(this).offset();
        $(".tooltip").each(function(){
            $(this).hide();
            if($(this).attr('id') == id) {
                $(this).show().css({"top":offset.top-180,"left":offset.left+10});
            }
        });
    });

    // $.ajax({
    //   type: 'GET',
    //   url: '/wp-content/themes/safedescents/app/sdk/api-products.json',
    //   success: function(data){
    //     return data;
    //   },
    //
    //   error: function(error) {
    //     console.log(error);
    //   },
    // });
    // function coverageMap(data){
    //   $.each(data, function(i, val) {
    //     var dataLoc = val.location;
    //     var dataVars = val.variations;
    //     console.log(data);
    //
    //     $("#map path").each(function(){
    //       var mapLoc = $(this).attr('id');
    //
    //       if(dataLoc == mapLoc){
    //         $(this).css({ fill: "green"});
    //       }
    //     });
    //   });
    // }
  },
};
