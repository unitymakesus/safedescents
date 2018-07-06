{{--
  Template Name: Buy Now Template
--}}

@extends('layouts.app')

@section('content')
<section class="wrapper buy-now">
  <ul id="progressbar" tabindex="0" role="progressbar">
    <li aria-hidden="false" class="active">Location</li>
    <li aria-hidden="true">Type of Pass</li>
    <li aria-hidden="true">Skier Info</li>
    <li aria-hidden="true">Checkout</li>
  </ul>

  <form id="buynowform">
    <fieldset id="location" class="form-tab">
      <h2>Buy Now</h2>
      <p>To get started, enter your home zip code.</p>
      <label for="zip-code">Zip code</label>
      <input type="text" id="zip-code" name="zipcode" value="" required/>
    </fieldset>

    <fieldset id="coveragetype" class="form-tab">
      <h2>Residence State: <span id="coverage-state-name">State Name</span></h2>
      <section>
        <input type="radio" name="type" value="season" required />
        <div id="coverage-season-pass" class="coverage-btn">
          <h4>Season Pass</h4>
          <p class="price">$</p>
        </div>
        <input type="radio" name="type" value="daily" required />
        <div id="coverage-daily-pass" class="coverage-btn">
          <h4>Daily Pass</h4>
          <p class="price">$</p>
        </div>
      </section>
    </fieldset>

    <fieldset id="skiersinfo" class="form-tab">
      <h2>Skiers/Boarders</h2>
      <p>Please enter the name and birthdate of each skier or snowboarder. All individuals must reside at the same address in order to purchase insurance together. For individuals with different residences, please purchase policies separately.</p>

      <div class="skier-container">
        <h3>Covered Individual</h3>
        <label for="first-name-1">First Name</label>
        <input type="text" name="first-name-1" id="first-name-1" value="" />
        <label for="last-name-1">Last Name</label>
        <input type="text" name="last-name-1" id="last-name-1" value="" />
        <label for="birthdate-1">Birth Date</label>
        <input type="date" name="birthdate-1" id="birthdate-1" value="" />
      </div>

      <button id="add-skier" class="button" name="add_skier">Add Skier/Boarder</button>
    </fieldset>


    <div class="buynow-buttons">
      <button class="btn" id="prev-btn">Previous</button>
      <button class="btn" id="next-btn">Next</button>
    </div>

    <div id="not-available" aria-hidden="true">
      <h2>Safe Descents is not available here yet</h2>
      <p>We're expecting to roll it out to <span id="na-state-name">your state</span> in ______________.</p>
      <p>Enter your email address to get notified!</p>
      [EMAIL FORM]
    </div>
  </form>
</section>
@endsection
