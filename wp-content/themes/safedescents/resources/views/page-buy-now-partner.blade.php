{{--
Template Name: Buy Now Partner Template
--}}

@extends('layouts.app')

@php
  $test_mode = get_field('test_mode', 'option');
  if ($test_mode == true) {
    $key = get_field('test_api_publishable_key', 'option');
  } else {
    $key = get_field('live_api_publishable_key', 'option');
  }
@endphp

@if (array_key_exists('confirm', $_GET))
  {{-- Checkout Processing --}}
  @if (array_key_exists('stripe_token', $_REQUEST))
    @php App\sd_checkout() @endphp

    @section('content')
      <div class="wrapper content-wrapper vertical-padding">
        <p>Thank you for purchasing Safe Descents Ski and Snowboarding Evacuation Insurance. Keep an eye on your email <strong>{{ $_REQUEST['billing_email'] }}</strong> for your receipt and confirmation documents.</p>
        <p>The mountains are calling. Have a great time and remember we've got your back.</p>
        <p>Warmly,<br />
          All of us at Safe Descents</p>
      </div>
    @endsection

  @else
    @section('content')
      <section class="buy-now container">
        <div class="row">
          <div class="col-xs-12 col-sm-12">
            @include('partials.buy-now')
          </div>
        </div>
      </section>
    @endsection
  @endif
@else
  @section('content')
    <section class="buy-now-partner container">
      <div class="col-sm-12 col-md-12">
        <form id="buynowpartnerform" class="buynowpartnerform" action="/buy-now/?confirm=success" method="POST">
          <fieldset class="hidden">
            @php
            $states_json = file_get_contents(get_template_directory() . '/../app/api-products.json');

            if (!empty($states_json)) {
              $states = json_decode($states_json);
            }
            @endphp
            <script>;
              window.states = @php echo $states_json; @endphp;
            </script>
            @php
            foreach ($states as $state) {
              foreach ($state->variations as $variation) {
                if ($variation->configuration_id == $_REQUEST['configuration_id']) {
                  $order_config['id'] = $_REQUEST['configuration_id'];
                  $order_config['state'] = $state->location;
                  $order_config['variation'] = 'Season Pass';
                  $order_config['price'] = $variation->price;
                  break;
                }
              }
            }
            @endphp
            <input type="hidden" name="config_id" value="{{ $order_config['id'] }}" />
            <input type="hidden" name="config_state" value="{{ $order_config['state'] }}" />
            <input type="hidden" name="config_variation" value="Season Pass" />
            <input type="hidden" name="config_price" value="{{ $order_config['price'] }}" />
          </fieldset>
           <div class="partner-sticky-cart">
            <div id="sticky-cart">
              <dl>
                <dt class="plan">Plan:</dt>
                <dd class="plan">Season Pass</dd>
                <dt class="state">Resident State:</dt>
                <dd class="state">{{ $order_config['state'] }}</dd>
                <dt class="hidden dates">Start Date:</dt>
                <dd class="hidden dates"></dd>
                <dt class="hidden length">Trip Length:</dt>
                <dd class="hidden length"></dd>
                <dt class="hidden number">Number Insured:</dt>
                <dd class="hidden number"></dd>
                <dt class="hidden total">Total Cost:</dt>
                <dd class="hidden total"><strong>{{ $order_config['price'] }}</strong></dd>
              </dl>
            </div>
          </div>

            <!-- @if ($order_config['variation'] == 'Daily Pass')
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <label for="start-date">Start Date&nbsp;<abbr class="req" title="Required">*</abbr></label>
                  <input required type="date" name="start-date" required value="" />
                </div>
                <div class="col-sm-12 col-md-6">
                  <label for="start-date">Number of Days&nbsp;<abbr class="req" title="Required">*</abbr></label>
                  <input required type="number" name="duration" required value="1" step="1" min="1" />
                </div>
              </div>
            @endif -->

            
            <div id="partner-info" class="partner-info row" style="padding-top:50px;">
          
            </div>
            <div class="row pass-select">
              <div class="col-sm-12 col-md-6 pass-choice pass-choice-active" data-pass-choice="Season Pass">
                <h4>Season Pass</h4>
                <label>Good for the 18/19 Ski Season</label>
                <a id="select-season-pass" class="placeholder btn">Select</a>
              </div>
              <div class="col-sm-12 col-md-6 pass-choice" data-pass-choice="Daily Pass">
                <h4>Daily Pass</h4>
                <div id="daily-fields" class="row">
                  <div class="col-sm-12 col-md-6">
                    <label for="start-date">Start Date&nbsp;<abbr class="req" title="Required">*</abbr></label>
                    <input required type="date" name="start-date" class="start-date" required value="@php echo date('Y-m-d') @endphp" />
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <label for="start-date">Number of Days&nbsp;<abbr class="req" title="Required">*</abbr></label>
                    <input required type="number" name="duration" class="day-length" required value="1" step="1" min="1" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <p class="pass-read-more col-sm-12">Read More About The Coverage</p>
            </div>
            <div id="read-more" class="row hidden">
              <div class="col-sm-12">
                <h2>Safe Descents covers up to $25,000 for emergency medical evacuation</h2>
                <h4>(HEALTH INSURANCE DOESN’T ALWAYS COVER THESE COSTS)</h4>
                <p>Which Pays For:</p>
                <ul>
                  <li>The costs to get you off the mountain (Field Rescue)</li>
                  <li>The costs of an ambulance, helicopter, or plane to get you to the nearest hospital (Emergency Medical Evacuation)</li>
                  <li>The costs to transport you to a hospital or medical facility close to your home (Medical Repatriation)</li>
                  <li>The costs for someone to accompany you or your children back home (Medical Escort)</li>
                  <li>The costs to travel home if your original travel reservation needs to be adjusted due to an injury</li>
                </ul>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <h4>Skier Information</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <label for="first-name">First Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="first-name[]" id="first-name" value="" />
              </div>
              <div class="col-sm-12 col-md-4">
                <label for="last-name">Last Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="last-name[]" id="last-name" value="" />
              </div>
              <div class="col-sm-12 col-md-4">
                <label for="birthdate">Birth Date&nbsp;<abbr class="req" title="Required" autocomplete="bday">*</abbr></label>
                <input required type="text" data-inputmask name="birthdate[]" id="birthdate" placeholder="dd/mm/yyyy" value="" />
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <label for="residence_address_1" class="">Street Address&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="textarea" rows="10" class="" name="residence_address_1" id="residence_address_1" placeholder="House number and street name (555 Main Street)" value="" autocomplete="address-line1" />
                <input type="text" class="" name="residence_address_2" id="residence_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="" autocomplete="address-line2">
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <label for="residence_city" class="">Town / City&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" class="" name="residence_city" id="residence_city" placeholder="" value="{{ $_REQUEST['city'] }}" autocomplete="address-level2">
              </div>
              <div class="col-sm-12 col-md-4">
                <label for="residence_state" class="">State&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <select required name="residence_state" id="residence_state" class="browser-default" autocomplete="address-level1">
                  <option value="">Select an option…</option>
                  <option value="Alabama">Alabama</option>
                  <option value="Airzona">Arizona</option>
                  <option value="Arkansas">Arkansas</option>
                  <option value="California">California</option>
                  <option value="Colorado">Colorado</option>
                  <option value="Connecticut">Connecticut</option>
                  <option value="Delaware">Delaware</option>
                  <option value="Distric of Columnia">District Of Columbia</option>
                  <option value="Florida">Florida</option>
                  <option value="Georgia">Georgia</option>
                  <option value="Idaho">Idaho</option>
                  <option value="Illinois">Illinois</option>
                  <option value="Indiana">Indiana</option>
                  <option value="Iowa">Iowa</option>
                  <option value="Kansas">Kansas</option>
                  <option value="Kentucky">Kentucky</option>
                  <option value="Louisiana">Louisiana</option>
                  <option value="Maine">Maine</option>
                  <option value="Maryland">Maryland</option>
                  <option value="Masssachusetts">Massachusetts</option>
                  <option value="Michigan">Michigan</option>
                  <option value="Minnesota">Minnesota</option>
                  <option value="Mississippi">Mississippi</option>
                  <option value="Missouri">Missouri</option>
                  <option value="Montana">Montana</option>
                  <option value="Nebraska">Nebraska</option>
                  <option value="Nevada">Nevada</option>
                  <option value="New Hampshire">New Hampshire</option>
                  <option value="New Jersey">New Jersey</option>
                  <option value="New Mexico">New Mexico</option>
                  <option value="New York">New York</option>
                  <option value="North Carolina">North Carolina</option>
                  <option value="North Dakota">North Dakota</option>
                  <option value="Ohio">Ohio</option>
                  <option value="Oklahoma">Oklahoma</option>
                  <option value="Oregon">Oregon</option>
                  <option value="Pennsylvania">Pennsylvania</option>
                  <option value="Rhode Island">Rhode Island</option>
                  <option value="South Carolina">South Carolina</option>
                  <option value="South Dakota">South Dakota</option>
                  <option value="Tennessee">Tennessee</option>
                  <option value="Texas">Texas</option>
                  <option value="Utah">Utah</option>
                  <option value="Vermont">Vermont</option>
                  <option value="Virginia">Virginia</option>
                  <option value="Washington">Washington</option>
                  <option value="West Virginia">West Virginia</option>
                  <option value="Wisconsin">Wisconsin</option>
                  <option value="Wyoming">Wyoming</option>
                </select>
              </div>
              <div class="col-sm-12 col-md-4">
                <label for="residence_postcode" class="">Zip Code&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" class="" name="residence_postcode" id="residence_postcode" placeholder="" value="{{ $_REQUEST['zip'] }}" autocomplete="postal-code">
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <label for="contact_email" class="">Contact Email&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="email" name="contact_email[]" id="contact_email" value="" autocomplete="email">
              </div>
              <div class="col-sm-12 col-md-4">
                <label for="contact_phone" class="">Contact Phone&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="tel" name="contact_phone[]" id="contact_phone" value="" autocomplete="tel">
              </div>
              <div class="col-sm-12 col-md-4">
                <a id="add-skier-in-household" class="submit btn">Add Skier in Household</a>
              </div>
            </div>
            <div class="row additional-skiers hidden">
              <div class="col-sm-12">
                <h4>Additional Skiers</h4>
              </div>
              <div class="additional-skier-1 col-sm-12 col-md-3 hidden">
                <label for="first-name">First Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="first-name[]" id="first-name2" value="" />
                <label for="last-name">Last Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="last-name[]" id="last-name2" value="" />
                <label for="birthdate">Birth Date&nbsp;<abbr class="req" title="Required" autocomplete="bday">*</abbr></label>
                <input required type="text" data-inputmask name="birthdate[]" id="birthdate2" placeholder="dd/mm/yyyy" value="" />
                <label for="contact_email" class="">Contact Email&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="email" name="contact_email[]" id="contact_email2" value="" autocomplete="email">
                <label for="contact_phone" class="">Contact Phone&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="tel" name="contact_phone[]" id="contact_phone2" value="" autocomplete="tel">
                <a class="btn remove-additional">Remove Skier</a>
              </div>
              <div class="additional-skier-2 col-sm-12 col-md-3 hidden">
                <label for="first-name">First Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="first-name[]" id="first-name3" value="" />
                <label for="last-name">Last Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="last-name[]" id="last-name3" value="" />
                <label for="birthdate">Birth Date&nbsp;<abbr class="req" title="Required" autocomplete="bday">*</abbr></label>
                <input required type="text" data-inputmask name="birthdate[]" id="birthdate3" placeholder="dd/mm/yyyy" value="" />
                <label for="contact_email" class="">Contact Email&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="email" name="contact_email[]" id="contact_emai3l" value="" autocomplete="email">
                <label for="contact_phone" class="">Contact Phone&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="tel" name="contact_phone[]" id="contact_phone3" value="" autocomplete="tel">
                <a class="btn remove-additional">Remove Skier</a>
              </div>
              <div class="additional-skier-3 col-sm-12 col-md-3 hidden">
                <label for="first-name">First Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="first-name[]" id="first-name4" value="" />
                <label for="last-name">Last Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="last-name[]" id="last-name4" value="" />
                <label for="birthdate">Birth Date&nbsp;<abbr class="req" title="Required" autocomplete="bday">*</abbr></label>
                <input required type="text" data-inputmask name="birthdate[]" id="birthdate4" placeholder="dd/mm/yyyy" value="" />
                <label for="contact_email" class="">Contact Email&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="email" name="contact_email[]" id="contact_email4" value="" autocomplete="email">
                <label for="contact_phone" class="">Contact Phone&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="tel" name="contact_phone[]" id="contact_phone4" value="" autocomplete="tel">
                <a class="btn remove-additional">Remove Skier</a>
              </div>
              <div class="additional-skier-4 col-sm-12 col-md-3 hidden">
                <label for="first-name">First Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="first-name[]" id="first-name5" value="" />
                <label for="last-name">Last Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" name="last-name[]" id="last-name5" value="" />
                <label for="birthdate">Birth Date&nbsp;<abbr class="req" title="Required" autocomplete="bday">*</abbr></label>
                <input required type="text" data-inputmask name="birthdate[]" id="birthdate5" placeholder="dd/mm/yyyy" value="" />
                <label for="contact_email" class="">Contact Email&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="email" name="contact_email[]" id="contact_email5" value="" autocomplete="email">
                <label for="contact_phone" class="">Contact Phone&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="tel" name="contact_phone[]" id="contact_phone5" value="" autocomplete="tel">
                <a class="btn remove-additional">Remove Skier</a>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <h4>Where do you plan on skiing/snowboarding?</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <!-- @if ($order_config['variation'] == 'Daily Pass')
                  <p style="margin-top: 0;">Where do you plan on skiing/snowboarding?</p>
                @else
                  <p style="margin-top: 0;">Where do you plan on skiing/snowboarding? (You may enter multiple locations)</p>
                @endif -->
                <input type="text" name="destination" value=""/>
                <p class="smaller-text">This insurance only provides coverage for activities and/or accidents that occur within in the Continental United States. No coverage is available within Alaska or Hawaii.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <h4>Billing Information</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label for="billing_first_name" class="">First Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" class="" name="billing_first_name" id="billing_first_name" placeholder="" value="" autocomplete="given-name" />
              </div>
              <div class="col-sm-12 col-md-6">
                <label for="billing_last_name" class="">Last Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" class="" name="billing_last_name" id="billing_last_name" placeholder="" value="" autocomplete="family-name" />
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label for="billing_address_1" class="">Street Address&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" class="" name="billing_address_1" id="billing_address_1" placeholder="House number and street name" value="" autocomplete="address-line1" />
                <input type="text" class="" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="" autocomplete="address-line2">
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4">
                <label for="billing_city" class="">Town / City&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" class="" name="billing_city" id="billing_city" placeholder="" value="" autocomplete="address-level2">
              </div>
              <div class="col-sm-12 col-md-4">
                <label for="billing_state" class="">State&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <select required name="billing_state" id="billing_state" class="browser-default" autocomplete="address-level1">
                  <option value="">Select an option…</option>
                  <option value="Alabama">Alabama</option>
                  <option value="Airzona">Arizona</option>
                  <option value="Arkansas">Arkansas</option>
                  <option value="California">California</option>
                  <option value="Colorado">Colorado</option>
                  <option value="Connecticut">Connecticut</option>
                  <option value="Delaware">Delaware</option>
                  <option value="Distric of Columnia">District Of Columbia</option>
                  <option value="Florida">Florida</option>
                  <option value="Georgia">Georgia</option>
                  <option value="Idaho">Idaho</option>
                  <option value="Illinois">Illinois</option>
                  <option value="Indiana">Indiana</option>
                  <option value="Iowa">Iowa</option>
                  <option value="Kansas">Kansas</option>
                  <option value="Kentucky">Kentucky</option>
                  <option value="Louisiana">Louisiana</option>
                  <option value="Maine">Maine</option>
                  <option value="Maryland">Maryland</option>
                  <option value="Masssachusetts">Massachusetts</option>
                  <option value="Michigan">Michigan</option>
                  <option value="Minnesota">Minnesota</option>
                  <option value="Mississippi">Mississippi</option>
                  <option value="Missouri">Missouri</option>
                  <option value="Montana">Montana</option>
                  <option value="Nebraska">Nebraska</option>
                  <option value="Nevada">Nevada</option>
                  <option value="New Hampshire">New Hampshire</option>
                  <option value="New Jersey">New Jersey</option>
                  <option value="New Mexico">New Mexico</option>
                  <option value="New York">New York</option>
                  <option value="North Carolina">North Carolina</option>
                  <option value="North Dakota">North Dakota</option>
                  <option value="Ohio">Ohio</option>
                  <option value="Oklahoma">Oklahoma</option>
                  <option value="Oregon">Oregon</option>
                  <option value="Pennsylvania">Pennsylvania</option>
                  <option value="Rhode Island">Rhode Island</option>
                  <option value="South Carolina">South Carolina</option>
                  <option value="South Dakota">South Dakota</option>
                  <option value="Tennessee">Tennessee</option>
                  <option value="Texas">Texas</option>
                  <option value="Utah">Utah</option>
                  <option value="Vermont">Vermont</option>
                  <option value="Virginia">Virginia</option>
                  <option value="Washington">Washington</option>
                  <option value="West Virginia">West Virginia</option>
                  <option value="Wisconsin">Wisconsin</option>
                  <option value="Wyoming">Wyoming</option>
                </select>
              </div>
              <div class="col-sm-12 col-md-4">
                <label for="billing_postcode" class="">Zip Code&nbsp;<abbr class="req" title="Required">*</abbr></label>
                <input required type="text" class="" name="billing_postcode" id="billing_postcode" placeholder="" value="" autocomplete="postal-code">
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <input required type="checkbox" name="confirmation" value="accept" id="confirmation" />
                <label for="confirmation" class="smaller-text confirmation">
                  <span class="confirm-span">Agree to Terms and Conditions:</span>
                  <br>By checking here, I confirm that I have read and understand the <a href="/full-policy-text/" target="_blank">Policy which contains reductions, limitations, exclusions (See Section VI), and termination of provisions</a>, the <a href="#" id="open-notice-and-consent">Notice of Consent</a> including the receipt of electronic notices, and the <a href="/fraud-disclosure/" target="_blank">Fraud Disclosure.</a> Full Details of the coverage are contained in the policy.<abbr class="req" title="Required">*</abbr></label>
                  
                <div class="hidden notice-and-consent">
                  <h4>Notice and Consent:</h4>
                  <p>When you click the button on this site to purchase insurance, you are submitting a request for coverage from the insurer. This request for coverage is considered an offer by you to the insurer. The insurer may decline to accept your offer, or your coverage may later be nullified and voided as if it were never in effect, if you fail to meet the terms and conditions of that coverage. This includes, but is not limited to, any circumstance where providing cover, benefit, or services under the policy, or the underlying business or activity, would (1) violate any applicable law or regulation, including without limitation any economic or trade sanction or embargo; or (2) be provided within, or otherwise related to, any country subject to comprehensive economic and/or trade sanction or embargo in the United States.</p>
                  <p><strong>By submitting this request for coverage, you acknowledge, understand, agree, and certify the following:</strong></p>
                  <ol>
                    <li>All information you have provided is accurate to the best of your knowledge and that, by selecting the button to complete your purchase, you are agreeing to pay the amount displayed as the total price with the credit card number provided. You are the owner and rightful user of the credit card used in this transaction. You further acknowledge, understand, and agree that plans purchased with intentionally inaccurate/fraudulent information will be considered void and that you may be subject to legal action as a result of such information.</li>
                    <li>You and all named insureds on your policy are U.S. residents and have obtained, or will have obtained prior to your scheduled departure date, and will maintain throughout your insured trip, all proper documentation, vaccinations, medical equipment/provisions, government licenses/authorizations/permits (including without limitation any required passports, visas, OFAC licensures, etc.), and any other prerequisite to travel that is required or otherwise necessary for your trip. You acknowledge, understand, and agree that your failure to obtain any of the above may result in a denial of coverage and/or assistance services under the plan. Additionally, you acknowledge, understand, and agree that all coverage and assistance services are subject to applicable law.</li>
                    <li>You consent to receiving all communications and notices from us electronically to the email address provided at the time of purchase. You may choose not to receive electronic communications and instead receive communications from us by regular mail at any time. If you do not wish to receive communications electronically, or wish to later update your preference about the receipt of electronic communications, please contact us with your name, policy number, and a statement that "I do not wish to receive electronic communications".</li>
                    <li>You may request paper copies to be sent to you by requesting paper of any information provided to you electronically, or update your electronic contact information at any time by sending a request by email or mail at the above address, or by calling us. Documents sent to you from us will be in either PDF or HTML format. If you are unable to receive PDF or HTML documents, or are otherwise unable to read the documents we send you, please contact us so we can assist you.</li>
                  </ol>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12 col-sm-12">
                <div id="stripe-checkout">
                  <div id="stripe-data" data-allow-remember-me="false" data-description="{{ $order_config['state'] }}: {{ $order_config['variation'] }} x 1" data-amount="{{ str_replace('.', '', $order_config['price']) }}" data-label="Pay Now" data-key="{{ $key }}" data-currency="USD"></div>
                  <div class="price" id="total-price"></div>
                  {!! wp_nonce_field('wp_stripe_checkout', '_wpnonce', true, false) !!}
                  <input type="hidden" id="stripe-token" name="stripe_token" value="">
                  <input type="hidden" id="transaction_amt" name="transaction_amt" value="">
                  <input type="hidden" id="transaction_desc" name="transaction_desc" value="">
                </div>
                <div id="stripe-loading" class="icon-loading hidden"></div>
                {{-- One or the other of these will appear --}}
                <div id="stripe-elements-button">{{-- A Stripe Element (Apple Pay/Google Wallet/Microsoft Pay) Button will be inserted here. --}}</div>
                <button id="stripe-checkout-submit" class="submit btn">Pay with Card</button>
              </div>
            </div>
        </form>
      </div>
    </section>
  @endsection

@endif
@php
  $args = array(
      'post_type' => 'partner'
  );

  $post_query = new WP_Query($args);
if($post_query->have_posts() ) {
  while($post_query->have_posts() ) {
    $post_query->the_post();
    @endphp
    <!-- <div class="partner">
    <h2><?php the_title(); ?></h2>
    </div> -->
    @php
  }
}
@endphp
