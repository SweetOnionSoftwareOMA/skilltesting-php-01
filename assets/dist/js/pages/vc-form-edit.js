$(document).ready(function(){

	// convertToWeekPicker($("#reporting_week"));

	var secondpair_eligible      			= $("#secondpair_eligible");
	var secondpair_accepted     			= $("#secondpair_accepted");
	var secondpair_conversion_rate 			= $("#secondpair_conversion_rate");

	secondpair_eligible.add(secondpair_accepted).on('keyup keypress blur change', function(e) {
		calculateConversion(secondpair_accepted.val(), secondpair_eligible.val(), secondpair_conversion_rate);
	});

	$('#vc_form').validate({
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
