<header>
  <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

  <div class="container" style="background-image: url('{!! get_the_post_thumbnail_url($id, 'large') !!}">
    <div class="nav-container">
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

      <nav class="nav-primary">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
        @endif
        <a class="toggle-nav" href="#">&#9776;</a>
      </nav>
    </div>

      <h1><?php the_title(); ?></h1>
  </div>
</header>
