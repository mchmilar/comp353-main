/**
 * Created by markc on 4/4/2017.
 */

window.Parsley
.addValidator('dollars', {
    requirementType: 'number',
    validateNumber: function(value) {
        return /^\d+(\.\d{0,2}){0,1}$/g.test(value);
    },
    messages: {
        en: 'Must be a number with up to two decimal places'
    }
});

window.Parsley.addValidator('name', {
    validateString: function(value,requirement){
        console.log(value.length);
        return (value.length <= requirement);
    },

    messages:{
        en: 'This name has an invalid length.'
    }
});

// window.Parsley.addValidator('phone',{
//     validateString: function(value){
//         console.log(value);
//         return ()
//     }
// });