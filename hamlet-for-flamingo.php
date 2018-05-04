<?php
/*
Plugin Name: Hamlet For Flamingo ( To Save or not to save )
Description: Hamlet is a really simple plugin that allows you to set a field that will determine if the form is saved to Flamingo database.
Version: 1
Author: Steve Clark / Clark Studios
Author URI: http://www.clark-studios.co.uk
Text Domain: hamlet
*/

require('classes/admin.class.php');

if( is_admin() ) {
	$admin = new FLAMINGO_GDPR_ADMIN_CLASS;
} 

function flamingo_gdpr_submit($form) {
	
	$wpcf7      = WPCF7_ContactForm::get_current();
	$submission = WPCF7_Submission::get_instance();

	if ( $submission ) {

		// -- Get Post Data
		$posted_data  = $submission->get_posted_data();

		// -- Lets see if we have an opt in box
		$fgdpr = get_option( 'gdpr-fields_'.$wpcf7->id() );
		$field_key = str_replace( array("[","]"), "", $fgdpr['field']);
		$optIn = ($posted_data[$field_key]) ? $posted_data[$field_key] : '';
		$props = $wpcf7->get_properties();
		$settings = ($props['additional_settings']) ? $props['additional_settings'] . "\n" : '';
	
		// -- Opt In 
		if ( !$optIn[0] ) {
			
			$wpcf7->set_properties(array(
				'additional_settings' => $settings . 'do_not_store: true',
			));
			
		}
	}

	return $form;

}

add_action( 'wpcf7_before_send_mail',  'flamingo_gdpr_submit', 10, 1 );






?>
