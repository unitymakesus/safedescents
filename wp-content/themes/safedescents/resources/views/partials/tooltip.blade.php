@php
  $states_json = file_get_contents(get_template_directory() . '/../app/api-products.json');

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
      //var_dump($state);
    @endphp

    <div class="available" data-state="{{ $state->location }}">
      <p class="state-name">{{ $state->location }}</p>

      @foreach ($state->variations as $variation)
        <div class="variation">
          <div class="duration">
            {{ $variation->description }}
          </div>
          <div class="price">
            ${{ $variation->price }}
          </div>
          <div class="multiplier">
            @if ($variation->description == 'Daily Pass')
              Per Person Per Day
            @elseif ($variation->description == 'Season Pass')
              Per Person
            @endif
          </div>
          <a ref="nofollow" class="btn" href="/buy-now/?configuration_id={{ $variation->configuration_id }}">Buy Now</a>
        </div>
      @endforeach

    </div>
  @endforeach
@endif

@php (wp_reset_postdata())

<div class="tooltip not-available">
  <p class="state-name">Coming Soon</p>
  <p>Get notified as soon as Safe Descents is available.</p>
  {!! do_shortcode('[contact-form-7 id="377" title="State Interest Form"]') !!}
</div>
