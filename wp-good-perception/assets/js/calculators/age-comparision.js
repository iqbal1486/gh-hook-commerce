function wpgp_ac_get_date_difference(t, e, d) {
    var r = 1000,
        o = r * 60,
        l = o * 60,
        n = l * 24,
        c = n * 7;
    t = new Date(t);
    e = (e == 'now') ? new Date() : new Date(e);
    var a = e.getTime() - t.getTime();
    if (isNaN(a)) return NaN;
    switch (d) {
        case 'years':
            return e.getFullYear() - t.getFullYear();
        case 'months':
            return ((e.getFullYear() * 12 + e.getMonth()) - (t.getFullYear() * 12 + t.getMonth()));
        case 'weeks':
            return Math.floor(a / c);
        case 'days':
            return Math.floor(a / n);
        case 'hours':
            return Math.floor(a / l);
        case 'minutes':
            return Math.floor(a / o);
        case 'seconds':
            return Math.floor(a / r);
        default:
            return undefined
    }
};

jQuery(function() {
    jQuery('#wpgp_ac_txt_doj').datepicker({
        changeMonth: !0,
        changeYear: !0,
        dateFormat: 'yy/mm/dd',
        yearRange: '-100:+10'
    });

    jQuery('#wpgp_ac_txt_eod').datepicker({
        changeMonth: !0,
        changeYear: !0,
        dateFormat: 'yy/mm/dd',
        yearRange: '-100:+10'
    });

    jQuery('.wpgp_ac_do_calculation').click(function() {
        jQuery('.wpgp_ac_txt_doj_feedback').html('');
        jQuery('.wpgp_ac_txt_eod_feedback').html('');
        jQuery('#wpgp_ac_lbl_summary_info').html('');

        if (jQuery('#wpgp_ac_txt_doj').val().trim() == '') {
            jQuery('.wpgp_ac_txt_doj_feedback').html('Enter the Younger DOB')
        } else if (jQuery('#wpgp_ac_txt_eod').val().trim() == '') {
            jQuery('.wpgp_ac_txt_eod_feedback').html('Enter the Elder DOB')
        } else {
            var r = new Date(jQuery('#wpgp_ac_txt_doj').val()),
                o = new Date(jQuery('#wpgp_ac_txt_eod').val());

            if (o.getTime() > r.getTime()) {
                jQuery('.wpgp_ac_txt_doj_feedback').html('Younger DOB Should be greater than Elder DOB')
            } else {
                var a = 0,
                    e = wpgp_ac_get_date_difference(jQuery('#wpgp_ac_txt_eod').val(), jQuery('#wpgp_ac_txt_doj').val(), 'months');
                a += e;
                var t = Math.floor(e / 12);
                e = e % 12;
                jQuery('#wpgp_ac_lbl_summary_info').html('Age Difference: ' + t + ' year(s), ' + e + ' month(s)')
            }
            
        }
    });

    jQuery('.wpgp_ac_clear_calculation').click(function() {
        jQuery('#wpgp_ac_txt_doj').val('');
        jQuery('#wpgp_ac_txt_eod').val('');
        jQuery('.wpgp_ac_txt_doj_feedback').html('');
        jQuery('.wpgp_ac_txt_eod_feedback').html('');
        jQuery('#wpgp_ac_lbl_summary_info').html('')
    })
});