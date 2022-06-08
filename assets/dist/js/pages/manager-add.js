$(document).ready(function(){

	var display = false;

	$('#toggleHidden').click(function(e) {
		e.preventDefault();

		display = !display; // default is false, because they are not shown.

		fields = $('input[name="password"], input[name="confirm_password"]');

		type = (display) ? 'text' : 'password'
		if (display) {
			$(this).text('Hide Password');
		} else {
			$(this).text('Show Password');
		}
		$.each(fields, function(indexInArray, valueOfElement) {
			$(this).attr("type", type);
		});
	});

	$('#add_office_user').validate({
		rules: {
			password: {
				required: true,
				minlength: 8
			},
			username: {
				required: true,
				minlength: 4,
				maxlength: 20,
				remote: project_url+'office/manager/is_available'
			}
		},
		messages: {
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 8 characters long"
			},
			username: {
				required: "Please enter a username.",
				minlength: "Your username must be at least 4 characters long.",
				maxlength: "Your username cannot be more than 20 characters long.",
				pattern : "The username field must only contain letters and numbers only.",
				remote: "\"{0}\" is already taken, please choose a different username."
			}
		},
		errorElement: "em",
		errorPlacement: function ( error, element ) {
			error.addClass( "text-danger" );
			element.parents( ".col-sm-5" ).addClass( "has-error" );

			if ( element.prop( "type" ) === "checkbox" ) {
				error.insertAfter( element.parent( "label" ) );
			} else {
				error.insertAfter( element );
			}
			if ( !element.next( "span" )[ 0 ] ) {
				$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
			}
		},
		success: function ( label, element ) {
			if ( !$( element ).next( "span" )[ 0 ] ) {
				$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
			}
		},
		highlight: function ( element, errorClass, validClass ) {
			$(element).addClass('is-invalid');
			$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
			$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
		},
		unhighlight: function ( element, errorClass, validClass ) {
			$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
			$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
			$(element).removeClass('is-invalid');
		}
	});
});
