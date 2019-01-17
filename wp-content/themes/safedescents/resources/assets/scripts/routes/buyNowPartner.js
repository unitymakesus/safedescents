var tingle = require('tingle.js');

export default {
    init() {
        // JavaScript to be fired on checkout page
    },
    finalize() {
        $.extend({
            getUrlVars: function() {
                var vars = [],
                    hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for (var i = 0; i < hashes.length; i++) {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
            },
            getUrlVar: function(name) {
                return $.getUrlVars()[name];
            },
        });

        // Set up Jquery Validator
        var validator = $('#buynowpartnerform').validate({
            ignore: ':hidden',
            errorElement: 'div',
            errorClass: 'help',
            onfocusout: validateForm,
            onclick: validateForm,
        });



        // Set up Modal
        var modal = new tingle.modal({
            footer: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
        });


        // Set up Stripe Elements
        var stripe = Stripe($('#stripe-data').attr('data-key')); // eslint-disable-line no-undef
        var paymentRequest = stripe.paymentRequest({
            country: 'US',
            currency: 'usd',
            total: {
                label: $('#stripe-data').attr('data-description'),
                amount: parseInt($('#stripe-data').attr('data-amount')) > 0 ? parseInt($('#stripe-data').attr('data-amount')) : 1,
            },
            requestPayerName: true,
            requestPayerEmail: true,
        });
        var strElements = stripe.elements();
        var prButton = strElements.create('paymentRequestButton', {
            paymentRequest: paymentRequest,
        });

        // Set Up Stripe Checkout
        var stripeHandler = StripeCheckout.configure({ // eslint-disable-line no-undef
            key: $('#stripe-data').attr('data-key'),
            name: 'Safe Descents',
            allowRememberMe: false,
            token: function(token) {
                $('input#stripe-token').val(token.id);
                $('#buynowpartnerform').submit();
            },
        });

        // Show payment buttons
        function showPaymentButtons() {
            $('#stripe-loading').removeClass('hidden');
            $('#pay-button-placeholder').addClass('hidden');

            // Check the availability of the Payment Request API first.
            paymentRequest.canMakePayment().then(function(result) {
                $('#stripe-loading').addClass('hidden');
                if (result) {
                    // Add fancy Stripe Elements button
                    prButton.mount('#stripe-elements-button');
                    $('#stripe-elements-button').removeClass('hidden');
                } else {
                    // Show Stripe Checkout button
                    $('#stripe-checkout-submit').removeClass('hidden');
                }
            });
        }

        // Hide payment buttons
        function hidePaymentButtons() {
            $('#pay-button-placeholder').removeClass('hidden');
            $('#stripe-checkout-submit').addClass('hidden');
            $('#stripe-elements-button').addClass('hidden');
        }

        // Test Start Date Validation
        function validateStartDate() {
            var start = $('input[name="start-date"]'),
                $step = $(start).closest('.form-step');

            if (validator.element(start) == true && $('#buynowpartnerform').valid() == true) {
                $step.find('button[data-direction=next]').removeClass('disabled');
            } else {
                $step.find('button[data-direction=next]').addClass('disabled');
            }
        }

        // Test Step Validation
        function validateStep(step) {
            if ($('#buynowpartnerform').valid() == true) {
                step.find('button[data-direction=next]').removeClass('disabled');
            } else {
                step.find('button[data-direction=next]').addClass('disabled');
            }
        }

        // Test Form Validation
        function validateForm(element) {
            var $step = $(element).closest('.form-step');

            // If both the current element and the current section are valid
            if (validator.element(element) == true && $('#buynowpartnerform').valid() == true) {
                $step.find('button[data-direction=next]').removeClass('disabled');

                // If the final form step is valid show payment buttons
                if ($step.attr('id') == 'billing-details') {
                    showPaymentButtons();
                }
            } else {
                $step.find('button[data-direction=next]').addClass('disabled');
                hidePaymentButtons();
            }
        }

        // Handle Cart Updates
        function updateCart(sectionID) {
            var configPrice = $('.coverage-info input[name="config_price"]').val();
            var duration = 1;

            switch (sectionID) {
                case "trip-details":
                    if ($('input[name="start-date"]').length) {
                        // Add start date to summary
                        var startDatePretty = $('input[name="start-date"]').next().val();
                        $('#sticky-cart dd.dates').html(startDatePretty);
                        $('#sticky-cart .dates').removeClass('hidden');

                        // Add duration to summary
                        duration = $('input[name="duration"]').val();
                        $('#sticky-cart dd.length').html(duration);
                        $('#sticky-cart .length').removeClass('hidden');
                    }

                    // Calculate subtotal
                    $('#sticky-cart .subtotal').html(configPrice * duration);

                    break;

                case "skier-details":
                    // Calculate number of skiers
                    var number = $('.skier-container').length;
                    $('#sticky-cart dd.number').html(number);
                    $('#sticky-cart .number').removeClass('hidden');

                    // Calculate total
                    var total = configPrice * number;

                    // Get all config options
                    var state = $('#sticky-cart dd.state').html();
                    var plan = $('#sticky-cart dd.plan').html();
                    var days = $('#sticky-cart dd.length').html();

                    var description = state + ': ' + plan;

                    // add # of days
                    if (days.length) {
                        total = total * days;
                        description = description + ' (' + days + ' days)';
                    }

                    // add # of insured
                    description = description + ' x ' + number;

                    // Update summary
                    $('#total-price').html('Total: $' + parseFloat(total).toFixed(2));
                    $('#sticky-cart dd.total').html('$' + parseFloat(total).toFixed(2));
                    $('#sticky-cart .total').removeClass('hidden');

                    // Pre-fill billing contact info with first covered individual
                    $('#billing_first_name').val($('#first-name').val());
                    $('#billing_last_name').val($('#last-name').val());
                    $('#billing_email').val($('#contact_email').val());
                    $('#billing_phone').val($('#contact_phone').val());

                    // Setup Stripe data
                    $('#stripe-checkout [name="item_amount"]').val(total * 100);
                    $('#transaction_amt').val(total);
                    $('#transaction_desc').val(description);
                    $('#stripe-data').attr('data-description', description);
                    $('#stripe-data').attr('data-amount', total * 100);

                    paymentRequest.update({
                        total: {
                            label: description,
                            amount: parseInt(total * 100),
                        },
                    });

                    break;

            }
        }

        // Move to Next Step
        function changeStep(thisSection, direction) {
            var thisStep = Number(thisSection.attr('data-section-number')),
                stepNumber,
                stepLabel;

            if (direction == 'next') {
                stepNumber = thisStep + 1;
                stepLabel = $('.form-progress .progress-step[data-step-current]').next().html();
            } else {
                stepNumber = thisStep - 1;
                stepLabel = $('.form-progress .progress-step[data-step-current]').prev().html();
            }

            // Copy billing details by default
            if (stepNumber == 4) {
                $('#billing_address_1').val($('#residence_address_1').val());
                $('#billing_address_2').val($('#residence_address_2').val());
                $('#billing_city').val($('#residence_city').val());
                $('#billing_state').val($('#residence_state').val());
                $('#billing_postcode').val($('#residence_postcode').val());
            }

            // Hide this section
            thisSection.addClass('hidden').attr('aria-hidden', 'true');

            // Show new section
            $('.form-step[data-section-number="' + stepNumber + '"]').removeClass('hidden').attr('aria-hidden', 'false');

            // Validate new section
            validateStep($('.form-step[data-section-number="' + stepNumber + '"]'));

            // Change progress step
            $('.form-progress').attr('aria-valuenow', stepNumber);
            $('.form-progress').attr('aria-valuetext', 'Step ' + stepNumber + ' of 3: ' + stepLabel);
            $('.form-progress .progress-step[data-step-current]').removeAttr('data-step-current').attr('data-step-complete', '')
                .next().removeAttr('data-step-incomplete').attr('data-step-current', '');

            // Scroll to top of form
            $('html, body').animate({
                scrollTop: ($('main').offset().top) - 99,
            }, 500);

            // Update cart details
            updateCart(thisSection.attr('id'));
        }

        // Add flatpickr to date fields
        $('input[name="start-date"]').flatpickr({
            altInput: true,
            altFormat: 'n/d/Y',
            dateFormat: 'Y-m-d',
            mode: 'single',
            minDate: 'today',
            onChange: validateStartDate,
            onReady: function(selectedDates, dateStr, instance) {
                if (instance.isMobile) {
                    $(instance.mobileInput).removeAttr('step');
                }
            },
        });

        // Add validation to email field
        $.validator.addMethod("validateEmail", function(value, element) {
            if (/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value)) {
                return true;
            }
            return false;
        }, "Please enter a valid email address.");

        $('input[id="billing_email"]').rules("add", {
            validateEmail: true,
        });

        $('input[id="contact_email"]').rules("add", {
            validateEmail: true,
        });

        // Add validation for birthdate fields
        $.validator.addMethod("checkDOB", function(value, element) {
            var minDate = Date.parse("01/01/1900");
            var today = new Date();
            var DOB = Date.parse(value);
            if ((DOB <= today && DOB >= minDate)) {
                return true;
            }
            return false;
        }, "Please enter a valid birth date.");

        // Input mask on birthdate fields
        $('input[id="birthdate"]').inputmask("99/99/9999", {
            "placeholder": "mm/dd/yyyy",
        }).rules("add", {
            checkDOB: true,
        });

        // Input mask on tel fields
        $('input[type="tel"]').inputmask("999-999-9999", {
            "placeholder": "   -   -    ",
        });

        // Click Event on Nav Buttons
        $('.form-step').on('click', 'button[data-button-type=nav]', function(e) {
            e.preventDefault();
            var thisSection = $(this).closest('.form-step');

            if (!($(this)).hasClass('disabled')) {
                changeStep(thisSection, $(this).attr('data-direction'));
            }
        });

        // Different Address on Billing
        $('#clearfields').on("click", function(e) {
            e.preventDefault();
            $('#billing-details').find('[name^="billing_"]').val("").each(function() {
                validateForm($(this));
            });
        });

        // Open Notice and Consent Modal
        $('#open-notice-and-consent').on('click', function(e) {
            e.preventDefault();
            modal.setContent($('.notice-and-consent').html());
            modal.open();
        });

        // Click Event on Stripe Checkout button
        $('.form-step').on('click', '#stripe-checkout-submit', function(e) {
            e.preventDefault();

            if (!($(this)).hasClass('disabled')) {
                var config = {
                    amount: parseInt($('#stripe-data').attr('data-amount')),
                    description: $('#stripe-data').attr('data-description'),
                    email: $('#billing_email').val(),
                }

                stripeHandler.open(config);
            }
        });

        // Close Stripe Checkout on page navigation
        $(window).on('popstate', function() {
            stripeHandler.close();
        });

        // Handle Submission for Stripe Apple Pay/Google Wallet/Etc
        paymentRequest.on('token', function(response) {
            $('input#stripe-token').val(response.token.id);
            response.complete('success');
            $('#buynowpartnerform').submit();
        });
        
        
        $('.pass-select').on('click', 'div.pass-choice', function(ev) {
            $('.pass-choice').removeClass('pass-choice-active');
            $(this).addClass('pass-choice-active');
        });

        // Add flatpickr to date fields
        $('input[name="start-date"]').flatpickr({
            altInput: true,
            altFormat: 'n/d/Y',
            dateFormat: 'Y-m-d',
            mode: 'single',
            minDate: 'today',
            onChange: validateStartDate,
            onReady: function(selectedDates, dateStr, instance) {
                if (instance.isMobile) {
                    $(instance.mobileInput).removeAttr('step');
                }
            },
        });

        $('.pass-read-more').on('click', function() {
            $('#read-more').toggleClass('hidden');
            $('html,body').animate({
                scrollTop: $("#read-more").offset().top,
            }, 'slow');
        });

        $('#add-skier-in-household').on('click', function() {
            $('.additional-skier-1').show();
        });

        $.get("/wp-json/wp/v2/partner-api?_embed", function(data, status) {
            var query = $.getUrlVars(),
                matchingPartner = {},
                partnerInfo = '';

            for (var i = 0; i < data.length; i++) {
                var partner = data[i];

                if (query['checkout-partner'] === partner.slug) {
                    matchingPartner = partner;
                    break;
                }
            }

            partnerInfo += '<div class="col-xs-12 col-md-3"><img class="partner-logo" src="' + matchingPartner._embedded['wp:featuredmedia'][0].source_url + '" /"></div>';
            partnerInfo += '<div class="partner-content col-xs-12 col-md-9" >';
            partnerInfo += '<h2>' + matchingPartner.title.rendered + '</h2>';
            partnerInfo += '<p>' + matchingPartner.content.rendered + '</p>';
            partnerInfo += '</div>';
            $('#partner-info').html(partnerInfo);
        });
    },
}