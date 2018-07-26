<footer>
    <img class="footer-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/skilift.jpeg"/>

    <div class="row">
      <div class="col-md-2">
        <a class="logo" href="{{ home_url('/') }}" rel="home">
          @if (has_custom_logo())
            @php
              $custom_logo_id = get_theme_mod( 'custom_logo' );
              $logo = wp_get_attachment_image_src( $custom_logo_id , 'logo' );
            @endphp

            <img class="logo"
                 src="{{ $logo[0] }}"
                 srcset="{{ $logo[0] }}"
                 alt="{{ get_bloginfo('name', 'display') }}" />
          @else
            {{ get_bloginfo('name', 'display') }}
          @endif
        </a>
      </div>

      <div class="col-md-5 footer-menu">
        @php dynamic_sidebar('sidebar-footer') @endphp
      </div>

      <div class="col-md-offset-2 col-md-3">
        @php dynamic_sidebar('sidebar-footer-2') @endphp
      </div>
    </div>

    <div class="footer-copyright">
      <div class="wrapper">
        <div class="flex flex-center space-between">
          <span class="copyright">&copy; @php(current_time('Y')) Safe Descents --- All products are underwritten by Starr Indemnity & Liability Company</span>

          @include('partials.unity')
        </div>
      </div>
    </div>
  </div>
</footer>
