<?php
	/*
		wpgp_sc_
		https://www.jqueryscript.net/other/Scientific-Calculator-jsRapCalculator.html
	*/
	wp_enqueue_style( 'wpgp-scientificcalculator-css');
	wp_enqueue_script( 'wpgp-scientificcalculator-js');
?>
<div id="scientificcalculator"></div>
<script>
	jQuery(document).ready(function(){
		jQuery('#scientificcalculator').jsRapCalculator({name:'name1'});
	});
</script>