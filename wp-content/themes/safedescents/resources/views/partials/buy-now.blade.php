<div class="buynow">
  <form action="" method="POST" class="zipcode">
    <p>To get started, enter your home zip code.</p>
    <label class="hidden-label" for="zip-code">Zip code</label>
    <input type="text" id="zip-code" name="zip-code" placeholder="zip code" required data-value-missing="This field is required!"/>
    <button type="submit" class="check-availability">Check availability</button>
  </form>

  <section class="passes">

      {{-- <div class="variation">
        <div class="state-name">State Name</div>
        <div class="duration">Season Pass</div>
        <div class="price" id="season-price">$</div>
        <div class="multiplier">Per Person</div>
        <a ref="nofollow" id="buy-season" href="/buy-now/?configuration_id=" class="btn buy-season">Buy Now</a>
      </div>

      <div class="variation">
        <div class="state-name">State Name</div>
        <div class="duration">Daily Pass</div>
        <div class="price" id="daily-price">$</div>
        <div class="multiplier">Per Person Per Day</div>
        <a ref="nofollow" id="buy-daily" href="/buy-now/?configuration_id=" class="btn buy-daily">Buy Now</a>
      </div> --}}

    <form action="/buy-now/" method="GET" class="variation">
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

    <form action="/buy-now/" method="GET" class="variation">
      <input type="hidden" id="daily-cid" name="configuration_id" value="" />
      <div class="state-name">State Name</div>
      <div class="duration">Daily Pass</div>
      <div class="price" id="daily-price">$</div>
      <div class="multiplier">Per Person Per Day</div>
      <button type="submit" class="btn buy-daily">Buy Now</button>
    </form>
  </section>
</div>
