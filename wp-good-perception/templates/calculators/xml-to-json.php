<?php
  /*
        https://www.jqueryscript.net/other/xml-json-converter-manta.html
    */
    wp_enqueue_script( 'wpgp-xml-to-json' );
?>
<div class="form-group">
    <label for="exampleFormControlTextarea1">input XML</label>
    <textarea id="inputXML" class="form-control" id="exampleFormControlTextarea1" rows="10">xml here</textarea>
</div>
<br />
<br />
<button id="convert" type="button" class="btn btn-primary btn-sm">Convert</button>
<br />
<br />

<div class="form-group">
    <label for="exampleFormControlTextarea1">output JSON</label>
    <textarea id="json" class="form-control" id="exampleFormControlTextarea1" rows="10">JSON</textarea>
</div>
<script>
  jQuery("#convert").on("click", function() {
    var xml = jQuery("#inputXML").val();
    jQuery("#json").val(JSON.stringify(mantaXML.xml2JSON(xml)))
  });
</script>