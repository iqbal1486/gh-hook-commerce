<div class="wrap">
	<?php 
	if(isset( $_GET['form_id'] ) && !empty( $_GET['form_id'] ) ){ 
		
		$module_name = $_GET['module_name'];
		$classvariable = $module_name."Fields";

		$insightly = new Insightly($module_name);
		$gh_cf7_insightly_contact_fields = $insightly->{$classvariable};
		
		echo "<pre>";
		print_r( $gh_cf7_insightly_contact_fields );
		echo "</pre>";
		
		if(isset( $_GET['action'] ) && $_GET['action'] == "edit" ) {

			global $wpdb;
			$mapping_data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".GH_CF7_INSIGHTLY_TABLE_MAPPING." WHERE form_ID = ".$_GET['form_id']." AND module_name = '".$module_name."'" ), ARRAY_A );
			$mapping_array = unserialize( $mapping_data['mapping'] );
		}
	?>
	<form method="post">
		<table class="form-table">
			<tr>
				<th scope="row">Insightly Field</th>
				<td>Contact Form Field</td>
			</tr>
		
			<?php 
				$form_fields_option = "<option value=''>None</option>";
				$form_ID 			= $_GET['form_id'];

				echo "<input type='hidden' value='$form_ID' name='form_ID'>";
				echo "<input type='hidden' value='$module_name' name='module_name'>";

				$ContactForm = WPCF7_ContactForm::get_instance( $form_ID );

				$form_fields = array();

				if($ContactForm)
					$form_fields = $ContactForm->scan_form_tags();

				foreach ($form_fields as $key => $value){
					$type 		= $value->type;
					$basetype 	= $value->basetype;
					$name 		= $value->name;
					$form_fields_option .= "<option value='$name'>$name ($basetype)</option>";
				}

				foreach ($gh_cf7_insightly_contact_fields as $key => $insightly_field) {
					$form_fields_option_modifed = $form_fields_option;
					if($mapping_array[$insightly_field]){
						$form_fields_option_modifed = str_replace("<option value='$mapping_array[$insightly_field]'", "<option value='$mapping_array[$insightly_field]' selected", $form_fields_option);
					}
					?>
					<tr>
							<th scope="row"><label><?php echo $insightly_field; ?></label></th>
							<td>
								<select name="gh_cf7_insightly_contact_fields_mapping[<?php echo $insightly_field; ?>]">
									<?php echo $form_fields_option_modifed; ?>
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
			<select name="module_name" required="required">
				<option value="">Select Module</option>
				<?php 
					$insightly = new Insightly($module_name);
					$gh_cf7_insightly_objects = $insightly->objects;
					foreach ($gh_cf7_insightly_objects as $key => $value) {
						echo "<option value='".$key."'>".$value."</option>";
					}
				?>
			</select>

			<select name="form_id" required="required">
				<option value="">Select Contact Form</option>
				<?php echo $select_form_option; ?>
			</select>
			
			<button class="button-primary" type="submit">Add New Mapping</button>
			<?php wp_nonce_field('gh_cf7_insightly_add_new_mapping_nonce', 'gh_cf7_insightly_add_new_mapping_nonce_field'); ?>
		</form>


		
		<h2>Logs</h2>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
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

	<?php } ?>
</div>
	
