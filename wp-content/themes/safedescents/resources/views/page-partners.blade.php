{{--
  Template Name: Partners Template
--}}

@extends('layouts.app')

@section('content')
<div class="faux-header" style="background-image:url('<?php the_post_thumbnail_url('large'); ?>')">
  <h1>Partners</h1>
</div>
<div class="partners">
  @php
    $args = array(
        'post_type' => 'partner',
        'posts_per_page' => '5'
    );

    $post_query = new WP_Query($args);
    if($post_query->have_posts() ) {
      @endphp
      <ul>
      @php
      while($post_query->have_posts() ) {
        $post_query->the_post();
        @endphp
        <li>
          <h4><?php the_title(); ?></h4>
          <img src="<?php the_post_thumbnail_url('medium'); ?> " />
        </li>
        @php
      }
      @endphp
      </ul>
      @php
    }
  @endphp
  <div class="container">
    <div class="partner-content">
      <?php the_content(); ?>
    </div>
  </div>
</div>
@endsection
