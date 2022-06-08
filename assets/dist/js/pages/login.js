
$(function () {
	$('#frmLogin').validate({
		rules: {
			username: {
				required: true,
				minlength: 4,
				maxlength: 20,
			},
		  	password: {
				required: true,
				minlength: 8
		  	},
		},
		messages: {
			username: {
				required: "Please enter your username.",
				minlength: "Your username must be at least 4 characters long.",
				maxlength: "Your username cannot be more than 20 characters long.",
				pattern : "The username field must only contain letters and numbers only.",
			},
		  	password: {
				required: "Please provide a password.",
				minlength: "Your password must be at least 8 characters long."
		  	},
		},
		errorElement: 'span',
		errorPlacement: function (error, element) {
			error.addClass('invalid-feedback');
			element.closest('.input-group').append(error);
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
		}
	});
});
