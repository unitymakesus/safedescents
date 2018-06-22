<header>
  <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

  <div class="container header">
    <div class="nav-container">
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

      <nav class="nav-primary">
        <a href="#" class="nav-trigger">&#9776;</a>
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
        @endif
      </nav>
    </div>

    <h1>{{$hero->hero_text}}</h1>
    <div class="banner">{{$hero->hero_banner}}</div>
  </div>

  <video muted autoplay loop poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.jpg">
    <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.webm" type="video/webm">
    <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Mt_Baker.mp4" type="video/mp4">
  </video>
</header>
