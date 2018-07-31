<div class="buynow">
  <form action="" method="POST" class="zipcode">
    <p>To get started, enter your home zip code.</p>
    <label class="hidden-label" for="zip-code">Zip code</label>
    <input type="text" id="zip-code" name="zip-code" placeholder="zip code" required data-value-missing="This field is required!"/>
    <button type="submit" class="check-availability">Check availability</button>
  </form>

  <section class="passes">
    <form action="/buy-now/" method="GET" class="variation avail">
      <input type="hidden" id="season-cid" name="configuration_id" value="" />
        <input type="hidden" class="city" name="city" value="" />
        <input type="hidden" class="state" name="state" value="" />
        <input type="hidden" class="zip" name="zip" value="" />
      <div class="state-name">State Name</div>
      <div class="duration">Season Pass</div>
      <div class="price" id="season-price">$</div>
      <div class="multiplier">Per Person</div>
      <button type="submit" class="btn buy-season">Buy Now</button>
    </form>

    <form action="/buy-now/" method="GET" class="variation avail">
      <input type="hidden" id="daily-cid" name="configuration_id" value="" />
      <div class="state-name">State Name</div>
      <div class="duration">Daily Pass</div>
      <div class="price" id="daily-price">$</div>
      <div class="multiplier">Per Person Per Day</div>
      <button type="submit" class="btn buy-daily">Buy Now</button>
    </form>

    <div class="variation not-avail">
      <p>Please enter your email below to be notified as soon as Safe Descents is available in your state.</p>
      {!! do_shortcode('[contact-form-7 id="377" title="State Interest Form"]') !!}
    </div>
  </section>
</div>
