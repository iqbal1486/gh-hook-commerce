<?php
	/*
        wpgp_la_
        https://jpederson.com/Accrue.js/
    */
    wp_enqueue_style( 'wpgp-accrue-css');
    wp_enqueue_script( 'wpgp-accrue-js');
    wp_enqueue_script( 'wpgp-loan-amortization-js');
?>

<div class="block grey-light">
    <div class="wrap">
        <h2 class="header">Interest Savings Calculation</h2>
        <div class="calculator-compare">
            <div class="thirty form"></div>
            <div class="seventy">
                <p><label>Ouptut:</label></p>
                <div class="results"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>