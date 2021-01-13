<?php
	/*
        https://www.jqueryscript.net/other/convert-csv-to-json.html
    */
    wp_enqueue_script( 'wpgp-csv-to-json' );
?>
<div class="container clearfix">
    <div id="content">
        <h1>Convert CSV To JSON </h1>
        <p>Click here to upload your CSV file:</p>
        <input type="file" id="csv" />
        <br />
        <br />
        <p>Select your delimiter:</p>
        <select id="delimiter">
            <option id="comma" value=",">,</option>
            <option id="pipe" value="|">|</option>
        </select>
        <br />
        <br />
        <button class="btn btn-danger" id="convert">Click to Convert</button>
        <br />
        <br />
        <textarea disabled id="json" rows="10" class="textareasize"></textarea>
        <br />
        <br />
        <button class="btn button btn-danger" id="download">Download JSON File</button>
    </div>
</div>