$(function () {
	var table = $('#view-users').DataTable({'dom' : "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      										'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
											'bAutoWidth': true,
											'responsive': false,
											'processing': true,
											'serverSide': true,
											'serverMethod': 'POST',
											'ajax': {
														url : project_url+'admin/users/list',
														type : 'POST',
														data : function ( d ) {
				        									d.showDeleted = $('#ShowDeleted').bootstrapSwitch('state');
				    									}
      												},
      										'order': [[ 5, 'DESC' ]],
      										'aoColumns' : [
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'title'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'first_name'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'last_name'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'username'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'email'},
												            {'className': 'dt-nowrap', 'sClass' : 'text-nowrap', 'mData' : 'created_at'},
												            {
												                'orderable': false,
												                'data': null,
												                'className': 'dt-nowrap', 'sClass' : 'text-center text-nowrap',
												 				render: function ( data, type, full, meta ) {
												                	return '<button type="button" class="btn btn-info view-user" title="View User"><i class="fas fa-info-circle"></i></button> | <button class="btn btn-primary edit-user" title="Edit User"><i class="fas fa-edit"></i></button> | ' + ((data.deleted == true) ? '<button class="btn btn-warning recover-user" title="Recover User"><i class="fas fa-trash-restore"></i></button>' : '<button class="btn btn-danger delete-user" title="Delete User"><i class="fas fa-trash"></i></button>' );
												                }
												            }
												          ],
											'paging' : true,
											'searching' : true,
											'buttons' : [{
															text: '<i class="fas fa-user-plus"></i> Add User',
															className: 'btn btn-info',
															action: function ( e, dt, node, config ) {
																window.location.href = project_url + 'admin/users/add';
															}
														}]
	});

	//View User
	$('#view-users tbody').on('click', 'button.view-user', function() {
		Swal.fire({text: 'Processing... Please wait.', showConfirmButton: false, allowOutsideClick: false});

		var data = table.row($(this).parents('tr')).data();

   		// AJAX request
		$.ajax({
			url: project_url+'admin/users/view/' + data.user_id,
			type: 'POST',
			data: {user_id: data.user_id},
			success: function(response){
				var user = jQuery.parseJSON( response );

				// Add response in Modal body
			    $('.modal-body #name').text(user.title + ' ' + user.first_name + ' ' + user.last_name);
			    $('.modal-body #email').text(user.email);
			    $('.modal-body #username').text(user.username);
			    var offices = '';

				$.each(user.offices, function(i, obj) {
					offices = offices + '<li class="list-group-item">' + obj.office_name + '</li>';
				});

				$('.modal-body #offices').html(offices);

			    var roles = '';
				$.each(user.roles, function(i, obj) {
					roles = roles + '<li class="list-group-item">' + obj.role_name + '</li>';
				});

				$('.modal-body #roles').html(roles);

				Swal.close();

				// Display Modal
				$('#user-modal').modal('show');
    		}
  		});
	});

	//Edit User
	$('#view-users tbody').on('click', 'button.edit-user', function() {
		var data = table.row($(this).parents('tr')).data();
		window.location.href = project_url+"admin/users/edit/"+data.user_id;
	});

	//Recover User
	$('#view-users tbody').on('click', 'button.recover-user', function() {
		Swal.fire({
					icon: 'question',
					title: 'Are you sure, you want to recover this user?',
					showDenyButton: true,
					showCancelButton: false,
					confirmButtonText: `Yes`,
					denyButtonText: `No`,
				  }).then((result) => {
					if (result.isConfirmed) {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = project_url+"admin/users/recover/"+data.user_id;
					} else if (result.isDenied) {
						Swal.close();
					}
		});
	});

	//Delete User
	$('#view-users tbody').on('click', 'button.delete-user', function() {
		Swal.fire({
					icon: 'question',
					title: 'Are you sure, you want to delete this user?',
					showDenyButton: true,
					showCancelButton: false,
					confirmButtonText: `Yes`,
					denyButtonText: `No`,
				  }).then((result) => {
					if (result.isConfirmed) {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = project_url+"admin/users/delete/"+data.user_id;
					} else if (result.isDenied) {
						Swal.close();
					}
		});
	});

	$('#ShowDeleted').on('switchChange.bootstrapSwitch', function (event, state) {
		table.ajax.reload();
	});
});
