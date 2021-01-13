<?php
	/*
        https://www.jqueryscript.net/other/convert-csv-to-json.html
    */
    wp_enqueue_script( 'wpgp-csv-to-json' );
?>
<style type="text/css">
    table.transliterate{
        background: #000000;
        color: #fff;
    }

    table.transliterate h3{
        background: #000000;
        color: #fff;
    }

    table.transliterate .error{
        display: block;
        color: #990000;
        font-size: 0.9em;
        float: none;
        cursor: default;
    }    

    table.transliterate .result{
        display: block;
        color: #b6e925;
        font-size: 25px;
        float: none;
        cursor: default;
        text-transform: capitalize;
    }
    table.transliterate td{
        text-align: center;
    }
    
    table.transliterate td.c-header{
        color: #b1e526;
        font-family: oswald,Sans-serif;
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
    }

    table.transliterate textarea{
        height: 300px;
        width: 100%;
        font-size: 18px !important;
        padding: 5px;
    }

    table.transliterate input{
        padding: 5px;
    }
    
  
    table.transliterate .button{
        border-style: solid;
        border-top-width: 2px;
        border-right-width: 2px;
        border-left-width: 2px;
        border-bottom-width: 2px;
        color: #ffffff;
        border-color: #ffffff;
        background-color: rgba(0,0,0,0);
        border-radius: 0;
        padding-top: 14px;
        padding-right: 38px;
        padding-bottom: 14px;
        padding-left: 38px;
        font-family: 'Oswald',sans-serif;
        font-weight: 800;
        font-size: 14px;
        font-size: 0.875rem;
        line-height: 1;
        text-transform: uppercase;
        letter-spacing: 2px;
        width: 100%;
    }

    table.transliterate .button, table.transliterate .button:visited {
        color: #ffffff;
    }

    table.transliterate .button:hover, table.transliterate .button:focus {
        color: #0f0f0f;
        background-color: #ffffff;
        border-color: #ffffff;
    }

</style>


<table class="transliterate">
    <tr>
        <td colspan="2" class="c-header">Convert csv to json</td>
    </tr>
    <tr>
        <td>
            <p>Click here to upload your CSV file:</p>
            <input type="file" id="csv" />
        </td>
        <td>
            <p>Select your delimiter:</p>
            <select id="delimiter">
                <option id="comma" value=",">,</option>
                <option id="pipe" value="|">|</option>
            </select>
        </td>
    </tr>

    <tr>
        <td><button class="btn button btn-danger" id="convert">Convert</button></td>
        <td><button class="btn button btn-danger" id="download">Download JSON File</button></td>
    </tr>

    <tr>
        <td colspan="2">
            <textarea disabled id="json" rows="10" class="textareasize"></textarea>
        </td>
    </tr>

</table>