<footer>
  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Bitmap.png"/>
  @php dynamic_sidebar('sidebar-footer') @endphp

  <div class="footer-copyright">
    <div class="container">
      <div class="flex flex-center space-between">
        <span class="copyright">&copy; @php(current_time('Y')) Safe Descents --- All products are underwritten by Starr Indemnity & Liability Company</span>

        @include('partials.unity')
      </div>
    </div>
  </div>
</footer>
