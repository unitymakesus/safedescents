export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {

    $('#add-skier').click(function(e){
      e.preventDefault();
      // Increase quantity
      $( document.body ).trigger( 'quantity_update' );

      var skier = $('.new-skier:first').clone();
      skier.children('p').text("Another Skier");
      skier.children('input').val("");
      $(skier).appendTo('.skier-container');
    });

  },
};
