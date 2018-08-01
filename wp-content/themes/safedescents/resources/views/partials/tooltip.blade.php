@php
  $states_json = file_get_contents(get_template_directory() . '/../app/api-products.json');

  if (!empty($states_json)) {
    $states = json_decode($states_json);
  }
@endphp

  <div class="coverage-details placeholder" data-state="{{ $state->location }}">
    Select your state to check availability.
  </div>

  <div class="coverage-mobile-select">
    <select required name="coverage_select" id="coverage_select">
      <option value="">Select an option…</option>
      <option value="AL">Alabama</option>
      <option value="AZ">Arizona</option>
      <option value="AR">Arkansas</option>
      <option value="CA">California</option>
      <option value="CO">Colorado</option>
      <option value="CT">Connecticut</option>
      <option value="DE">Delaware</option>
      <option value="DC">District Of Columbia</option>
      <option value="FL">Florida</option>
      <option value="GA">Georgia</option>
      <option value="ID">Idaho</option>
      <option value="IL">Illinois</option>
      <option value="IN">Indiana</option>
      <option value="IA">Iowa</option>
      <option value="KS">Kansas</option>
      <option value="KY">Kentucky</option>
      <option value="LA">Louisiana</option>
      <option value="ME">Maine</option>
      <option value="MD">Maryland</option>
      <option value="MA">Massachusetts</option>
      <option value="MI">Michigan</option>
      <option value="MN">Minnesota</option>
      <option value="MS">Mississippi</option>
      <option value="MO">Missouri</option>
      <option value="MT">Montana</option>
      <option value="NE">Nebraska</option>
      <option value="NV">Nevada</option>
      <option value="NH">New Hampshire</option>
      <option value="NJ">New Jersey</option>
      <option value="NM">New Mexico</option>
      <option value="NY">New York</option>
      <option value="NC">North Carolina</option>
      <option value="ND">North Dakota</option>
      <option value="OH">Ohio</option>
      <option value="OK">Oklahoma</option>
      <option value="OR">Oregon</option>
      <option value="PA">Pennsylvania</option>
      <option value="RI">Rhode Island</option>
      <option value="SC">South Carolina</option>
      <option value="SD">South Dakota</option>
      <option value="TN">Tennessee</option>
      <option value="TX">Texas</option>
      <option value="UT">Utah</option>
      <option value="VT">Vermont</option>
      <option value="VA">Virginia</option>
      <option value="WA">Washington</option>
      <option value="WV">West Virginia</option>
      <option value="WI">Wisconsin</option>
      <option value="WY">Wyoming</option>
    </select>
  </div>

@if (!empty($states))
  @foreach ($states as $state)
    <div class="coverage-details coverage-state available" data-state="{{ $state->location }}">
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

<div class="coverage-details coverage-state not-available">
  <p class="state-name">Coming Soon</p>
  <p>Get notified as soon as Safe Descents is available.</p>
  {!! do_shortcode('[contact-form-7 id="377" title="State Interest Form"]') !!}
</div>
