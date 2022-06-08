$(function () {
    $('#user-list').DataTable({dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    						   "columns": [
								    {"data": "title", "name": "title"},
								    {"data": "first_name", "name": "first_name"},
								    {"data": "last_name", "name": "last_name"},
								    {"data": "username", "name": "username"},
								    {"data": "email", "name": "email"},
								    {"data": "created_at", "name": "created_at"},
								    {"data": "action", "name": "action"}
								],
						      	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
						      	bAutoWidth: true,
								"responsive": false,
								"processing": true,
								"serverSide": true,
						      	'serverMethod': 'POST',
						      	'ajax': {url : project_url+"office/manager/list", type : 'POST'},
						      	"order": [[ 5, "DESC" ]],
						      	"columnDefs": [
										        { "orderable": false, "targets": [6] },
										        { "orderable": true, "targets": [0, 1, 2, 3, 4, 5] },
										        { "className": 'text-center', "targets": [6] }
										    ],
								"paging": true,
								"searching": true,
						        buttons: [
						            {
						                text: '<i class="fas fa-user-plus"></i> Add Office User',
						                className: 'btn btn-primary',
						                action: function ( e, dt, node, config ) {
						                    window.location.href = project_url + 'office/manager/add';
						                }
						            }
						        ]
	});
});
