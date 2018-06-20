export default {
  init() {
    // JavaScript to be fired on all pages
  },
  finalize() {
    $(document).ready(function() {
        $('.toggle-nav').click(function(e) {
            $('.nav-container').slideToggle(500);
            e.preventDefault();
        });

    });  },
};
