"use strict";

// Class Definition
var KTLogin = function() {
    var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

    // var _handleFormSignin = function() {
    //     var form = KTUtil.getById('kt_login_singin_form');
    //     var formSubmitUrl = KTUtil.attr(form, 'action');
    //     var formSubmitButton = KTUtil.getById('kt_login_singin_form_submit_button');

    //     if (!form) {
    //         return;
    //     }

    //     FormValidation
    //         .formValidation(
    //             form, {
    //                 fields: {
    //                     email: {
    //                         validators: {
    //                             notEmpty: {
    //                                 message: 'Email is required'
    //                             },
    //                             emailAddress: {
    //                                 message: 'The value is not a valid email address'
    //                             }
    //                         }
    //                     },
    //                     password: {
    //                         validators: {
    //                             notEmpty: {
    //                                 message: 'Password is required'
    //                             }
    //                         }
    //                     }
    //                 },
    //                 plugins: {
    //                     trigger: new FormValidation.plugins.Trigger(),
    //                     submitButton: new FormValidation.plugins.SubmitButton(),
    //                     //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
    //                     bootstrap: new FormValidation.plugins.Bootstrap({
    //                         //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
    //                         //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
    //                     })
    //                 }
    //             }
    //         )
    //         .on('core.form.valid', function() {
    //             // Show loading state on button
    //             KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

    //             // Simulate Ajax request
    //             setTimeout(function() {
    //                 KTUtil.btnRelease(formSubmitButton);
    //             }, 2000);

    //             // Form Validation & Ajax Submission: https://formvalidation.io/guide/examples/using-ajax-to-submit-the-form

    //             FormValidation.utils.fetch(formSubmitUrl, {
    //                 method: 'POST',
    //                 dataType: 'json',
    //                 params: {
    //                     email: form.querySelector('[name="email"]').value,
    //                     password: form.querySelector('[name="password"]').value,
    //                 },
    //             }).then(function(response) { // Return valid JSON
    //                 // Release button
    //                 KTUtil.btnRelease(formSubmitButton);

    //                 if (response && typeof response === 'object' && response.status && response.status == 'success') {
    //                     Swal.fire({
    //                         text: "All is cool! Now you submit this form",
    //                         icon: "success",
    //                         buttonsStyling: false,
    //                         confirmButtonText: "Ok, got it!",
    //                         customClass: {
    //                             confirmButton: "btn font-weight-bold btn-light-primary"
    //                         }
    //                     }).then(function() {
    //                         KTUtil.scrollTop();
    //                     });
    //                 } else {
    //                     Swal.fire({
    //                         text: "Sorry, something went wrong, please try again.",
    //                         icon: "error",
    //                         buttonsStyling: false,
    //                         confirmButtonText: "Ok, got it!",
    //                         customClass: {
    //                             confirmButton: "btn font-weight-bold btn-light-primary"
    //                         }
    //                     }).then(function() {
    //                         KTUtil.scrollTop();
    //                     });
    //                 }
    //             });

    //         })
    //         .on('core.form.invalid', function() {
    //             Swal.fire({
    //                 text: "Sorry, looks like there are some errors detected, please try again.",
    //                 icon: "error",
    //                 buttonsStyling: false,
    //                 confirmButtonText: "Ok, got it!",
    //                 customClass: {
    //                     confirmButton: "btn font-weight-bold btn-light-primary"
    //                 }
    //             }).then(function() {
    //                 KTUtil.scrollTop();
    //             });
    //         });
    // }

    // var _handleFormForgot = function() {
    //     var form = KTUtil.getById('kt_login_forgot_form');
    //     var formSubmitUrl = KTUtil.attr(form, 'action');
    //     var formSubmitButton = KTUtil.getById('kt_login_forgot_form_submit_button');

    //     if (!form) {
    //         return;
    //     }

    //     FormValidation
    //         .formValidation(
    //             form, {
    //                 fields: {
    //                     email: {
    //                         validators: {
    //                             notEmpty: {
    //                                 message: 'Email is required'
    //                             },
    //                             emailAddress: {
    //                                 message: 'The value is not a valid email address'
    //                             }
    //                         }
    //                     }
    //                 },
    //                 plugins: {
    //                     trigger: new FormValidation.plugins.Trigger(),
    //                     submitButton: new FormValidation.plugins.SubmitButton(),
    //                     //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
    //                     bootstrap: new FormValidation.plugins.Bootstrap({
    //                         //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
    //                         //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
    //                     })
    //                 }
    //             }
    //         )
    //         .on('core.form.valid', function() {
    //             // Show loading state on button
    //             KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

    //             // Simulate Ajax request
    //             setTimeout(function() {
    //                 KTUtil.btnRelease(formSubmitButton);
    //             }, 2000);
    //         })
    //         .on('core.form.invalid', function() {
    //             Swal.fire({
    //                 text: "Sorry, looks like there are some errors detected, please try again.",
    //                 icon: "error",
    //                 buttonsStyling: false,
    //                 confirmButtonText: "Ok, got it!",
    //                 customClass: {
    //                     confirmButton: "btn font-weight-bold btn-light-primary"
    //                 }
    //             }).then(function() {
    //                 KTUtil.scrollTop();
    //             });
    //         });
    // }

    // var _handleFormSignup = function() {
    //     // Base elements
    //     var wizardEl = KTUtil.getById('kt_login');
    //     var form = KTUtil.getById('kt_login_signup_form');
    //     var wizardObj;
    //     var validations = [];

    //     if (!form) {
    //         return;
    //     }

    //     // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    //     // Step 1
    //     // validations.push(FormValidation.formValidation(
    //     //     form, {
    //     //         fields: {
    //     //             name: {
    //     //                 validators: {
    //     //                     notEmpty: {
    //     //                         message: 'Full name is required'
    //     //                     }
    //     //                 }
    //     //             },
    //     //             password: {
    //     //                 validators: {
    //     //                     notEmpty: {
    //     //                         message: 'Password is required'
    //     //                     }
    //     //                 }
    //     //             },
    //     //             phone: {
    //     //                 validators: {
    //     //                     notEmpty: {
    //     //                         message: 'Phone is required'
    //     //                     }
    //     //                 }
    //     //             },
    //     //             email: {
    //     //                 validators: {
    //     //                     notEmpty: {
    //     //                         message: 'Email is required'
    //     //                     },
    //     //                     emailAddress: {
    //     //                         message: 'The value is not a valid email address'
    //     //                     }
    //     //                 }
    //     //             }
    //     //         },
    //     //         plugins: {
    //     //             trigger: new FormValidation.plugins.Trigger(),
    //     //             // Bootstrap Framework Integration
    //     //             bootstrap: new FormValidation.plugins.Bootstrap({
    //     //                 //eleInvalidClass: '',
    //     //                 eleValidClass: '',
    //     //             })
    //     //         }
    //     //     }
    //     // ));

    //     // // Step 2
    //     // validations.push(FormValidation.formValidation(
    //     //     form, {
    //     //         fields: {
    //     //             address: {
    //     //                 validators: {
    //     //                     notEmpty: {
    //     //                         message: 'Address is required'
    //     //                     }
    //     //                 }
    //     //             },
    //     //             bankAcNumber: {
    //     //                 validators: {
    //     //                     notEmpty: {
    //     //                         message: 'Bank Account Number is required'
    //     //                     }
    //     //                 }
    //     //             },
    //     //             bankAcName: {
    //     //                 validators: {
    //     //                     notEmpty: {
    //     //                         message: 'Bank Account is required'
    //     //                     }
    //     //                 }
    //     //             },
    //     //             IFSC: {
    //     //                 validators: {
    //     //                     notEmpty: {
    //     //                         message: 'Bank IFSC is required'
    //     //                     }
    //     //                 }
    //     //             },
    //     //             bankName: {
    //     //                 validators: {
    //     //                     notEmpty: {
    //     //                         message: 'Bank name is required'
    //     //                     }
    //     //                 }
    //     //             }
    //     //         },
    //     //         plugins: {
    //     //             trigger: new FormValidation.plugins.Trigger(),
    //     //             // Bootstrap Framework Integration
    //     //             bootstrap: new FormValidation.plugins.Bootstrap({
    //     //                 //eleInvalidClass: '',
    //     //                 eleValidClass: '',
    //     //             })
    //     //         }
    //     //     }
    //     // ));

    //     // // Initialize form wizard
    //     // wizardObj = new KTWizard(wizardEl, {
    //     //     startStep: 1, // initial active step number
    //     //     clickableSteps: false // allow step clicking
    //     // });

    //     // // Validation before going to next page
    //     // wizardObj.on('change', function(wizard) {
    //     //     if (wizard.getStep() > wizard.getNewStep()) {
    //     //         return; // Skip if stepped back
    //     //     }

    //     //     // Validate form before change wizard step
    //     //     var validator = validations[wizard.getStep() - 1]; // get validator for currnt step

    //     //     if (validator) {
    //     //         validator.validate().then(function(status) {
    //     //             if (status == 'Valid') {
    //     //                 wizard.goTo(wizard.getNewStep());

    //     //                 KTUtil.scrollTop();
    //     //             } else {
    //     //                 Swal.fire({
    //     //                     text: "Sorry, looks like there are some errors detected, please try again.",
    //     //                     icon: "error",
    //     //                     buttonsStyling: false,
    //     //                     confirmButtonText: "Ok, got it!",
    //     //                     customClass: {
    //     //                         confirmButton: "btn font-weight-bold btn-light"
    //     //                     }
    //     //                 }).then(function() {
    //     //                     KTUtil.scrollTop();
    //     //                 });
    //     //             }
    //     //         });
    //     //     }

    //     //     return false; // Do not change wizard step, further action will be handled by he validator
    //     // });

    //     // // Change event
    //     // wizardObj.on('changed', function(wizard) {
    //     //     KTUtil.scrollTop();
    //     // });

    //     // // Submit event
    //     // wizardObj.on('submit', function(wizard) {
    //     //     Swal.fire({
    //     //         text: "All is good! Please confirm the form submission.",
    //     //         icon: "success",
    //     //         showCancelButton: true,
    //     //         buttonsStyling: false,
    //     //         confirmButtonText: "Yes, submit!",
    //     //         cancelButtonText: "No, cancel",
    //     //         customClass: {
    //     //             confirmButton: "btn font-weight-bold btn-primary",
    //     //             cancelButton: "btn font-weight-bold btn-default"
    //     //         }
    //     //     }).then(function(result) {
    //     //         if (result.value) {
    //     //             form.submit(); // Submit form
    //     //         } else if (result.dismiss === 'cancel') {
    //     //             Swal.fire({
    //     //                 text: "Your form has not been submitted!.",
    //     //                 icon: "error",
    //     //                 buttonsStyling: false,
    //     //                 confirmButtonText: "Ok, got it!",
    //     //                 customClass: {
    //     //                     confirmButton: "btn font-weight-bold btn-primary",
    //     //                 }
    //     //             });
    //     //         }
    //     //     });
    //     // });
    // }

    // Public Functions
    // return {
    //     init: function() {
    //         _handleFormSignin();
    //         _handleFormForgot();
    //         _handleFormSignup();
    //     }
    // };
}();
//reegister
$("#kt_login_signup_form").validate({
    rules: {

        name: {
            required: true
        },
        password: {
            required: true,
        },
        phone: {
            required: true
        },
        email: {
            required: true
        },
        address: {
            required: true
        },
        bankAcNumber: {
            required: true
        },
        bankAcName: {
            required: true
        },
        IFSC: {
            required: true
        },
        bankName: {
            required: true
        },

    },
    messages: {

        name: {
            required: 'Full name is required'
        },
        password: {
            required: 'Password is required',
        },
        phone: {
            required: 'Phone is required'
        },
        email: {
            required: 'Email is required',
        },
        address: {
            required: 'Address is required ',
        },
        bankAcNumber: {
            required: 'Bank Account Number is required ',
        },
        bankAcName: {
            required: 'Bank Account is required ',
        },
        IFSC: {
            required: 'Bank IFSC is required ',
        },
        bankName: {
            required: 'Bank name is required ',
        },

    },
    errorClass: "help-inline",
    errorElement: "span",
    highlight: function(element, errorClass, validClass) {
        $(element).parents('.control-group').addClass('error');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).parents('.control-group').removeClass('error');
        $(element).parents('.control-group').addClass('success');
    }
});
//login
$("#kt_login_signup_form").validate({
    rules: {


        password: {
            required: true,
        },
        email: {
            required: true
        },
    },
    messages: {


        password: {
            required: 'Password is required',
        },
        email: {
            required: 'Email is required',
        },
    },
    errorClass: "help-inline",
    errorElement: "span",
    highlight: function(element, errorClass, validClass) {
        $(element).parents('.control-group').addClass('error');
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).parents('.control-group').removeClass('error');
        $(element).parents('.control-group').addClass('success');
    }
});
// Class Initialization
jQuery(document).ready(function() {
    //KTLogin.init();

});