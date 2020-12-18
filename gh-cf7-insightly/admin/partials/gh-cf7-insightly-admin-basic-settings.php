<?php
	$gh_cf7_insightly_options    	= get_option( 'gh_cf7_insightly_options' );
?>
<div class="setting-tab-wrapper">
	<h2>Settings</h2>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row" class="titledesc">Enable Connector</th>
				<td class="forminp forminp-checkbox">
				    <div class="inner-bg">
						<fieldset>
							<div class="toggle-button">
								<label class="switch" for="gh_enable_widget_on_cart">
									<input <?php echo $disabled; ?> name="gh_enable_widget_on_cart" id="gh_enable_widget_on_cart" type="checkbox" <?php echo checked($gh_cf7_insightly_options['gh_enable_widget_on_cart'], 1); ?> class="" value="1"> 
									<span class="slider"></span>
								</label>
							</div>	
						</fieldset>
					</div>
				</td>
			</tr>

			<tr>
				<th scope="row"><label for="new_admin_email">API KEY</label></th>
				<td>
					<input name="gh_cf7_insightly_api_key" id="gh_cf7_insightly_api_key" type="text" value="<?php echo $gh_cf7_insightly_options['gh_cf7_insightly_api_key']; ?>"  class="regular-text ltr">
					<p class="description" id="new-admin-email-description">API KEY <strong>Get it from here.</strong></p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<label for="">Request Setup Help</label>
				</th>
				<td>
					<div>Facing Difficulty? Click to connect with us</div>
					<div>
						<button type="submit" name="gh_request_setup_help" class="gh-request-help" value="gh_request_setup_help">Request Help</button>
					</div>
				</td>
			</tr>

		</tbody>
	</table>

	<p class="submit">
		<button name="save_gh_cf7_insightly_options" class="button-primary" type="submit" value="Save changes">Save changes</button>
		<?php wp_nonce_field('gh_cf7_insightly_options_nonce', 'gh_cf7_insightly_options_nonce_field'); ?>
	</p>
</div>