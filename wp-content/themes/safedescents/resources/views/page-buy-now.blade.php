{{--
Template Name: Buy Now Template
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
        <p>Thank you for purchasing Safe Descents Ski and Snowboarding Evacuation Insurance. Please check your email <strong>{{ $_REQUEST['billing_email'] }}</strong> for your receipt and confirmation documents.</p>
        <p>Warmly,<br />
          All of us at Safe Descents</p>
      </div>
    @endsection

  @else
    @section('content')
      <section class="buy-now">
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
    <section class="buy-now">
      <div class="row">
        @if (!array_key_exists('configuration_id', $_GET))
          {{-- Display Select Policy Form --}}
          <div class="col-xs-12 col-sm-12">
            @include('partials.buy-now')
          </div>
        @else
          {{-- Display Checkout Form --}}
          <div class="col-sm-12 col-md-9">
            <form id="buynowform" class="buynowform" action="/?confirm=success" method="POST">

              <ol class="form-progress" tabindex="0" role="progressbar" aria-valuemin="1"  aria-valuemax="5" aria-valuenow="1" aria-valuetext="Step 1 of 5: Trip Details">
                <li class="progress-step" aria-hidden="true" data-step-current>Trip Details</li>
                <li class="progress-step" aria-hidden="true" data-step-incomplete>Skier Information</li>
                <li class="progress-step" aria-hidden="true" data-step-incomplete>Residence Information</li>
                <li class="progress-step" aria-hidden="true" data-step-incomplete>Billing Information</li>
              </ol>

              <fieldset class="coverage-info hidden">
                @php
                $states_json = file_get_contents(get_template_directory() . '/../app/api-products.json');

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
              </fieldset>

              <div id="trip-details" class="form-step" data-section-number="1" aria-hidden="true">
                <fieldset class="form-section">
                  <legend>Trip Details</legend>

                  @if ($order_config['variation'] == 'Daily Pass')
                    <div class="row">
                      <div class="col-xs-12 col-sm-12">
                        <label for="start-date">Trip Dates&nbsp;<abbr class="req" title="Required">*</abbr></label>
                        <input required type="date" name="date-range" required value="" />
                      </div>
                    </div>
                  @endif

                  <div class="row">
                    <div class="col-xs-12 col-sm-12">
                      <label for="destination">Destination</label>
                      <p style="margin-top: 0;">Where will you be skiing/snowboarding?</p>
                      <input type="text" name="destination" value=""/>
                      <p class="smaller-text">This insurance only provides coverage for activities and/or accidents that occur within in the Continental United States. No coverage is available within Alaska or Hawaii.</p>
                    </div>
                  </div>
                </fieldset>

                <div class="buttons">
                  <button data-button-type="next" class="btn disabled">Next &rarr;</button>
                </div>
              </div>

              <div id="skier-details" class="form-step hidden" data-section-number="2" aria-hidden="true">
                <fieldset class="form-section">
                  <legend>Skier Information</legend>
                  <p>Please enter the name and birthdate of each skier or snowboarder. All individuals must reside at the same address in order to purchase insurance together. For individuals with different residences, please purchase policies separately.</p>

                  <div class="skier-details">
                    <fieldset class="skier-container">
                      <span class="remove-skier">x</span>
                      <legend>Covered Individual</legend>
                      <label for="first-name">First Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="text" name="first-name[]" id="first-name" value="" />
                      <label for="last-name">Last Name&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="text" name="last-name[]" id="last-name" value="" />
                      <label for="birthdate">Birth Date&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="text" data-inputmask name="birthdate[]" id="birthdate" placeholder="dd/mm/yyyy" value="" />
                      <label for="contact_email" class="">Contact Email&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="email" name="contact_email[]" id="contact_email" value="">
                      <label for="contact_phone" class="">Contact Phone&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="tel" name="contact_phone[]" id="contact_phone" value="">
                    </fieldset>

                    <button id="add-skier" class="button" name="add_skier">+</button>
                  </div>
                </fieldset>

                <div class="buttons">
                  <button data-button-type="prev" class="btn">&larr; Previous</button>
                  <button data-button-type="next" class="btn disabled">Next &rarr;</button>
                </div>
              </div>

              <div id="residence-details" class="form-step hidden" data-section-number="3" aria-hidden="true">
                <fieldset class="form-section">
                  <legend>Home Address</legend>
                  <div class="row">
                    <div class="col-sm-12 col-md-12">
                      <label for="residence_address_1" class="">Street Address&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="textarea" rows="10" class="" name="residence_address_1" id="residence_address_1" placeholder="House number and street name (555 Main Street)" value="" autocomplete="address-line1" />
                      <input type="text" class="" name="residence_address_2" id="residence_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="" autocomplete="address-line2">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-5">
                      <label for="residence_city" class="">Town / City&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="text" class="" name="residence_city" id="residence_city" placeholder="" value="{{ $_REQUEST['city'] }}" autocomplete="address-level2">
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <label for="residence_state" class="">State&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required disabled  type="text" name="residence_state" id="residence_state" value="{{ $order_config['state'] }}">
                    </div>
                    <div class="col-sm-12 col-md-3">
                      <label for="residence_postcode" class="">Zip Code&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="text" class="" name="residence_postcode" id="residence_postcode" placeholder="" value="{{ $_REQUEST['zip'] }}" autocomplete="postal-code">
                    </div>
                  </div>
                </fieldset>

                <div class="buttons">
                  <button data-button-type="prev" class="btn">&larr; Previous</button>
                  <button data-button-type="next" class="btn disabled">Next &rarr;</button>
                </div>
              </div>

              <div id="billing-details" class="form-step hidden" data-section-number="4" aria-hidden="true">
                <fieldset class="form-section">
                  <legend>Billing Information</legend>
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
                    <div class="col-sm-12 col-md-6">
                      <label for="billing_email" class="">Email Address&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input type="email" class="" name="billing_email" id="billing_email" placeholder="" value="" autocomplete="email">
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <label for="billing_phone" class="">Phone&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="tel" class="" name="billing_phone" id="billing_phone" placeholder="" value="" autocomplete="tel">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <input type="checkbox" id="new-billing" name="new-billing" value="true"><label for="new-billing">Bill to a different address?</label>
                    </div>
                  </div>

                  <div class="billing-address-same">
                    <div class="row">
                      <div class="col-sm-12">
                        <label for="billing_address_1" class="">Street Address&nbsp;<abbr class="req" title="Required">*</abbr></label>
                        <input required type="text" class="" name="billing_address_1" id="billing_address_1" placeholder="House number and street name" value="" autocomplete="address-line1" />
                        <input type="text" class="" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit etc. (optional)" value="" autocomplete="address-line2">
                      </div>
                    </div>

                    <div class="row">
                    <div class="col-sm-12 col-md-5">
                      <label for="billing_city" class="">Town / City&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="text" class="" name="billing_city" id="billing_city" placeholder="" value="" autocomplete="address-level2">
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <label for="billing_state" class="">State&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <select required name="billing_state" id="billing_state" class="browser-default" autocomplete="address-level1">
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
                      <label for="billing_postcode" class="">Zip Code&nbsp;<abbr class="req" title="Required">*</abbr></label>
                      <input required type="text" class="" name="billing_postcode" id="billing_postcode" placeholder="" value="" autocomplete="postal-code">
                    </div>
                  </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <input required type="checkbox" name="confirmation" value="accept" id="confirmation" />
                      <label for="confirmation" class="smaller-text confirmation">By checking here, I confirm that I have read, understood and agree to the <a href="/terms-and-conditions/" target="_blank">Terms & Conditions</a> and <a href="/privacy-policy/" target="_blank">Privacy Policy</a> of this website, the <a href="/full-policy-text/" target="_blank">Policy which contains reductions, limitations, exclusions (See Section VI.) and termination provisions</a> and the <a href="#" id="open-notice-and-consent">Notice and Consent</a>, including the receipt of electronic notices. Full details of the coverage are contained in the policy.<abbr class="req" title="Required">*</abbr></label>
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
                        <h5>FRAUD STATEMENTS</h5>
                        <p><strong>GENERAL FRAUD STATEMENT</strong></p>
                        <p>Any person who knowingly and with intent to defraud any insurance company or other person files an application for insurance or statement of claim containing any materially false information or conceals, for the purpose of misleading, information concerning any fact material thereto commits a fraudulent insurance act, which is a crime and subjects the person to criminal and civil penalties.</p>
                        <p><strong>ALABAMA FRAUD STATEMENT</strong></p>
                        <p>Any person who knowingly presents a false or fraudulent claim for payment of a loss or benefit or who knowingly presents false information in an application for insurance is guilty of a crime and may be subject to restitution, fines, or confinement in prison, or any combination thereof.</p>
                        <p><strong>ARKANSAS, LOUISIANA, MARYLAND, RHODE ISLAND, TEXAS AND WEST VIRGINIA FRAUD STATEMENT</strong></p>
                        <p>Any person who knowingly presents a false or fraudulent claim for payment of a loss or benefit or knowingly presents false information in an application for insurance is guilty of a crime and may be subject to fines and confinement in prison.</p>
                        <p><strong>COLORADO FRAUD STATEMENT</strong></p>
                        <p>It is unlawful to knowingly provide false, incomplete, or misleading facts or information to an insurance company for the purpose of defrauding or attempting to defraud the company. Penalties may include imprisonment, fines, denial of insurance, and civil damages. Any insurance company or agent of an insurance company who knowingly provides false, incomplete, or misleading facts or information to a policyholder or claimant for the purpose of defrauding or attempting to defraud the policyholder or claimant with regard to a settlement or award payable from insurance proceeds shall be reported to the Colorado division of insurance within the department of regulatory agencies.</p>
                        <p><strong>DISTRICT OF COLUMBIA FRAUD STATEMENT</strong></p>
                        <p>WARNING:<br />
                        It is a crime to provide false or misleading information to an insurer for the purpose of defrauding the insurer or any other person. Penalties include imprisonment and/or fines. In addition, an insurer may deny insurance benefits, if false information materially related to a claim was provided by the applicant.</p>
                        <p><strong>FLORIDA FRAUD STATEMENT</strong></p>
                        <p>Any person who knowingly and with intent to injure, defraud, or deceive any insurer files a statement of claim or an application containing any false, incomplete, or misleading information is guilty of a felony of the third degree.</p>
                        <p><strong>MAINE, TENNESSEE, VIRGINIA, AND WASHINGTON FRAUD STATEMENT</strong></p>
                        <p>It is a crime to knowingly provide false, incomplete or misleading information to an insurance company for the purpose of defrauding the company. Penalties may include imprisonment, fines or a denial of insurance benefits.</p>
                        <p><strong>MASSACHUSETTS, NEBRASKA, OREGON AND VERMONT FRAUD STATEMENT</strong></p>
                        <p>Any person who knowingly and with intent to defraud any insurance company or another person files an application for insurance or statement of claim containing any materially false information, or conceals for the purpose of misleading, information concerning any fact material thereto, commits a fraudulent insurance act, which may be a crime.</p>
                        <p><strong>NEW YORK FRAUD STATEMENT</strong></p>
                        <p>Any person who knowingly and with intent to defraud any insurance company or other person files an application for insurance or statement of claim containing any materially false information, or conceals for the purpose of misleading, information concerning any fact material thereto, commits a fraudulent insurance act, which is a crime, and shall also be subject to a civil penalty not to exceed five thousand dollars and the stated value of the claim for each such violation.</p>
                        <p><strong>OKLAHOMA FRAUD STATEMENT</strong></p>
                        <p>WARNING:<br />
                        Any person who knowingly, and with intent to injure, defraud or deceive any insurer, makes any claim for the proceeds of an insurance policy containing any false, incomplete or misleading information is guilty of a felony.</p>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xs-12 col-sm-12">
                      <div id="stripe-checkout">
                        <div id="stripe-data" data-allow-remember-me="false" data-description="{{ $order_config['state'] }}: {{ $order_config['variation'] }} x 1" data-amount="{{ str_replace('.', '', $order_config['price']) }}" data-label="Pay Now" data-key="{{ $key }}" data-currency="USD"></div>
                        <div class="hidden price" id="total-price"></div>
                        {!! wp_nonce_field('wp_stripe_checkout', '_wpnonce', true, false) !!}
                        <input type="hidden" id="stripe-token" name="stripe_token" value="">
                        <input type="hidden" id="transaction_amt" name="transaction_amt" value="">
                        <input type="hidden" id="transaction_desc" name="transaction_desc" value="">
                      </div>
                      <div id="stripe-loading" class="hidden"></div>
                      {{-- One or the other of these will appear --}}
                      <div id="stripe-elements-button">{{-- A Stripe Element (Apple Pay/Google Wallet/Microsoft Pay) Button will be inserted here. --}}</div>
                      <button id="stripe-checkout-submit" class="hidden submit btn">Pay with Card</button>
                    </div>
                  </div>
                </fieldset>
              </div>
            </form>
          </div>

          <div class="sticky-cart col-sm-12 col-md-3">
            <div id="sticky-cart">
              <h3>Summary</h3>
              <dl>
                <dt class="plan">Plan</dt>
                <dd class="plan">{{ $order_config['variation'] }}</dd>
                <dt class="state">Resident State</dt>
                <dd class="state">{{ $order_config['state'] }}</dd>
                <dt class="hidden dates">Trip Dates</dt>
                <dd class="hidden dates"></dd>
                <dt class="hidden length">Trip Length</dt>
                <dd class="hidden length"></dd>
                <dt class="hidden number">Number Insured</dt>
                <dd class="hidden number"></dd>
                <dt class="hidden total">Total Cost</dt>
                <dd class="hidden total"><strong>{{ $order_config['price'] }}</strong></dd>
              </dl>
            </div>
          </div>
        @endif
      </div>
    </section>
  @endsection

@endif
