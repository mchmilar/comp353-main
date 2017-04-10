/**
 * Created by markc on 4/4/2017.
 */

window.Parsley
    .addValidator('dollar', {
        requirementType: 'number',
        validateNumber: function(value) {
            return /^\d+(\.\d{0,2}){0,1}$/g.test(value);
        },
        messages: {
            en: 'Must be a number with up to two decimal places'
        }
    });


$(document).ready(function() {
    $("#po-edit-est-delivery").datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $("#po-edit-actual-delivery").datepicker({
        dateFormat: 'yy-mm-dd'
    });
} );

