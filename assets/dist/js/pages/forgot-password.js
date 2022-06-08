
$(function () {
  $('#frmForgetPassword').validate({
	rules: {
	  email: {
		required: true,
		email: true,
	  }
	},
	messages: {
	  email: {
		required: "Please enter a email address",
		email: "Please enter a vaild email address"
	  }
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
