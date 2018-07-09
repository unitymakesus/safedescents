export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
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

  },
};