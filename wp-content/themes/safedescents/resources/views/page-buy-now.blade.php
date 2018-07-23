{{--
  Template Name: Buy Now Template
--}}

@extends('layouts.app')

@section('content')
<section class="wrapper buy-now">
  <div class="row">
    <div class="col-sm-12 col-md-9">
      <form id="buynowform" action="" method="POST">
        <section id="coverageinfo" class="formtab">
          @php
            $states_json = file_get_contents(get_template_directory() . '/../app/sdk/api-products.json');

            if (!empty($states_json)) {
              $states = json_decode($states_json);
            }

            foreach ($states as $state) {
              foreach ($state->variations as $variation) {
                if ($variation->configuration_id == $_REQUEST['configuration_id']) {
                  $order_config['id'] = $_REQUEST['configuration_id'];
                  $order_config['state'] = $state->location;
                  $order_config['variation'] = $variation->description;
                  $order_config['price'] = $variation->price;
                  break;
                }
              }
            }
          @endphp
          <input type="hidden" name="config_id" value="{{ $order_config['id'] }}" />
          <input type="hidden" name="config_state" value="{{ $order_config['state'] }}" />
          <input type="hidden" name="config_variation" value="{{ $order_config['variation'] }}" />
          <input type="hidden" name="config_price" value="{{ $order_config['price'] }}" />
          <input type="hidden" name="config_quantity" value="1" />
        </section>

        <section id="tripdetails" class="formtab active">
          <h2>Trip Details</h2>
          <fieldset>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label for="start-date">Start Date</label>
                <input type="date" name="start-date" required value="" />
              </div>
              <div class="col-sm-12 col-md-6">
                <label for="End-date">End Date</label>
                <input type="date" name="end-date" required value="" />
              </div>
            </div>

            <label for="destination">Destination</label>
            <p>Please enter the name of the resort you will be visiting or the pass you will be using. This insurance only provides coverage for activities and/or accidents that occur within in the Continental United State. No coverage is available within Alaska or Hawaii.</p>
            <input type="text" name="destination" required value="" />
            <a class="btn continue">Continue</a>
          </fieldset>
        </section>


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

              <!-- <button id="add-skier" class="button" name="add_skier">+</button> -->
              <a class="btn continue">Continue</a>
            </fieldset>
        </section>
<!--
        <section id="skiersinfo" class="formtab">
          <h2>Skiers/Boarders</h2>
          <p>Please enter the name and birthdate of each skier or snowboarder. All individuals must reside at the same address in order to purchase insurance together. For individuals with different residences, please purchase policies separately.</p>

          <div class="addskier-container">
            <fieldset class="skier-container">
              <legend>Covered Individual <span class="remove"></span></legend>
              <label for="first-name">First Name</label>
              <input type="text" name="first-name[]" id="first-name" value="" />
              <label for="last-name">Last Name</label>
              <input type="text" name="last-name[]" id="last-name" value="" />
              <label for="birthdate">Birth Date</label>
              <input type="date" name="birthdate[]" id="birthdate" value="" />
            </fieldset>

            <button id="add-skier" class="button" name="add_skier">+</button>
          </div>
          <a class="btn continue">Continue</a>
        </section> -->

        <section id="residenceinfo" class="formtab">
          <h2>Residence Address</h2>
          <fieldset>
            <legend>Residence Address</legend>
            <div class="row">
              <label for="residence_address_1" class="">Street address&nbsp;<abbr class="required" title="required">*</abbr></label>
              <input type="text" class="" name="residence_address_1" id="residence_address_1" placeholder="House number and street name" value="" autocomplete="address-line1" />
              <input type="text" class="" name="residence_address_2" id="residence_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="" autocomplete="address-line2">
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-5">
                <label for="residence_city" class="">Town / City&nbsp;<abbr class="required" title="required">*</abbr></label>
                <input type="text" class="" name="residence_city" id="residence_city" placeholder="" value="{{ $_REQUEST['city'] }}" autocomplete="address-level2">
              </div>
              <div class="col-sm-12 col-md-4">
                <label for="residence_state" class="">State&nbsp;<abbr class="required" title="required">*</abbr></label>
                <select name="residence_state" id="residence_state" class="browser-default">
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
              <div class="col-sm-12 col-md-3">
                <label for="residence_postcode" class="">ZIP&nbsp;<abbr class="required" title="required">*</abbr></label>
                <input type="text" class="" name="residence_postcode" id="residence_postcode" placeholder="" value="{{ $_REQUEST['zip'] }}" autocomplete="postal-code">
              </div>
            </div>
            <a class="btn continue">Continue</a>
          </fieldset>
        </section>

        <section id="billinginfo" class="formtab">
          <h2>Billing Information</h2>
          <fieldset>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label for="billing_first_name" class="">First name&nbsp;<abbr class="required" title="required">*</abbr></label>
                <input type="text" class="" name="billing_first_name" id="billing_first_name" placeholder="" value="" autocomplete="given-name" />
              </div>
              <div class="col-sm-12 col-md-6">
                <label for="billing_last_name" class="">Last name&nbsp;<abbr class="required" title="required">*</abbr></label>
                <input type="text" class="" name="billing_last_name" id="billing_last_name" placeholder="" value="" autocomplete="family-name" />
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label for="billing_email" class="">Email address&nbsp;<abbr class="required" title="required">*</abbr></label>
                <input type="email" class="" name="billing_email" id="billing_email" placeholder="" value="" autocomplete="email">
              </div>
              <div class="col-sm-12 col-md-6">
                <label for="billing_phone" class="">Phone&nbsp;<abbr class="required" title="required">*</abbr></label>
                <input type="tel" class="" name="billing_phone" id="billing_phone" placeholder="" value="" autocomplete="tel">
              </div>
            </div>

            <div class="row">
              <label for="billing_address_1" class="">Street address&nbsp;<abbr class="required" title="required">*</abbr></label>
              <input type="text" class="" name="billing_address_1" id="billing_address_1" placeholder="House number and street name" value="" autocomplete="address-line1" />
              <input type="text" class="" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="" autocomplete="address-line2">
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-5">
                <label for="billing_city" class="">Town / City&nbsp;<abbr class="required" title="required">*</abbr></label>
                <input type="text" class="" name="billing_city" id="billing_city" placeholder="" value="" autocomplete="address-level2">
              </div>
              <div class="col-sm-12 col-md-4">
                <label for="billing_state" class="">State&nbsp;<abbr class="required" title="required">*</abbr></label>
                <select name="billing_state" id="billing_state" class="browser-default" autocomplete="address-level1">
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
              <div class="col-sm-12 col-md-3">
                <label for="billing_postcode" class="">ZIP&nbsp;<abbr class="required" title="required">*</abbr></label>
                <input type="text" class="" name="billing_postcode" id="billing_postcode" placeholder="" value="" autocomplete="postal-code">
              </div>
            </div>
          </fieldset>
        </section>

        <section id="confirmation" class="formtab">
          <h2>Review</h2>
          <fieldset>
            <input type="checkbox" name="confirmation" value="accept" id="confirmation" />
            <label for="confirmation">By checking here, I confirm that I have read, understood and agree to the <a href="/terms-and-conditions/">Terms & Conditions</a> and <a href="/privacy-policy/">Privacy Policy</a> of this website, the <a href="#">Policy which contains reductions, limitations, exclusions (See Section VI.) and termination provisions</a> and the <a href="#">Notice and Consent</a>, including the receipt of electronic notices. Full details of the coverage are contained in the policy.</label>

            @if (function_exists('wp_stripe_checkout_get_option'))
                @php
                  $options = wp_stripe_checkout_get_option();
                  $key = $options['stripe_publishable_key'];
                  if(WP_STRIPE_CHECKOUT_TESTMODE){
                      $key = $options['stripe_test_publishable_key'];
                  }
                @endphp

                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-email="alisa@unitymakes.us" data-allow-remember-me="false" data-name="Safe Descents Insurance" data-description="{{ $order_config['state'] }}: {{ $order_config['variation'] }} x 1" data-amount="{{ str_replace('.', '', $order_config['price']) }}" data-label="Pay Now" data-key="{{ $key }}" data-currency="USD"></script>
                {!! wp_nonce_field('wp_stripe_checkout', '_wpnonce', true, false) !!}
                <input type="hidden" name="_wp_http_referer" value="/buy-now/?configuration_id=67">
                <input type="hidden" value="{{ $order_config['state'] }}" name="item_name">
                <input type="hidden" value="{{ str_replace('.', '', $order_config['price']) }}" name="item_amount">
                <input type="hidden" value="USD" name="item_currency">
                <input type="hidden" value="{{ $order_config['variation'] }}" name="item_description">
                <input type="hidden" value="1" name="wp_stripe_checkout">
            @endif
          </fieldset>
        </section>
      </form>
    </div>

    <div id="sticky-cart" class="col-sm-12 col-md-3">
      <p>this is the sidebar</p>
    </div>
  </div>
</section>
@endsection
