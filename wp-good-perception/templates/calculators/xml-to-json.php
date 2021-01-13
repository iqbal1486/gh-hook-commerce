<?php
  /*
        https://www.jqueryscript.net/other/xml-json-converter-manta.html
    */
    wp_enqueue_script( 'wpgp-xml-to-json' );
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
        <td colspan="2" class="c-header">XML to Json Convert</td>
    </tr>
    <tr>
        <td>
            <p>Input XML</p>
            <textarea id="inputXML" class="form-control" id="exampleFormControlTextarea1" rows="10">xml here</textarea>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <button id="convert" type="button" class="btn btn-primary btn-sm">Convert</button>
        </td>
    </tr>

    <tr>
        <td>
            <p>Output JSON</p>
    <textarea id="json" class="form-control" id="exampleFormControlTextarea1" rows="10">JSON</textarea>
        </td>
    </tr>

</table>

<script>
  jQuery("#convert").on("click", function() {
    var xml = jQuery("#inputXML").val();
    jQuery("#json").val(JSON.stringify(mantaXML.xml2JSON(xml)))
  });
</script>