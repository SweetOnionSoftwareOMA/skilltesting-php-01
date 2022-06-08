$(function () {
	var order_column_number = 2;
	var columns_defination 	= [];

	if (is_super_admin) {
		order_column_number = 3;
		columns_defination.push({ "className": "dt-nowrap", "sClass" : "text-nowrap", "data": "dataset_action", "name": "dataset_action"});
	}

	columns_defination.push({ "className": "dt-nowrap", "sClass" : "text-nowrap", "data": "submitted_by", "name": "submitted_by"},
						    { "className": "dt-nowrap", "sClass" : "text-nowrap", "data": "location", "name": "location"},
						    { "data": "reporting_week", "name": "reporting_week"},
						    { "data": "cash_not_collected", "name": "cash_not_collected"},
						    { "data": "cash_collected", "name": "cash_collected"},
						    { "data": "cash_collection_rate", "name": "cash_collection_rate"},
						    { "data": "dailylog_cash", "name": "dailylog_cash"},
						    { "data": "scheduled_encounters", "name": "scheduled_encounters"},
						    { "data": "ecounters_confirmed", "name": "ecounters_confirmed"},
						    { "data": "ecounters_confirmed_rate", "name": "ecounters_confirmed_rate"},
						    { "data": "encounters_patients", "name": "encounters_patients"},
						    { "data": "encounters_no_show_rate", "name": "encounters_no_show_rate"},
						    { "data": "encounters_newpatients", "name": "encounters_newpatients"},
						    { "data": "enconters_newpatient_rate", "name": "enconters_newpatient_rate"},
						    { "data": "insurance_authorizations", "name": "insurance_authorizations"},
						    { "data": "insurance_compliance_rate", "name": "insurance_compliance_rate"},
						    { "data": "total_retinal_images_accepted", "name": "total_retinal_images_accepted"},
						    { "data": "retinal_images_accepted_rate", "name": "retinal_images_accepted_rate"},
						    { "data": "encounters_routine", "name": "encounters_routine"},
						    { "data": "encounters_medical", "name": "encounters_medical"},
						    { "data": "medical_conversion_rate", "name": "medical_conversion_rate"},
						    { "data": "medical_insurance_card_collected", "name": "medical_insurance_card_collected"},
						    { "data": "insurance_conversion_rate", "name": "insurance_conversion_rate"},
						    { "data": "glasses_eligible_encounters", "name": "glasses_eligible_encounters"},
						    { "data": "glasses_purchase_encounters", "name": "glasses_purchase_encounters"},
						    { "data": "glasses_capture_rate", "name": "glasses_capture_rate"},
						    { "data": "contacts_eligible_encounters", "name": "contacts_eligible_encounters"},
						    { "data": "contacts_purchase", "name": "contacts_purchase"},
						    { "data": "contact_capture_rate", "name": "contact_capture_rate"},
						    { "data": "payment_plans_accepted", "name": "payment_plans_accepted"},
						    { "data": "social_reviews_google", "name": "social_reviews_google"},
						    { "data": "social_reviews_facebook", "name": "social_reviews_facebook"},
						    { "className": "dt-nowrap", "sClass" : "text-nowrap", "data": "created_at", "name": "created_at"});

	const table = $("#location-form-dataset").DataTable({dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
														"columns": columns_defination,
														"iDisplayLength": 100,
											      		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
											      		bAutoWidth: true,
														"responsive": false,
														"processing": true,
														"serverSide": true,
											      		"serverMethod": "POST",
											      		"ajax": {url : project_url+"app/location_dataset/list", type : "POST"},
											      		"order": [[ order_column_number, "DESC" ]],
														"paging": true,
														"searching": true,
														"scrollX": true,
														"scroller": true
	});
});
