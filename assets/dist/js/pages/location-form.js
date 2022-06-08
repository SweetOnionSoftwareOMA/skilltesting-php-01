$(document).ready(function(){

	convertToWeekPicker($("#reporting_week"));

	var cash_not_collected      			= $("#cash_not_collected");
	var cash_collected     					= $("#cash_collected");
	var cash_collection_rate   			  	= $("#cash_collection_rate");

	cash_not_collected.add(cash_collected).on('keyup keypress blur change', function(e) {
		var total_cash = parseFloat(cash_collected.val())+parseFloat(cash_not_collected.val());
		calculateConversion(cash_collected.val(), total_cash, cash_collection_rate);
	});

	var scheduled_encounters 				= $("#scheduled_encounters");
	var ecounters_confirmed 				= $("#ecounters_confirmed");
	var ecounters_confirmed_rate 			= $("#ecounters_confirmed_rate");
	scheduled_encounters.add(ecounters_confirmed).on('keyup keypress blur change', function(e) {
		calculateConversion(ecounters_confirmed.val(), scheduled_encounters.val(), ecounters_confirmed_rate);
	});

	var encounters_patients 				= $("#encounters_patients");
	var encounters_no_show_rate  			= $("#encounters_no_show_rate");
	encounters_patients.add(scheduled_encounters).on('keyup keypress blur change', function(e) {
		$(encounters_no_show_rate).val( ((1-(encounters_patients.val() / scheduled_encounters.val())) * 100).toFixed(1) );
	});

	var encounters_newpatients 				= $("#encounters_newpatients");
	var enconters_newpatient_rate  			= $("#enconters_newpatient_rate");
	encounters_patients.add(encounters_newpatients).on('keyup keypress blur change', function(e) {
		calculateConversion(encounters_newpatients.val(), encounters_patients.val(), enconters_newpatient_rate);
	});

	var insurance_authorizations 			= $("#insurance_authorizations");
	var insurance_compliance_rate  			= $("#insurance_compliance_rate");
	encounters_patients.add(insurance_authorizations).on('keyup keypress blur change', function(e) {
		calculateConversion(insurance_authorizations.val(), encounters_patients.val(), insurance_compliance_rate);
	});

	var total_retinal_images_accepted		= $("#total_retinal_images_accepted");
	var retinal_images_accepted_rate		= $("#retinal_images_accepted_rate");
	var encounters_routine 					= $("#encounters_routine");
	encounters_routine.add(total_retinal_images_accepted).on('keyup keypress blur change', function(e) {
		calculateConversion(total_retinal_images_accepted.val(), encounters_routine.val(), retinal_images_accepted_rate);
	});

	var encounters_medical     				= $("#encounters_medical");
	var medical_conversion_rate				= $("#medical_conversion_rate");

	encounters_medical.add(encounters_patients).on('keyup keypress blur change', function(e) {
		calculateConversion(encounters_medical.val(), encounters_patients.val(), medical_conversion_rate);
	});

	var medical_insurance_card_collected	= $("#medical_insurance_card_collected");
	var insurance_conversion_rate			= $("#insurance_conversion_rate");

	medical_insurance_card_collected.add(encounters_medical).on('keyup keypress blur change', function(e) {
		calculateConversion(medical_insurance_card_collected.val(), encounters_medical.val(), insurance_conversion_rate);
	});

	var glasses_eligible_encounters 		= $("#glasses_eligible_encounters");
	var glasses_purchase_encounters 		= $("#glasses_purchase_encounters");
	var glasses_capture_rate  				= $("#glasses_capture_rate");

	glasses_eligible_encounters.add(glasses_purchase_encounters).on('keyup keypress blur change', function(e) {
		calculateConversion(glasses_purchase_encounters.val(), glasses_eligible_encounters.val(), glasses_capture_rate);
	});

	var contacts_eligible_encounters 		= $("#contacts_eligible_encounters");
	var contacts_purchase			 		= $("#contacts_purchase");
	var contact_capture_rate  				= $("#contact_capture_rate");

	contacts_eligible_encounters.add(contacts_purchase).on('keyup keypress blur change', function(e) {
		calculateConversion(contacts_purchase.val(), contacts_eligible_encounters.val(), contact_capture_rate);
	});

	$('#location_form').validate({
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
