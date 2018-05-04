<?php

Class FLAMINGO_GDPR_ADMIN_CLASS {

	public function __construct() {
		add_action('init', array($this, 'load_all_hooks'));
		//add_action( 'wpcf7_before_send_mail',  array( $this, 'flamingo_gdpr_submit' ), 10, 1 );
	}


	public function load_all_hooks() {
		// --- Add Admin Menu
		//add_action( 'admin_menu', array( $this, 'add_menu') );
		//add_action( 'wp_head', array( $this, 'pps_js') );
		 add_action( 'admin_notices', array( $this, 'admin_notices') );
		//add_action( 'admin_head', array( $this, 'add_rte_editor_button') );
         add_filter( 'wpcf7_editor_panels',  array( $this, 'show_gdpr_metabox') );
         add_action( 'wpcf7_after_save',  array( $this, 'wpcf7_cm_save_gdpr' ) );
        
	}


	public function admin_notices() {

		$flamingo_active = is_plugin_active('flamingo/flamingo.php');
		$wpcf7_active = is_plugin_active('flamingo/wp-contact-form-7.php');

		$class = 'notice notice-error';
		$message = '';

        $opts = get_option('cs_sendy_settings');


		if( !$flamingo_active ) {
			$message .= '<li>Flamingo is not active <a href="' . admin_url('plugins.php') . '">Activate here</a>.</li>';
		}

		if( !$opts['LIST_ID']  ) {
			$message .= '<li>WCF7 is not active <a href="' . admin_url('plugins.php') . '">Activate here</a>.</li>';
		}

		if( $message ) {
			$message = '<ul>' . $message . '</ul>';
		} else {
			return;
		}
		
		printf( '<div class="%1$s">
			<div style="display:flex;">
			
			<div>
				<h3><strong>Oops! Some missing components here</strong></h3> %2$s 
			<p>Without these plugins installed this one is pretty useless. 
			Why you consider your options here is a gif of a cat!</p>
			</div>

			<figure>
			<img width="150" style="display:block;margin-left:1em" 
				src="https://media.giphy.com/media/8vQSQ3cNXuDGo/giphy.gif" />
			</figure>

			</div>

			</div>', $class, $message ); 
		
	}

	/**
	* Add the menu
	*/
	public function add_menu() {

		//add_submenu_page('options-general.php', 'Marketing Settings', 'Marketing Settings', 'manage_options', 'cs_sendy_settings', array('CS_SENDY_ADMIN_VIEW', 'settings' ) );
	}



	public function show_gdpr_metabox( $panels ) {

		$new_page = array(
			'cme-Extension' => array(
				'title' => __( 'GDPR', 'contact-form-7' ),
				'callback' => array($this, 'settings' )
			)
		);

		$panels = array_merge($panels, $new_page);

		return $panels;
	}

	public function settings($args) {
		$fgdpr = get_option( 'gdpr-fields_'.$args->id() );
		?>
		<div class="metabox-holder">
			<p class="mail-field">
				<label for="gdpr-field"><?php echo esc_html( __( 'Enter the field that must have a value in order to save to Flamingo:', 'wpcf7' ) ); ?>   <a href="<?php echo CME_URL ?>" class="helping-field" target="_blank" title="get help with Client API Key"> Help <span class="red-icon dashicons dashicons-sos"></span></a></label><br />
				<input type="text" id="gdpr-field" name="gdpr-fields[field]" class="wide" size="70" placeholder="e.g [acceptance 999]" value="<?php echo (isset($fgdpr['field']) ) ? esc_attr( $fgdpr['field'] ) : ''; ?>" />
			</p>

		</div>
		<?php
	}

	public function wpcf7_cm_save_gdpr($args) {
		if(!empty($_POST)){
			update_option( 'gdpr-fields_'.$args->id(), $_POST['gdpr-fields'] );
		}
	}

	public function flamingo_gdpr_submit( $form ) {

			$wpcf7      = WPCF7_ContactForm::get_current();
			$submission = WPCF7_Submission::get_instance();

			print_r($form);
			die();
			
			if ( $submission ) {
				
				$posted_data  = $submission->get_posted_data();

				// CF7 checkbox named opt-in
				$optIn    = $posted_data['opt-in'][0];

				if ( $optIn ) {

					$formTitle  = sanitize_text_field( $wpcf7->title() );

					$wpcf7->set_properties( array (
				    	'additional_settings' =>  'do_not_store: false\nflamingo_subject: "'.$formTitle.'"'
					));
		    
		    	} else {
		    
					$wpcf7->set_properties(array(
						'additional_settings' => 'do_not_store: true',
					));
				}
			}

			return $form;

	}


}



?>