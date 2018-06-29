export default {
  init() {
    $.ajax({
      type: 'GET',
      url: '/wp-content/themes/safedescents/app/sdk/api-products.json',
      success: function(data){
        return coverageMap(data);
      },

      error: function(error) {
        console.log(error);
      },
    });

    function coverageMap(data){
      $.each(data, function(i, val) {
        var dataLoc = val.location;
        var dataVars = val.variations;
        console.log(data);

        $("#map path").each(function(){
          var mapLoc = $(this).attr('id');

          if(dataLoc == mapLoc){
            $(this).css({ fill: "green"});
          }
        });
      });
    }
  },
};
