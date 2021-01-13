<?php
/*
    wpgp_hdc_
    https://tools.knowledgewalls.com/harddisdrivesizecapacity
*/
    wp_enqueue_style( 'wp-jquery-ui-dialog' );
    wp_enqueue_script( 'jquery-ui-dialog' );
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
        font-size: 30px !important;
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
<div>
    <table class="transliterate">
        <tr>
            <td class='c-header'>
                <div >Online hard disk drive capacity calculator</div>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <div class="ft_font">Enter the hard disk size in GB</div>
                            <input type="text" id="wpgp_hdc_txt_harddisksize" size="30" placeholder="20" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <button class="button" id="wpgp_hdc_btn_convert">Calculate</button>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div id="wpgp_hdc_lbl_output" class="result"></div>
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
                jQuery('<div />').html('Please enter Hard disk size in GB in given input.').dialog({
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