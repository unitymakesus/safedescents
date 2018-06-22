export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    $(document).ready(function() {
      $('.nav-trigger').click(function(e) {
        $('.nav').animate({width: 'toggle'});
        e.preventDefault();
        $(this).toggleClass('closed');
      });
    });
  },
};
