@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @if (is_page('api-pull'))
      @php(App\sd_api_pull())
    @endif
    @include('partials.content-page')
  @endwhile
@endsection
