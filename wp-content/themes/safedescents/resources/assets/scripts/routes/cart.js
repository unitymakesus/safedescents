export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {

    $('#add-skier').click(function(){
      var skier = $('.new-skier:first').clone();
      skier.children('p').text("Another Skier");
      skier.children('input').val("");
      $(skier).appendTo('.skier-container');
    });

  },
};
