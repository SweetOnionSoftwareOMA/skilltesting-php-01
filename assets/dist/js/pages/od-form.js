$(document).ready(function(){

	convertToWeekPicker($("#reporting_week"));

	var routine_encounters      			= $("#routine_encounters");
	var followup_encounters     			= $("#followup_encounters");
	var followup_routing_rate   			= $("#followup_routing_rate");

	routine_encounters.add(followup_encounters).on('keyup keypress blur change', function(e) {
		calculateConversion(followup_encounters.val(), routine_encounters.val(), followup_routing_rate);
	});

	var neurolens_eligble_patients 			= $("#neurolens_eligble_patients");
	var neurolens_accepted 					= $("#neurolens_accepted");
	var neurolens_conversion_rate  			= $("#neurolens_conversion_rate");

	neurolens_eligble_patients.add(neurolens_accepted).on('keyup keypress blur change', function(e) {
		calculateConversion(neurolens_accepted.val(), neurolens_eligble_patients.val(), neurolens_conversion_rate);
	});

	var occular_surface_scheduled     		= $("#occular_surface_scheduled");
	var occular_surface_performed     		= $("#occular_surface_performed");
	var occular_surface_exam_rate  			= $("#occular_surface_exam_rate");
	occular_surface_scheduled.add(occular_surface_performed).on('keyup keypress blur change', function(e) {
		var total_OSEs = parseFloat(occular_surface_scheduled.val())-parseFloat(occular_surface_performed.val());
		calculateConversion(total_OSEs, occular_surface_scheduled.val(), occular_surface_exam_rate);
	});

	var lipiflow_treatments_performed 		= $("#lipiflow_treatments_performed");
	var lipiflow_conversion_rate 			= $("#lipiflow_conversion_rate");

	lipiflow_treatments_performed.add(occular_surface_scheduled).on('keyup keypress blur change', function(e) {
		calculateConversion(lipiflow_treatments_performed.val(), occular_surface_performed.val(), lipiflow_conversion_rate);
	});

	var myopia_eligble_patients      		= $("#myopia_eligble_patients");
	var myopia_accepted     			= $("#myopia_accepted");
	var myopia_conversion_rate   			= $("#myopia_conversion_rate");

	myopia_eligble_patients.add(myopia_accepted).on('keyup keypress blur change', function(e) {
		calculateConversion(myopia_accepted.val(), myopia_eligble_patients.val(), myopia_conversion_rate);
	});

  $('#has_ose_data').on('switchChange.bootstrapSwitch', function (event, state) {
  	if (state == true)
  		$('.ose_card').removeClass('collapsed-card');
  	else {
  		$('.ose_card').addClass('collapsed-card');
  		//Reset values to 0
  		$("#occular_surface_scheduled, #occular_surface_performed, #occular_surface_exam_rate, #lipiflow_treatments_performed, #lipiflow_conversion_rate").val(0);
  	}
  });

	$('#od_form').validate({
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
