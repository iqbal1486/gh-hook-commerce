<?php
	$gh_cf7_insightly_contact_fields = array(
			//"CONTACT_ID" 			=> "CONTACT_ID",
			"SALUTATION"			=> "SALUTATION",
			"FIRST_NAME"			=> "FIRST_NAME",
			"LAST_NAME"				=> "LAST_NAME",
			"IMAGE_URL"				=> "IMAGE_URL",
			"BACKGROUND"			=> "BACKGROUND",
			//"DATE_CREATED_UTC"		=> "DATE_CREATED_UTC",
			//"DATE_UPDATED_UTC"		=> "DATE_UPDATED_UTC",
			"SOCIAL_LINKEDIN"		=> "SOCIAL_LINKEDIN",
			"SOCIAL_FACEBOOK"		=> "SOCIAL_FACEBOOK",
			"SOCIAL_TWITTER"		=> "SOCIAL_TWITTER",
			//"DATE_OF_BIRTH"			=> "DATE_OF_BIRTH",
			"PHONE"					=> "PHONE",
			"PHONE_HOME"			=> "PHONE_HOME",
			"PHONE_MOBILE"			=> "PHONE_MOBILE",
			"PHONE_OTHER"			=> "PHONE_OTHER",
			"PHONE_ASSISTANT"		=> "PHONE_ASSISTANT",
			"PHONE_FAX"				=> "PHONE_FAX",
			"EMAIL_ADDRESS"			=> "EMAIL_ADDRESS",
			"ASSISTANT_NAME"		=> "ASSISTANT_NAME",
			"ADDRESS_MAIL_STREET" 	=> "ADDRESS_MAIL_STREET",
			"ADDRESS_MAIL_CITY" 	=> "ADDRESS_MAIL_CITY",
			"ADDRESS_MAIL_STATE" 	=> "ADDRESS_MAIL_STATE",
			"ADDRESS_MAIL_POSTCODE"	=> "ADDRESS_MAIL_POSTCODE",
			"ADDRESS_MAIL_COUNTRY" 	=> "ADDRESS_MAIL_COUNTRY",
			"ADDRESS_OTHER_STREET" 	=> "ADDRESS_OTHER_STREET",
			"ADDRESS_OTHER_CITY"	=> "ADDRESS_OTHER_CITY",
			"ADDRESS_OTHER_STATE"	=> "ADDRESS_OTHER_STATE",
			"ADDRESS_OTHER_POSTCODE"=> "ADDRESS_OTHER_POSTCODE",
			"ADDRESS_OTHER_COUNTRY"	=> "ADDRESS_OTHER_COUNTRY",
			"TITLE"					=> "TITLE",
			//"EMAIL_OPTED_OUT"		=> "EMAIL_OPTED_OUT",
	);
		
?>

	<?php if(isset( $_GET['form_id'] ) && !empty( $_GET['form_id'] ) ){ ?>
		
		<form method="post">
			<table class="form-table">
				<tr>
					<th scope="row">Insightly Field</th>
					<td>Contact Form Field</td>
				</tr>
			
				<?php 
					$form_fields_option = "<option value=''>None</option>";
					$form_ID 			= $_GET['form_id'];

					echo "<input type='text' value='$form_ID' name='form_ID'>";

					$ContactForm = WPCF7_ContactForm::get_instance( $form_ID );
					
					$form_fields = $ContactForm->scan_form_tags();

					foreach ($form_fields as $key => $value){
						$type 		= $value->type;
						$basetype 	= $value->basetype;
						$name 		= $value->name;
						$form_fields_option .= "<option value='$name'>$name ($basetype)</option>";
					}

					foreach ($gh_cf7_insightly_contact_fields as $key => $insightly_field) {
						?>
						<tr>
								<th scope="row"><label><?php echo $insightly_field; ?></label></th>
								<td>
									<select name="gh_cf7_insightly_contact_fields_mapping[<?php echo $insightly_field; ?>]">
										<?php echo $form_fields_option; ?>
									</select>
								</td>
							</tr>
						<?php	
					}
				?>
			</table>	
			<button name="save_gh_cf7_insightly_mapping" class="button-primary" type="submit" value="Save Mapping">Save Mapping</button>
			<?php wp_nonce_field('gh_cf7_insightly_save_mapping_nonce', 'gh_cf7_insightly_save_mapping_nonce_field'); ?>
		</form>

	<?php } else{ ?>

		<form method="get" action="">
			<?php
				$wpcf7_contact_form = get_posts(array(
			        'post_type'     => 'wpcf7_contact_form',
			        'numberposts'   => -1
			    ));
				foreach ( $wpcf7_contact_form as $key => $single_form ) {
					$select_form_option .= "<option value = '$single_form->ID'>$single_form->post_title</option>";
				}
				
				$url_components = parse_url($_SERVER['REQUEST_URI']);
	            parse_str($url_components['query'], $query_params);

	            if (!empty($query_params))
	            {
	                foreach ($query_params as $key => $value)
	                {
	                    echo "<input name='" . $key . "' type='hidden' value='" . $value . "'>";
	                }
	            }
	        ?>    
			<select name="form_id">
				<option value="">Select Contact Form</option>
				<?php echo $select_form_option; ?>
			</select>
			<button name="add_gh_cf7_insightly_new_mapping" class="button-primary" type="submit" value="Add New Mapping">Add New Mapping</button>
			<?php wp_nonce_field('gh_cf7_insightly_add_new_mapping_nonce', 'gh_cf7_insightly_add_new_mapping_nonce_field'); ?>
		</form>


		<div class="wrap">
			<h2>Logs</h2>

			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="post">
								<?php
								$this->gh_cf7_insightly_mappings_obj->prepare_items();
								$this->gh_cf7_insightly_mappings_obj->display(); 
								?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>

	<?php } ?>
	

	
