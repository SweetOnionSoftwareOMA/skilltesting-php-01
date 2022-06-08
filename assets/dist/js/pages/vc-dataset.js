$(function () {
	var order_column_number = 2;
	var columns_defination 	= [];

	if (is_super_admin) {
		order_column_number = 3;
		columns_defination.push({ "className": "dt-nowrap", "sClass" : "text-nowrap", "data": "dataset_action", "name": "dataset_action"});
	}

	columns_defination.push({"className": "dt-nowrap", "sClass" : "text-nowrap", "data": "submitted_by", "name": "submitted_by"},
						    {"className": "dt-nowrap", "sClass" : "text-nowrap", "data": "location", "name": "location"},
						    {"data": "reporting_week", "name": "reporting_week"},
						    {"data": "location_gross_sales", "name": "location_gross_sales"},
						    {"data": "secondpair_eligible", "name": "secondpair_eligible"},
						    {"data": "secondpair_accepted", "name": "secondpair_accepted"},
						    {"data": "secondpair_conversion_rate", "name": "secondpair_conversion_rate"},
						    {"className": "dt-nowrap", "sClass" : "text-nowrap", "data": "created_at", "name": "created_at"});

    $("#vc-form-dataset").DataTable({dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
									"columns": columns_defination,
									"iDisplayLength": 100,
						      		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
						      		bAutoWidth: true,
									"responsive": false,
									"processing": true,
									"serverSide": true,
						      		"serverMethod": "POST",
						      		"ajax": {url : project_url+"app/vc_dataset/list", type : "POST"},
						      		"order": [[ order_column_number, "DESC" ]],
									"paging": true,
									"searching": true,
									"scrollX": true,
									"scroller": true,
	});
});
