{{--
  Template Name: Coverage Template
--}}

@extends('layouts.app')

@section('content')
  <div class="banner">Where is Safe Descents available?</div>

  <section class="map-container">
    @include('partials.coverage-map')
  </section>

  @include('partials/tooltip')

  <div class="banner">Rescue and Evacuation Insurance Features</div>

  @include('partials.content-page')

@endsection
