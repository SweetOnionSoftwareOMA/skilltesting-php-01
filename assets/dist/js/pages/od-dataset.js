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
						    { "data": "routine_encounters", "name": "routine_encounters"},
						    { "data": "followup_encounters", "name": "followup_encounters"},
						    { "data": "followup_routing_rate", "name": "followup_routing_rate"},
						    { "data": "neurolens_eligble_patients", "name": "neurolens_eligble_patients"},
						    { "data": "neurolens_accepted", "name": "neurolens_accepted"},
						    { "data": "neurolens_conversion_rate", "name": "neurolens_conversion_rate"},
						    { "data": "has_ose_data", "name": "has_ose_data"},
						    { "data": "occular_surface_scheduled", "name": "occular_surface_scheduled"},
						    { "data": "occular_surface_performed", "name": "occular_surface_performed"},
						    { "data": "occular_surface_exam_rate", "name": "occular_surface_exam_rate"},
						    { "data": "lipiflow_treatments_performed", "name": "lipiflow_treatments_performed"},
						    { "data": "lipiflow_conversion_rate", "name": "lipiflow_conversion_rate"},
						    { "data": "myopia_eligble_patients", "name": "myopia_eligble_patients"},
						    { "data": "myopia_accepted", "name": "myopia_accepted"},
						    { "data": "myopia_conversion_rate", "name": "myopia_conversion_rate"},
						    { "className": "dt-nowrap", "sClass" : "text-nowrap", "data": "created_at", "name": "created_at"});

    $("#od-form-dataset").DataTable({dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
								    "columns": columns_defination,
									"iDisplayLength": 100,
						      		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
						      		bAutoWidth: true,
									"responsive": false,
									"processing": true,
									"serverSide": true,
						      		"serverMethod": "POST",
						      		"ajax": {url : project_url+"app/od_dataset/list", type : "POST"},
						      		"order": [[ order_column_number, "DESC" ]],
									"paging": true,
									"searching": true,
									"scrollX": true,
									"scroller": true,
	});
});
