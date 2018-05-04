<?php

Class FLAMINGO_GDPR_ADMIN_VIEWS {

	

	public static function settings() {

		die('123');

		$opts = get_option('cs_sendy_settings');

		$updated = false;

		if (!current_user_can('manage_options')) {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

		if ( isset($_POST['submit']) ) {
			update_option( 'cs_sendy_settings', $_POST['cs_sendy_settings'] );
			$opts = $_POST['cs_sendy_settings'];
			$updated = true;
		}

		?>
		<div class="metabox-holder">

		</div>

		<div class="wrap">

			<h2><?php screen_icon(); ?> GEO Redirect Settings</h2>

			<?php if($updated) : ?>
				<div id="setting-error-settings_updated" class="updated settings-error">
					<p><strong><?php _e('Settings saved.'); ?></strong></p>
				</div>
			<?php endif; ?>

			
		
			<form method="post" action="<?php echo admin_url( 'options-general.php?page=cs_sendy_settings' ); ?>">
				<h3>Marketing Settings</h3>

	
				<p>
					<label>API Key</label>
					<input type="text" class="widefat" name="cs_sendy_settings[API_KEY]" value="<?php echo @$opts['API_KEY']; ?>" />
				</p>	

				<p>
					<label>List ID</label>
					<input type="text" class="widefat" name="cs_sendy_settings[LIST_ID]" value="<?php echo @$opts['LIST_ID']; ?>" />
				</p>

				
				

				<div style="clear:both">
					<?php submit_button(); ?>
				</div>
			</form>

		</div>
		<?php
	}



}



?>