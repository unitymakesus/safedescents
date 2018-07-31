<article class="wrapper" @php post_class() @endphp>
    <!-- <h2 class="entry-title">{{ get_the_title() }}</h2> -->
    @include('partials/entry-meta')
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
</article>
