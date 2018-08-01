export default {
  finalize() {

    // Add available states on map
    $('.available').map(function() {
      var id = $(this).attr('data-state');
      $('[id="' + id + '"]').addClass('state-active');
    })

    // Desktop - On click of map state
    $('#map path').on( "click", function(e) {
      e.preventDefault();
      compareData($(this).attr('id'));
    });

    // Mobile - On select map state
    $('#coverage_select').on('change', function(e){
      e.preventDefault();
      compareData($('#coverage_select').find(":selected").text());
    });

    // Function to compare API data to user select
    function compareData(id){
      $('.coverage-details').hide();
      var found;

      // Loop through the API data
      $(".coverage-details").each(function() {
        if(id == $(this).attr('data-state')) {
          found = $(this);
        }
      })

      // If match, show state info, If no match, show unavailable
      if(found) {
        $(found).show();
      } else {
        $('.not-available').show();
        $('.not-available select.your-state').val(id);
      }
    }
  },
};
