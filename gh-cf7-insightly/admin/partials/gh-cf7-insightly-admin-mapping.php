<?php
$posts = get_posts(array(
        'post_type'     => 'wpcf7_contact_form',
        'numberposts'   => -1
    ));

foreach ( $posts as $p ) {
    $form_ID     = $p->ID;
	$ContactForm = WPCF7_ContactForm::get_instance( $form_ID );
	$form_fields = $ContactForm->scan_form_tags();

	// echo '<pre>';
	// print_r($form_fields);
	// echo '</pre>';
	foreach ($form_fields as $key => $value) {
		/*
		[type] => text*
        [basetype] => text
        [name] => your-name
		*/
		$type 		= $value->type;
		$basetype 	= $value->basetype;
		$name 		= $value->name;

	}
	echo '<hr style="height: 10px; background: red;"">';
}
?>

<?php
/*
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
*/
?>