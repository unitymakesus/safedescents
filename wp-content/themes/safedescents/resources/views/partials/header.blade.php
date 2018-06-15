<header class="banner">
  <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

  <div class="container hero" style="background-image: url('{!! get_the_post_thumbnail_url($id, 'large') !!}">
    <a class="logo left" href="{{ home_url('/') }}" rel="home">
      @if (has_custom_logo())
        @php
          $custom_logo_id = get_theme_mod( 'custom_logo' );
          $logo = wp_get_attachment_image_src( $custom_logo_id , 'ncecf-logo' );
          $logo_2x = wp_get_attachment_image_src( $custom_logo_id, 'ncecf-logo-2x' );
        @endphp
        <img src="{{ $logo[0] }}"
             srcset="{{ $logo[0] }} 1x, {{ $logo_2x[0] }} 2x"
             alt="{{ get_bloginfo('name', 'display') }}"
             width="{{ $logo[1] }}" height="{{ $logo[2] }}" />
      @else
        {{ get_bloginfo('name', 'display') }}
      @endif
    </a>
    <nav class="nav-primary">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>

    @if(is_front_page())
      <h1>{{$hero->hero_text}}</h1>
      <div class="banner">{{$hero->hero_banner}}</div>

    @else
      <h1><?php the_title(); ?></h1>
    @endif
  </div>
</header>
