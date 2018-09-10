{{--
  Template Name: Coverage Template
--}}

@extends('layouts.app')

@section('content')
  <div class="banner">What state do you live in?</div>

  <section class="map-container">
    <div class="row">
      <div class="col-md-8">@include('partials.coverage-map')</div>
      <aside class="col-sm-12 col-md-4">@include('partials/tooltip')</aside>
    </div>
  </section>

  <div class="banner">Ski Rescue and Evacuation Insurance Features</div>

  @include('partials.content-page')

@endsection
