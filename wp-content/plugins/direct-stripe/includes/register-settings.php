<?php //Register all settings options in WordPress

defined( 'ABSPATH' ) or die( 'Please!' );

//Access functions that display settings values in admin from the class made in display-settings.php
require_once( DSCORE_PATH . '/includes/class-display-settings.php' );
$displaysettings = new \DirectStripeDisplaySettings;

//Register options by sections / page (one option field in options table each)
register_setting( 'directStripeGeneral', 'direct_stripe_general_settings', array( array($displaysettings, 'direct_stripe_general_settings_validation'), 'show_in_rest' => true ) );
register_setting( 'directStripeStyles', 'direct_stripe_styles_settings', array( array($displaysettings, 'direct_stripe_styles_settings_validation'), 'show_in_rest' => true ) );
register_setting( 'directStripeEmails', 'direct_stripe_emails_settings', array( array($displaysettings, 'direct_stripe_emails_settings_validation'), 'show_in_rest' => true ) );
register_setting( 'directStripeButtons', 'direct_stripe_buttons', array( array($displaysettings, 'direct_stripe_buttons_validation'), 'show_in_rest' => true, 'default' => 'buttons' ) );

//Register sections and settings fields
	// API keys section
	add_settings_section(
		'direct_stripe_keys_section', 
		__( 'Set API keys', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_api_section_callback'), 
		'directStripeGeneral'
	);

	add_settings_field( 
		'direct_stripe_publishable_api_key', 
		__( 'Live Publishable API key', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_publishable_api_key_render'), 
		'directStripeGeneral', 
		'direct_stripe_keys_section' 
	);
	add_settings_field(
		'direct_stripe_secret_api_key',
		__( 'Live Secret API key', 'direct-stripe' ),
		array($displaysettings, 'direct_stripe_secret_api_key_render'),
		'directStripeGeneral',
		'direct_stripe_keys_section'
	);
	add_settings_field( 
		'direct_stripe_checkbox_api_keys', 
		__( 'Use test keys / mode', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_checkbox_api_keys_render'), 
		'directStripeGeneral', 
		'direct_stripe_keys_section' 
	);
	add_settings_field( 
		'direct_stripe_test_publishable_api_key', 
		__( 'Test Publishable API key', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_test_publishable_api_key_render'), 
		'directStripeGeneral', 
		'direct_stripe_keys_section' 
	);
	add_settings_field(
		'direct_stripe_test_secret_api_key',
		__( 'Test Secret API key', 'direct-stripe' ),
		array($displaysettings, 'direct_stripe_test_secret_api_key_render'),
		'directStripeGeneral',
		'direct_stripe_keys_section'
	);

//Currency
	add_settings_section(
		'direct_stripe_currency_section', 
		__( 'Currency', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_currency_section_callback'), 
		'directStripeGeneral'
	);
	
	add_settings_field( 
		'direct_stripe_currency', 
		__( 'Currency', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_currency_render'), 
		'directStripeGeneral', 
		'direct_stripe_currency_section' 
	);

    // Success / errors messages section
    add_settings_section(
        'direct_stripe_success_error_section',
        __( 'Success and error messages', 'direct-stripe' ),
        array($displaysettings, 'direct_stripe_success_error_section_callback'),
        'directStripeGeneral'
    );


    add_settings_field(
        'direct_stripe_success_message',
        __( 'Success message', 'direct-stripe' ),
        array($displaysettings, 'direct_stripe_success_message_render'),
        'directStripeGeneral',
        'direct_stripe_success_error_section'
    );
    add_settings_field(
        'direct_stripe_error_message',
        __( 'Error message', 'direct-stripe' ),
        array($displaysettings, 'direct_stripe_error_message_render'),
        'directStripeGeneral',
        'direct_stripe_success_error_section'
    );


	// Redirection pages section
	add_settings_section(
		'direct_stripe_redirectionPages_section', 
		__( 'Landing pages', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_redirections_section_callback'), 
		'directStripeGeneral'
	);
    add_settings_field(
        'direct_stripe_use_redirections',
        __( 'Redirect users to success or error pages when transaction completed', 'direct-stripe' ),
        array($displaysettings, 'direct_stripe_use_redirections_render'),
        'directStripeGeneral',
        'direct_stripe_redirectionPages_section'
    );
	add_settings_field( 
		'direct_stripe_success_page', 
		__( 'Success page', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_success_page_render'), 
		'directStripeGeneral', 
		'direct_stripe_redirectionPages_section' 
	);

	add_settings_field( 
		'direct_stripe_error_page', 
		__( 'Error page', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_error_page_render'), 
		'directStripeGeneral', 
		'direct_stripe_redirectionPages_section' 
	);
	
	// Logo image
	add_settings_section(
		'direct_stripe_logo_section', 
		__( 'Modal form logo / image', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_logo_section_callback'), 
		'directStripeGeneral'
	);
	add_settings_field( 
		'direct_stripe_logo_image', 
		__( 'Current logo / image', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_logo_render'), 
		'directStripeGeneral', 
		'direct_stripe_logo_section' 
	);
	// Checkbox for billing infos
	add_settings_section(
		'direct_stripe_billing_infos_section', 
		__( 'Billing information', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_billing_infos_section_callback'), 
		'directStripeGeneral'
	);
	add_settings_field( 
		'direct_stripe_billing_infos_checkbox', 
		__( 'Ask for address in modal Form', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_billing_infos_checkbox_render'), 
		'directStripeGeneral', 
		'direct_stripe_billing_infos_section' 
	);
	add_settings_field( 
		'direct_stripe_shipping_infos_checkbox', 
		__( 'Add shipping address option (billing address is always asked for when the shipping address option is enabled)', 'direct-stripe' ),
		array($displaysettings, 'direct_stripe_shipping_infos_checkbox_render'), 
		'directStripeGeneral', 
		'direct_stripe_billing_infos_section' 
	);
	add_settings_field( 
		'direct_stripe_rememberme_option_checkbox', 
		__( 'Allow remember me Stripe option in modal Form', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_rememberme_option_checkbox_render'), 
		'directStripeGeneral', 
		'direct_stripe_billing_infos_section' 
	);
	
	// Button Styles
	add_settings_section(
		'direct_stripe_styles_section', 
		__( 'Custom button styles', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_styles_section_callback'), 
		'directStripeStyles'
	);
	add_settings_field( 
		'direct_stripe_use_custom_styles', 
		__( 'Choose button styles', 'direct-stripe' ),
		array($displaysettings, 'direct_stripe_use_custom_styles_render'), 
		'directStripeStyles', 
		'direct_stripe_styles_section' 
	);
	add_settings_field( 
		'direct_stripe_main_color-style', 
		__( 'Main Color', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_main_color_style_render'), 
		'directStripeStyles', 
		'direct_stripe_styles_section' 
	);
	add_settings_field( 
		'direct_stripe_border_radius', 
		__( 'Border radius', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_border_radius_render'), 
		'directStripeStyles', 
		'direct_stripe_styles_section' 
	);
	
	// Terms and conditions options
	add_settings_section(
		'direct_stripe_tc_section', 
		__( 'Terms and conditions', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_tc_section_callback'), 
		'directStripeStyles'
	);
	add_settings_field( 
		'direct_stripe_use_tc_checkbox', 
		__( 'Use Terms and Conditions checkbox', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_tc_checkbox_render'), 
		'directStripeStyles', 
		'direct_stripe_tc_section' 
	);
	add_settings_field( 
		'direct_stripe_tc_text', 
		__( 'Terms and conditions text', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_tc_text_render'), 
		'directStripeStyles', 
		'direct_stripe_tc_section' 
	);
	add_settings_field( 
		'direct_stripe_tc_link_text', 
		__( 'Terms and conditions link text', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_tc_link_text_render'), 
		'directStripeStyles', 
		'direct_stripe_tc_section' 
	);
	add_settings_field( 
		'direct_stripe_tc_link', 
		__( 'Terms and conditions page', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_tc_link_render'), 
		'directStripeStyles', 
		'direct_stripe_tc_section' 
	);
	
	// Emails to admin
	add_settings_section(
		'direct_stripe_admin_emails_section', 
		__( 'Automated emails to admin after successful transactions', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_admin_emails_section_callback'), 
		'directStripeEmails'
	);
	add_settings_field( 
		'direct_stripe_admin_emails_checkbox', 
		__( 'Send emails to admin after successful transaction', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_admin_emails_checkbox_render'), 
		'directStripeEmails', 
		'direct_stripe_admin_emails_section' 
	);
	add_settings_field( 
		'direct_stripe_admin_email_subject', 
		__( 'Admin email subject', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_admin_email_subject_render'), 
		'directStripeEmails', 
		'direct_stripe_admin_emails_section' 
	);
	add_settings_field( 
		'direct_stripe_admin_email_content', 
		__( 'Admin email content', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_admin_email_content_render'), 
		'directStripeEmails', 
		'direct_stripe_admin_emails_section' 
	);
	
	// Emails to stripe user
	add_settings_section(
		'direct_stripe_user_emails_section', 
		__( 'Automated emails to Stripe user after successful transactions', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_user_emails_section_callback'), 
		'directStripeEmails'
	);
	add_settings_field( 
		'direct_stripe_user_emails_checkbox', 
		__( 'Send emails to Stripe user after successful transaction', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_user_emails_checkbox_render'), 
		'directStripeEmails', 
		'direct_stripe_user_emails_section' 
	);
	add_settings_field( 
		'direct_stripe_user_email_subject', 
		__( 'User email subject', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_user_email_subject_render'), 
		'directStripeEmails', 
		'direct_stripe_user_emails_section' 
	);
	add_settings_field( 
		'direct_stripe_user_email_content', 
		__( 'User email content', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_user_email_content_render'), 
		'directStripeEmails', 
		'direct_stripe_user_emails_section' 
	);
  /********************************** ERROR EMAILS  *************************************/
  	// ERROR Emails to admin
	add_settings_section(
		'direct_stripe_admin_error_emails_section', 
		__( 'Automated emails to admin after failed transaction', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_admin_error_emails_section_callback'), 
		'directStripeEmails'
	);
	add_settings_field( 
		'direct_stripe_admin_error_emails_checkbox', 
		__( 'Send emails to admin after failed transaction', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_admin_error_emails_checkbox_render'), 
		'directStripeEmails', 
		'direct_stripe_admin_error_emails_section' 
	);
	add_settings_field( 
		'direct_stripe_admin_error_email_subject', 
		__( 'Admin error email subject', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_admin_error_email_subject_render'), 
		'directStripeEmails', 
		'direct_stripe_admin_error_emails_section' 
	);
	add_settings_field( 
		'direct_stripe_admin_error_email_content', 
		__( 'Admin error email content', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_admin_error_email_content_render'), 
		'directStripeEmails', 
		'direct_stripe_admin_error_emails_section' 
	);
	
	// ERROR Emails to stripe user
	add_settings_section(
		'direct_stripe_user_error_emails_section', 
		__( 'Automated emails to Stripe user after failed transaction', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_user_error_emails_section_callback'), 
		'directStripeEmails'
	);
	add_settings_field( 
		'direct_stripe_user_error_emails_checkbox', 
		__( 'Send emails to Stripe user after failed transaction', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_user_error_emails_checkbox_render'), 
		'directStripeEmails', 
		'direct_stripe_user_error_emails_section' 
	);
	add_settings_field( 
		'direct_stripe_user_error_email_subject', 
		__( 'User error email subject', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_user_error_email_subject_render'), 
		'directStripeEmails', 
		'direct_stripe_user_error_emails_section' 
	);
	add_settings_field( 
		'direct_stripe_user_error_email_content', 
		__( 'User error email content', 'direct-stripe' ), 
		array($displaysettings, 'direct_stripe_user_error_email_content_render'), 
		'directStripeEmails', 
		'direct_stripe_user_error_emails_section' 
	);

