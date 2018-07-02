@if ($products->have_posts())
  @while ($products->have_posts())
      @php ($products->the_post())
      <div class="tooltip" id="{{the_title()}}">
        <p>{{ the_title() }}</p>
        <span>$56.99</span>
        <p>Per Season</p>
        <p>4.99</p>
        <p>Per Day</p>
      </div>
  @endwhile
@endif

@php (wp_reset_postdata())
