{{--
  Template Name: Partners Template
--}}

@extends('layouts.app')

@section('content')
<div class="partners">
  @php
    $args = array(
        'post_type' => 'partner'
    );

    $post_query = new WP_Query($args);
if($post_query->have_posts() ) {
  while($post_query->have_posts() ) {
    $post_query->the_post();
    @endphp
    <h2><?php the_title(); ?></h2>
    @php
  }
}
@endphp
</div>
@endsection
