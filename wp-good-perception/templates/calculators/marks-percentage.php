<?php
    /*
        wpgp_mp_
        https://tools.knowledgewalls.com/online-exam-marks-percentage-calculator
    */
    wp_enqueue_script( 'wpgp-marks-percentage');
?>
    <div class="kw_tools_box" style="max-width:728px">
    <div class="kw_forms">
        <h1 class="tool_title" style="font-size:29px">Marks Percentage Calculator</h1>
        <p class="tool_subtitle"><b>Applicable for all School and College Students: </b>All exams, 10th(SSLC) class, 11th, 12th(HSC), ITI, CBSE Boards, PUC, Academic, Diploma, Semester, BSC, MSC, MCA, Grade and Etc.,</p>
        <form name="frm_mark_calculator" id="frm_mark_calculator" method="post">
            <div id="div_tool_start_pos">
                <p><i><b>Hints:</b> Enter the subject marks one by one or overall scored total marks, then click on Add &amp; Calculate.</i></p>
            </div>
            <div class="form-group">
                <label for="txt_scoredmark">Scored mark:</label><input type="text" class="form-control" id="txt_scoredmark" name="txt_scoredmark">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="txt_outofmark">Out of mark:</label><input type="text" class="form-control" id="txt_outofmark" name="txt_outofmark">
                <div class="invalid-feedback"></div>
            </div>
            <textarea id="all_marks" name="all_marks" style="display:none"></textarea>
            <button type="submit" class="btn btn-primary" onclick="javascript: return validate_form();">Add &amp; Calculate</button><button type="reset" class="btn btn-primary" id="btn_clear">Clear</button>
        </form>
    </div>
    <div class="table-responsive" style="margin:9px 0px;display:none">
        <table id="score_details" class="table kw_table">
            <thead class="thead-dark kw_table_head">
                <tr>
                    <th>Scored mark</th>
                    <th>Out of mark</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <button class="btn btn-primary btn-sm" id="btn_add_next" title="Click here to add next subject's scored marks details.">+Add Next Mark</button>
        <div id="txt_overall_percentage" style="font-size:29px;font-weight:bold"></div>
    </div>
</div>