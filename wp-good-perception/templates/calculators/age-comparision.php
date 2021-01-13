<?php 
    /*
        wpgp_ac_
        https://tools.knowledgewalls.com/agecomparison
    */

    wp_enqueue_style( 'wpgp-jquery-ui' ); 
    wp_enqueue_script( 'jquery-ui-datepicker');
    wp_enqueue_script( 'wpgp-age-comparision');
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
        font-size: 30px !important;
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
            <td class="c-header">
                <h3 class='tool_title'>Online Age Comparison</h3>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <div>Younger Date of Birth(DOB):</div>
                            <input type="text" readonly size="30" id="wpgp_ac_txt_doj" name="wpgp_ac_txt_doj" />
                            <div class="wpgp_ac_txt_doj_feedback error"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Elder Date of Birth(DOB):</div>
                            <input type="text" readonly size="30" id="wpgp_ac_txt_eod" name="wpgp_ac_txt_eod"/>
                            <div class="wpgp_ac_txt_eod_feedback error"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="button wpgp_ac_do_calculation">Calculate</button>
                            <br>
                            <br>
                            <button class="button wpgp_ac_clear_calculation">Clear</button>
                        </td>
                    </tr>
                </table>
                <div id="wpgp_ac_lbl_summary_info" class="result bold"></div>
            </td>
        </tr>
    </table>
</div>