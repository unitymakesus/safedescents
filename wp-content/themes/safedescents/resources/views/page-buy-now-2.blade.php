{{--
  Template Name: Buy Now Template
--}}

@extends('layouts.app')

@section('content')
<section class="wrapper buy-now">
  <ul id="progressbar" tabindex="0" role="progressbar">
    <li aria-hidden="true">Select Coverage</li>
    <li aria-hidden="false" class="active">Skier Info</li>
    <li aria-hidden="true">Billing Info</li>
  </ul>

  <form id="buynowform">
    <section id="skiersinfo" class="formtab">
      <h2>Skiers/Boarders</h2>
      <p>Please enter the name and birthdate of each skier or snowboarder. All individuals must reside at the same address in order to purchase insurance together. For individuals with different residences, please purchase policies separately.</p>

      <fieldset class="skier-container">
        <legend>Covered Individual <span class="remove"></span></legend>
        <label for="first-name">First Name</label>
        <input type="text" name="first-name[]" id="first-name" value="" />
        <label for="last-name">Last Name</label>
        <input type="text" name="last-name[]" id="last-name" value="" />
        <label for="birthdate">Birth Date</label>
        <input type="date" name="birthdate[]" id="birthdate" value="" />
      </fieldset>
    </section>

    <button id="add-skier" class="button" name="add_skier">Add Skier/Boarder</button>

  </form>
</section>
@endsection
