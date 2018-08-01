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
    <h2 class="entry-title">{{ get_the_title() }}</h2>
    <?php if (has_post_thumbnail())
      the_post_thumbnail( 'thumbnail' ); ?>
    <div class="entry-summary">
      @php the_content() @endphp
    </div>
  </article>
  <hr>
  @endwhile

  {!! get_the_posts_navigation() !!}
</div>
@endsection
