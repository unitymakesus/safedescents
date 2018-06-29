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
  
  <div class="banner">Rescue and Evacuation Insurance Features</div>

  @include('partials.content-page')

@endsection
