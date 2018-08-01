@if(is_front_page())
  <header class="header-frontpage">

@elseif(is_single() || is_category("testimonials"))
  <header style="background-image: linear-gradient(rgba(0, 0, 0, .2), rgba(0, 0, 0, .3)), url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mountains.jpeg')">

@else
  @if(has_post_thumbnail())
    <header class="page-header parallax" style="background-image: linear-gradient(rgba(0, 0, 0, .2), rgba(0, 0, 0, .5)), url('{!! get_the_post_thumbnail_url($id, 'full') !!}')">
  @else
    <header style="background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, .3)), url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mountains.jpeg')">
  @endif
@endif

    <div class="row site-header">
      <div class="col-xs col-md-3">
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

      <div class="col-xs col-md-offset-4 col-md-5">
        <nav>
          <a href="#" class="nav-trigger">&#9776;</a>
          @if (has_nav_menu('primary_navigation'))
            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
          @endif
        </nav>
      </div>
    </div>

    @if(is_front_page())
        <h1>Ski and Snowboard Insurance</h1>
        <div class="banner">You wear a helmet on the slopes, protect your wallet as well.</div>
      </div>

      <video muted autoplay poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.jpg">
        <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.webm" type="video/webm">
        <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.mp4" type="video/mp4">
      </video>

    @elseif(is_category("testimonials"))
      <h1>Testimonials</h1>

    @else
      <h1><?php the_title(); ?></h1>
    @endif
  </div>
</header>
