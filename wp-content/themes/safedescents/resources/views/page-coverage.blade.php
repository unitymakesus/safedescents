@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-page')

    @if(is_page( 11 ))
      <section class="map-container">
        @include('partials.coverage-map')
      </section>
    @endif

  @endwhile
@endsection
