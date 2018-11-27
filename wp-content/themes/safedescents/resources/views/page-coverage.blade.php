{{--
  Template Name: Coverage Template
--}}

@extends('layouts.app')

@section('content')

  <div class="banner">Ski Rescue and Evacuation Insurance Features</div>

  <div class="wrapper content-wrapper">
    @php (wp_reset_postdata())

    @include('partials.content-page')
  </div>

  <div class="banner">What state do you live in?</div>

  <section class="map-container">
    <div class="row">
      <div class="col-md-8">@include('partials.coverage-map')</div>
      <aside class="col-sm-12 col-md-4">@include('partials.tooltip')</aside>
    </div>
  </section>

  @if(($bottomcontent))
    <br><br>
    <div class="banner">Watch the video below to learn more about our process.</div><br>

    <div class="wrapper content-wrapper">
      {!! $bottomcontent !!}
    </div>
  @endif

@endsection
