@if(is_front_page())
  <header class="header-frontpage">

@elseif(is_single() || is_category("testimonials"))
  <header style="background: linear-gradient(
      rgba(0, 0, 0, 0.15),
      rgba(0, 0, 0, 0.15)
    ), url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/skiresort.jpg'); background-size: cover; background-position: center;">

@else
  @if(has_post_thumbnail())
    <header style="background: linear-gradient(
      rgba(0, 0, 0, 0.15),
      rgba(0, 0, 0, 0.15)
    ), url('{!! get_the_post_thumbnail_url($id, 'full') !!}'); background-size: cover; background-position: center;">
  @else
    <header style="background: linear-gradient(
      rgba(0, 0, 0, 0.15),
      rgba(0, 0, 0, 0.15)
    ), url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/skiresort.jpg'); background-size: cover; background-position: center;">
  @endif
@endif

    <div class="row site-header">
      <div class="col-xs col-sm-3">
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

      @if(!is_page('buy-now'))
        <div class="col-xs col-sm-9">
          <nav>
            <a href="#" class="nav-trigger"></a>
            @if (has_nav_menu('primary_navigation'))
              {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
            @endif
          </nav>
        </div>
      @endif
    </div>

    @if(is_front_page())
      <video muted autoplay poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.jpg">
        <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.webm" type="video/webm">
        <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.mp4" type="video/mp4">
      </video>

      <div class="home-hero">
        <h1>Ski and Snowboard Evacuation Insurance</h1>
      </div>

      <div class="down-arrow"><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/vec_down_arrow.png"></div>

    @elseif(is_category("testimonials"))
      <h1>Testimonials</h1>
    @elseif(is_category("news"))
      <h1>News</h1>  
    @elseif(is_single() || is_category("video"))
      <h1>News</h1>
    @elseif(array_key_exists('checkout', $_GET))
      <h1>Thank You</h1>
    @elseif(!is_page('buy-now') && !is_page('buy-now-partner'))
      <h1><?php the_title(); ?></h1>
    @endif
  </div>
</header>
