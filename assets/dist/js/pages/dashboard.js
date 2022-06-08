$(function () {
  $('#formOD').validate({
	rules: {
	  'form["OD"]["doctor"]': {
			required: true,
		},
	},
	messages: {
	  'form["OD"]["doctor"]': {
			required: "Please provide a password",
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
