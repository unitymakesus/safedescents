export default {
  init() {
    $.fn.isInViewport = function() {
      var elementTop = $(this).offset().top;
      var elementBottom = elementTop + $(this).outerHeight();

      var viewportTop = $(window).scrollTop();
      var viewportBottom = viewportTop + $(window).height();

      return elementBottom > viewportTop && elementTop < viewportBottom;
    };
  },
  finalize() {
    $(window).on('resize scroll', function() {
      if ($('.home header').isInViewport()) {
          $('.home-vid').play();
      } else {
        $('.home-vid').pause();
      }
    });
  },
};
