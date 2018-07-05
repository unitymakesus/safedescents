export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {

    $('#add-skier').click(function(e){
      e.preventDefault();

      // Increase quantity
      var $item_quantity = $('#item-quantity');
      $('#item-quantity').val(parseFloat($item_quantity.val()) + 1);

      console.log($item_quantity.val());

      // $( document.body ).trigger( 'quantity_update' );

      $.ajax({
          type: 'POST',
          url: sd_vars.ajax_uri,  // eslint-disable-line no-undef
          data: {
              action: 'qty_cart',
              _ajax_nonce: sd_vars._ajax_nonce,   // eslint-disable-line no-undef
              hash: $item_quantity.attr('name'),
              quantity: $item_quantity.val(),
          },
          success: function(data) {
            console.log(data);
              // $( '.view-cart-popup' ).html(data);
          },
      });

      var skier = $('.new-skier:first').clone();
      skier.children('p').text("Another Skier");
      skier.children('input').val("");
      $(skier).appendTo('.skier-container');
    });

  },
};
