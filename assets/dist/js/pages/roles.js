$(function () {
	var table = $('#view-roles').DataTable({dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
						      	'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
						      	bAutoWidth: true,
								'responsive': false,
								'processing': true,
								'serverSide': true,
						      	'serverMethod': 'POST',
						      	'ajax': {
						      				url : project_url+'admin/roles/list',
						      				type : 'POST',
										    data : function ( d ) {
				        						d.showDeleted = $('#ShowDeleted').bootstrapSwitch('state');
										    }
						      			},
						      	'order': [[ 4, 'DESC' ]],
							    'aoColumns' : [
							            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'role_name'},
							            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'description'},
							            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'super_admin'},
							            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'office_manager_can_assign'},
							            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'created_at'},
							            {
							                'orderable': false,
							                'data': null,
							                'className': 'dt-nowrap', 'sClass' : 'text-center text-nowrap',
							 				render: function ( data, type, full, meta ) {
							                	return '<button class="btn btn-primary edit-role" title="Edit Role"><i class="fas fa-edit"></i></button> | ' + ((data.deleted == true) ? '<button class="btn btn-warning recover-role" title="Recover Role"><i class="fas fa-trash-restore"></i></button>' : '<button class="btn btn-danger delete-role" data-toggle="tooltip" title="Delete Role"><i class="fas fa-trash"></i></button>' );
							                }
							            }],
								'paging': true,
								'searching': true,
						        buttons: [
						            {
						                text: '<i class="fas fa-plus"></i> Add Role',
						                className: 'btn btn-info',
						                action: function ( e, dt, node, config ) {
						                    window.location.href = project_url + 'admin/roles/add';
						                }
						            }
						        ],
								'scrollX': true,
								'scroller': true,
	});

	//Edit Role
	$('#view-roles tbody').on('click', 'button.edit-role', function() {
		var data = table.row($(this).parents('tr')).data();
		window.location.href = project_url+'admin/roles/edit/'+data.role_id;
	});

	//Recover Role
	$('#view-roles tbody').on('click', 'button.recover-role', function() {
		Swal.fire({
					icon: 'question',
					title: 'Are you sure, you want to recover this role?',
					showDenyButton: true,
					showCancelButton: false,
					confirmButtonText: `Yes`,
					denyButtonText: `No`,
				  }).then((result) => {
					if (result.isConfirmed) {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = project_url+'admin/roles/recover/'+data.role_id;
					} else if (result.isDenied) {
						Swal.close();
					}
		});
	});

	//Delete Role
	$('#view-roles tbody').on('click', 'button.delete-role', function() {
		Swal.fire({
					icon: 'question',
					title: 'Are you sure, you want to delete this role?',
					showDenyButton: true,
					showCancelButton: false,
					confirmButtonText: `Yes`,
					denyButtonText: `No`,
				  }).then((result) => {
					if (result.isConfirmed) {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = project_url+'admin/roles/delete/'+data.role_id;
					} else if (result.isDenied) {
						Swal.close();
					}
		});
	});

	$('#ShowDeleted').on('switchChange.bootstrapSwitch', function (event, state) {
		table.ajax.reload();
	});
});
