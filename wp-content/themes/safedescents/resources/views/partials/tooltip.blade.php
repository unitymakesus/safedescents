@php
  $states_json = file_get_contents(get_template_directory() . '/../app/sdk/api-products.json');

  if (!empty($states_json)) {
    $states = json_decode($states_json);
  }

  // if ($pass_duration = $variation['attributes']['attribute_pa_pass']) {
  //   $passes[$pass_duration]['price'] = $variation['display_price'];
  //   $passes[$pass_duration]['variation_id'] = $variation['variation_id'];
  //   $passes[$pass_duration]['attributes'] = $variation['attributes'];
  // }
@endphp
@if (!empty($states))
  @foreach ($states as $state)
    @php
      var_dump($state);
    @endphp

    <div class="tooltip" id="{{the_title()}}">
      <div class="state">{{ the_title() }}</div>
      <div class="variation">
        <div class="price">
          ${{ $pass['price'] }}
        </div>
        <div class="duration">
          {{ $pass['label'] }}
        </div>
        <div class="buy">
          <a rel="nofollow" href="{!! do_shortcode('[add_to_cart_url id="' . $pass['variation_id'] . '"]') !!}" class="btn">Buy Now</a>
          {{-- <a ref="nofollow" class="btn" href="/buy-now#purchase">Buy Now</a> --}}
        </div>
      </div>
    </div>
  @endforeach
@endif

@php (wp_reset_postdata())
