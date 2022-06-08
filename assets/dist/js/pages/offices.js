$(function () {
    var table = $('#view-offices').DataTable({dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
						      				 'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
						      				 bAutoWidth: true,
						      				 'responsive': false,
						      				 'processing': true,
						      				 'serverSide': true,
						      				 'serverMethod': 'POST',
						      				 'ajax': {
						      							url : project_url+'admin/offices/list',
						      							type : 'POST',
										    			data : function ( d ) {
				        									d.showDeleted = $('#ShowDeleted').bootstrapSwitch('state');
										    			}
						      						 },
						      				 'order': [[ 10, 'DESC' ]],
						      				 'aoColumns' : [
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'office_name'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'office_color'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'notify_email_address'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'notify_new_data'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'address1'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'address2'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'city'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'state'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'zip'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'phone'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'app_url'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'taxrate'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'location_url'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'created_at'},
												            {
												                'orderable': false,
												                'data': null,
												                'className': 'dt-nowrap', 'sClass' : 'text-center text-nowrap',
												 				render: function ( data, type, full, meta ) {
												                	return '<button class="btn btn-primary edit-office" title="Edit Office"><i class="fas fa-edit"></i></button> | ' + ((data.deleted == true) ? '<button class="btn btn-warning recover-office" title="Recover Office"><i class="fas fa-trash-restore"></i></button>' : '<button class="btn btn-danger delete-office" title="Delete Office"><i class="fas fa-trash"></i></button>' );
												                }
												            }
												           ],
											 'paging': true,
											 'searching': true,
											 buttons: [
											            {
											                text: '<i class="fas fa-plus"></i> Add Office',
											                className: 'btn btn-info',
											                action: function ( e, dt, node, config ) {
											                    window.location.href = project_url + 'admin/offices/add';
											                }
											            }
						        					  ],
											 'scrollX': true,
											 'scroller': true
	});

	//Recover Office
	$('#view-offices tbody').on('click', 'button.recover-office', function() {
		Swal.fire({
					icon: 'question',
					title: 'Are you sure, you want to recover this office?',
					showDenyButton: true,
					showCancelButton: false,
					confirmButtonText: `Yes`,
					denyButtonText: `No`,
				  }).then((result) => {
					if (result.isConfirmed) {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = project_url+'admin/offices/recover/'+data.office_id;
					} else if (result.isDenied) {
						Swal.close();
					}
		});
	});

	//Edit Office
	$('#view-offices tbody').on('click', 'button.edit-office', function() {
		var data = table.row($(this).parents('tr')).data();
		window.location.href = project_url+'admin/offices/edit/'+data.office_id;
	});

	//Delete Office
	$('#view-offices tbody').on('click', 'button.delete-office', function() {
		Swal.fire({
					icon: 'question',
					title: 'Are you sure, you want to delete this office?',
					showDenyButton: true,
					showCancelButton: false,
					confirmButtonText: `Yes`,
					denyButtonText: `No`,
				  }).then((result) => {
					if (result.isConfirmed) {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = project_url+'admin/offices/delete/'+data.office_id;
					} else if (result.isDenied) {
						Swal.close();
					}
		});
	});

	$('#ShowDeleted').on('switchChange.bootstrapSwitch', function (event, state) {
		table.ajax.reload();
	});
});
