{{--
  Template Name: Coverage Template
--}}

@extends('layouts.app')

@section('content')
  <div class="banner">Where is Safe Descents Available?<span>Click on your state to check availability.</span></div>

  <section class="map-container">
    @include('partials.coverage-map')
    <div class="tooltip"><span class="close" aria-hidden="true">x</span></div>
  </section>

  <div class="state-list">
    @include('partials/tooltip')
  </div>

  <div class="banner">Ski Rescue and Evacuation Insurance Features</div>

  @include('partials.content-page')

@endsection
