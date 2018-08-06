@extends('layouts.app')

@section('content')
<div class="content-wrapper testimonials">
  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
      {!! get_search_form(false) !!}
  @endif

  @while(have_posts()) @php the_post() @endphp
  <article @php post_class() @endphp>
    <h2 class="entry-title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h2>
      <!-- @include('partials/entry-meta') -->
    <div class="entry-summary">
      @php the_excerpt() @endphp
    </div>
  </article>
  <hr>
  @endwhile

  {!! get_the_posts_navigation() !!}
</div>
@endsection
