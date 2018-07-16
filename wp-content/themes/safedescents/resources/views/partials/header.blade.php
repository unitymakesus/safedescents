@if(is_front_page())
<header class="header-frontpage">
@else
  @if(has_post_thumbnail())
    <header style="background-image: url('{!! get_the_post_thumbnail_url($id, 'large') !!}">
  @else
    <header style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mountains.jpeg')">
  @endif
@endif
    <div class="wrapper nav-container">
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

      <nav>
        <a href="#" class="nav-trigger">&#9776;</a>
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
        @endif
      </nav>
    </div>

    @if(is_front_page())
        <h1>Ski and Snowboard Insurance</h1>
        <div class="banner">You wear a helmet on the slopes, protect your wallet as well.</div>
      </div>

      <video muted autoplay loop poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.jpg">
        <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.webm" type="video/webm">
        <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.mp4" type="video/mp4">
      </video>
    @else
      <h1><?php the_title(); ?></h1>
    @endif
  </div>
</header>
