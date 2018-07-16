{{--
  Template Name: Claims Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-page')

    <section class="claims-sections">
      <article>
        <h5>{!! $hospital['title'] !!}</h5>
        {!! $hospital['content'] !!}
      </article>

      <article>
        <h5>{!! $home['title'] !!}</h5>
        {!! $home['content'] !!}
      </article>
    </section>
  @endwhile
@endsection
