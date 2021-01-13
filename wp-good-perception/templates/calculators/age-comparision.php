<?php 
    /*
        wpgp_ac_
        https://tools.knowledgewalls.com/agecomparison
    */

    wp_enqueue_style( 'wpgp-jquery-ui' ); 
    wp_enqueue_script( 'jquery-ui-datepicker');
    wp_enqueue_script( 'wpgp-age-comparision');
?>
<div>
    <table>
        <tr>
            <td>
                <div class='tool_title'>Online Age Comparison</div>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td><b class="lbl_title_info">Select Age</b></td>
                    </tr>
                    <tr>
                        <td>
                            <div>Younger Date of Birth(DOB):</div>
                            <input type="text" readonly size="30" id="wpgp_ac_txt_doj" name="wpgp_ac_txt_doj" />
                            <div class="wpgp_ac_txt_doj_feedback"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Elder Date of Birth(DOB):</div>
                            <input type="text" readonly size="30" id="wpgp_ac_txt_eod" name="wpgp_ac_txt_eod"/>
                            <div class="wpgp_ac_txt_eod_feedback" style="float:right"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <button class="button wpgp_ac_do_calculation">Calculate</button>
                            <button class="button wpgp_ac_clear_calculation">Clear</button></td>
                    </tr>
                </table>
                <div id="wpgp_ac_lbl_summary_info" class="ft_font bold" style="padding:10px 0px"></div>
            </td>
        </tr>
    </table>
</div>