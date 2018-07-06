<form id="buynow">
  <section class="zipcode">
    <p>To get started, enter your home zip code.</p>
    <label class="hidden-label" for="zip-code">Zip code</label>
    <input type="text" id="zip-code" name="zip-code" placeholder="zip code" required data-value-missing="This field is required!"/>
    <button class="btn-alt check-availability">Check availability</button>
  </section>

  <section class="passes">
    <article>
      <p class="state-name">State Name</p>
      <p>Season Pass</p>
      <p class="season-price">$</p>
      <button class="btn buy-season">Buy Now</button>
    </article>

    <article>
      <p class="state-name">State Name</p>
      <p>Daily Pass</p>
      <p class="daily-price">$</p>
      <button class="btn buy-daily">Buy Now</button>
    </article>
  </section>
</form>
