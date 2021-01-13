<?php
/*
    wpgp_hdc_
    https://tools.knowledgewalls.com/harddisdrivesizecapacity
*/    
?>
<div>
    <table>
        <tr>
            <td>
                <div class='tool_title'>Online hard disk drive capacity calculator</div>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <div class="ft_font">Enter the hard disk size in GB</div>
                            <input type="text" id="wpgp_hdc_txt_harddisksize" size="30"/>
                            <button class="button" id="wpgp_hdc_btn_convert">Calculate</button>
                            <div id="wpgp_hdc_lbl_output"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
    jQuery(function() {
        jQuery('#wpgp_hdc_btn_convert').click(function() {
            jQuery('#wpgp_hdc_lbl_output').html('');
            if (jQuery('#wpgp_hdc_txt_harddisksize').val() == '') {
                jQuery('<div />').html('Enter the Hard disk size in GB.').dialog({
                    title: 'Error',
                    modal: !0,
                    buttons: {
                        ok: function() {
                            jQuery(this).dialog('close');
                            jQuery(this).remove();
                            jQuery('#wpgp_hdc_txt_harddisksize').focus()
                        }
                    }
                })
            } else if (isNaN(jQuery('#wpgp_hdc_txt_harddisksize').val())) {
                jQuery('<div />').html('Entered Hard disk size is not a number.').dialog({
                    title: 'Error',
                    modal: !0,
                    buttons: {
                        ok: function() {
                            jQuery(this).dialog('close');
                            jQuery(this).remove();
                            jQuery('#wpgp_hdc_txt_harddisksize').val('').focus()
                        }
                    }
                })
            } else {
                var t = (parseInt(jQuery('#wpgp_hdc_txt_harddisksize').val()) * 1000 * 1000 * 1000) / (1024 * 1024 * 1024);
                t = parseFloat(Math.round(t * 100) / 100).toFixed(2);
                var i = parseInt(jQuery('#wpgp_hdc_txt_harddisksize').val()) - t;
                i = parseFloat(Math.round(i * 100) / 100).toFixed(2);
                jQuery('#wpgp_hdc_lbl_output').html('Absolute hard disk size: <b>' + t + '</b> GB; Missing size: <b>' + i + '</b> GB')
            }
        })
    });
</script>