// Class definition

var KTFormControls = (function() {
    // Private functions

    var demo2 = function() {
        $("#kt_form_new").validate({
            // define validation rules
            rules: {
                issueDescription: {
                    required: true
                },
                correctiveMeasure: {
                    required: true
                },
                planDate: {
                    required: true
                },
                endDate: {
                    required: true
                },
                input: {
                    required: true
                },
                frequency: {
                    required: true
                }
            },

            //display error alert on form submit
            invalidHandler: function(event, validator) {
                swal.fire({
                    title: "",
                    text: "Alguns campos obrigatórios não foram preenchidos.",
                    type: "error",
                    confirmButtonClass: "btn btn-secondary",
                    onClose: function(e) {
                        console.log("on close event fired!");
                    }
                });

                event.preventDefault();
            },

            submitHandler: function(form) {
                form.submit(), // submit the form
                swal.fire({
                    title: "",
                    text: "Operação Realizada com Sucesso! ",
                    type: "success",
                    confirmButtonClass: "btn btn-secondary"
                }).then();
                return false;
            }
        });
    };

    return {
        // public functions
        init: function() {
            demo2();
        }
    };
})();

jQuery(document).ready(function() {
    KTFormControls.init();
});
