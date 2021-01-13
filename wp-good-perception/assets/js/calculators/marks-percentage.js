jQuery.fn.show_error = function(text, focus, clear) {
    jQuery(".invalid-feedback").html("");
    jQuery(".invalid-feedback").hide();
    if (jQuery(this).next(".invalid-feedback").length == 1) {
        jQuery(this).next(".invalid-feedback").show();
        jQuery(this).next(".invalid-feedback").html(text);
        if (focus === undefined || focus === true) jQuery(this).focus();
        if (clear !== undefined || clear === true) jQuery(this).val("");
    }
};
jQuery(document).ready(function() {
    jQuery('html, body').animate({
        scrollTop: jQuery('#score_details').offset().top
    }, 'slow');
});
jQuery("#btn_add_next").click(function() {
    jQuery('html, body').animate({
        scrollTop: jQuery('#div_tool_start_pos').offset().top
    }, 'slow');
});

function validate_form() {
    if (jQuery("#txt_scoredmark").val() == "") {
        jQuery("#txt_scoredmark").show_error("Enter the Scored mark in the Subject. For Example Maths: 56/100. 56 is the scored marks.");
    } else if (isNaN(jQuery("#txt_scoredmark").val())) {
        jQuery("#txt_scoredmark").show_error("Scored mark should be a number.", true, true);
    } else if (jQuery("#txt_outofmark").val() == "") {
        jQuery("#txt_outofmark").show_error("Enter the Out Of Mark in the Subject. For Example Maths: 56/100. 100 is the scored marks.");
    } else if (isNaN(jQuery("#txt_outofmark").val())) {
        jQuery("#txt_outofmark").show_error("Out Of Mark should be a number.", true, true);
    } else if (parseInt(jQuery("#txt_scoredmark").val()) > parseInt(jQuery("#txt_outofmark").val())) {
        jQuery("#txt_scoredmark").show_error("Scored Mark should not be more than the Out Of Mark.", true);
    } else {
        return true;
    }
    return false;
}
jQuery(function() {
    jQuery(function() {
        jQuery("#txt_scoredmark").focus();
    });
    jQuery("#btn_clear").click(function() {
        jQuery("#txt_scoredmark").val("");
        jQuery("#txt_outofmark").val("");
        jQuery("#score_details").css("display", "none");
        jQuery(".added_td_info").remove();
        jQuery("#txt_overall_percentage").html("");
        jQuery("#all_marks").html("");
        jQuery(".invalid-feedback").html("");
        jQuery(".invalid-feedback").hide();
        jQuery("#txt_scoredmark").focus();
    });
});