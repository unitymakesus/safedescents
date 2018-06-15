<header class="banner">
  <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>

  <div class="container header" style="background-image: url('{!! get_the_post_thumbnail_url($id, 'large') !!}">
    <div class="nav-container">
        @if (has_custom_logo())
          @php the_custom_logo(); @endphp
        @else
          {{ get_bloginfo('name', 'display') }}
        @endif
      <nav class="nav-primary">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
        @endif
      </nav>
    </div>

    @if(is_front_page())
      <h1>{{$hero->hero_text}}</h1>
      <div class="banner">{{$hero->hero_banner}}</div>

    @else
      <h1><?php the_title(); ?></h1>
    @endif
  </div>
</header>
