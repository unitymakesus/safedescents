{{--
  Template Name: Coverage Template
--}}

@extends('layouts.app')

@section('content')
  <div class="banner">Where is Safe Descents available?</div>

  @while(have_posts()) @php the_post() @endphp
    <section class="map-container">
      @include('partials.coverage-map')
    </section>
  @endwhile

  @php
  $args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'tax_query' => array(
      array(
      'taxonomy' => 'pa_pass',
      'field' => 'slug',
      'terms' => array( 'daily-pass', 'season-pass' ),
      'operator'  => 'AND',
      )
     )
    );
    $products = new WP_Query( $args );
  @endphp

  @if ($products->have_posts())
    @while ($products->have_posts())
        @php ($products->the_post())
        <div class="tooltip" id="{{the_title()}}">
          <p>{{ the_title() }}</p>
          <p>$56.99</p>
          <p>Per Season</p>
          <p>4.99</p>
          <p>Per Day</p>
        </div>
    @endwhile
  @endif

  @php (wp_reset_postdata())

  <div class="banner">Rescue and Evacuation Insurance Features</div>

  @include('partials.content-page')

@endsection
