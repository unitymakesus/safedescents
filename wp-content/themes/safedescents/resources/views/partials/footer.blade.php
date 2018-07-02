<footer>
    <img class="footer-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/skilift.jpeg"/>

    <div class="wrapper">
      <div class="footer-nav">
        <a class="logo left" href="{{ home_url('/') }}" rel="home">
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

        @php dynamic_sidebar('sidebar-footer') @endphp
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
