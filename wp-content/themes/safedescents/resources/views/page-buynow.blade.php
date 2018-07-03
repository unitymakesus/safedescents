{{--
  Template Name: Buy Now Template
--}}

@extends('layouts.app')

@section('content')
<section class="wrapper buy-now">
  <ul id="progressbar" tabindex="0" role="progressbar">
    <li aria-hidden="true" class="active">Location</li>
    <li aria-hidden="true">Type of Pass</li>
    <li aria-hidden="true">Skier Info</li>
    <li aria-hidden="true">Addl Details</li>
  </ul>

  <div id="location" class="form-tab">
    <h2>Buy Now</h2>
    <p>To get started, enter your home zip code.</p>
    <label for="zip-code">Zip code</label>
    <input type="text" id="zip-code" value="" />
  </div>

  <div id="coveragetype" class="form-tab">
    <h2>Residence State: <span id="coverage-state-name">State Name</span></h2>
    <section>
      <button id="coverage-season-pass" class="coverage-btn" role="button">
        <h4>Season Pass</h4>
        <p class="price">$</p>
      </button>
      <button id="coverage-daily-pass" class="coverage-btn" role="button">
        <h4>Daily Pass</h4>
        <p class="price">$</p>
      </button>
    </section>
  </div>

  <div id="addskiers" class="form-tab">
    <h2>Skiers/Boarders</h2>
    <p>Please enter the name and birthdate of each skier or snowboarder. All individuals must reside at the same address in order to purchase insurance together. For individuals with different residences, please purchase policies separately.</p>

    <div class="skier-container">
      <aside class="new-skier">
        <p>Skier Information</p>
        <label>First Name:</label><input type="text" />
        <label>Last Name:</label><input type="text" />
        <label>Date of Birth:</label><input type="date" />
      </aside>
    </div>
    <button id="add-skier">add skier</button>
  </div>

  <div id="addlinfo" class="form-tab">
    <h2>Additional Info</h2>
    <p>Hotel and waiver</p>
  </div>

  <div class="buynow-buttons">
    <button class="btn" id="prev-btn">Previous</button>
    <button class="btn" id="next-btn">Next</button>
  </div>
</section>
@endsection
