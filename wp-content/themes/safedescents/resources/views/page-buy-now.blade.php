@extends('layouts.app')

@section('content')
  <ol class="checkout-progress" tabindex="0" role="progressbar"
  		aria-valuemin="1" aria-valuemax="4"
  		aria-valuenow="1" aria-valuetext="Step 1 of 4: Zip Code">
  	<li aria-hidden="true" data-step-current>Check Availability</li>
  	<li aria-hidden="true" data-step-incomplete>Select Coverage</li>
  	<li aria-hidden="true" data-step-incomplete>Skiers</li>
  	<li aria-hidden="true" data-step-incomplete>Checkout</li>
  </ol>

  <div id="check-availability" class="form-step" data-section-number="1" aria-hidden="false">
  	<h2>Buy Now</h2>
    <p>To get started, enter your home zip code.</p>
  	<label for="zip-code">Zip code</label>
  	<input type="text" id="zip-code" value="" />
  	<button class="btn" id="check-zip">Next Step</button>
  </div>

  <div id="not-available" class="not-available" aria-hidden="true">
    <h2>Safe Descents is not available here yet</h2>
    <p>We're expecting to roll it out to <span id="na-state-name">your state</span> in ______________.</p>
    <p>Enter your email address to get notified!</p>
    [EMAIL FORM]
  </div>

  <div id="select-coverage" class="form-step" data-section-number="2" aria-hidden="true">
    <h2>Select Coverage</h2>
    <h3>Residence State: <span id="coverage-state-name">State Name</span></h3>
    <div class="row">
      <div class="col s6" id="coverage-season-pass" role="button">
        <h4>Season Pass</h4>
        <p class="price">$</p>
      </div>
      <div class="col s6" id="coverage-daily-pass" role="button">
        <h4>Daily Pass</h4>
        <p class="price">$</p>
      </div>
    </div>
  </div>

  <div id="skiers" class="form-step" data-section-number="3" aria-hidden="true">
    <h2>Skiers/Boarders</h2>
    <p>Please enter the name and birthdate of each skier or snowboarder. All individuals must reside at the same address in order to purchase insurance together. For individuals with different residences, please purchase policies separately.</p>
  </div>
@endsection
