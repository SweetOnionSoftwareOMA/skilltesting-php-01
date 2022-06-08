<!---role_list CONTENT -->
<div class="row">
	<div class="col-md-2">
		<div class="row">
			<div class="col-sm-12">
				<a href="<?= site_url('/appmgr/roles/add_role') ?>" class="btn btn-sm btn-info">Add New Role</a>
				<br><br><br>
			</div>
			<div class="col-sm-12">
				Deleted Roles
				<?php
				if (isset($_GET['deleted']) && to_boolean($_GET['deleted'])) {
					$userDelChecked = 'checked';
				} else {
					$userDelChecked = false;
				}
				?>
				<input type="checkbox" name="show_del" id="show_del" data-on-label='Hide' data-off-label='Show' class='bootstrap-switch' <?= $userDelChecked ?>>
			</div>
			<script>
				$('#show_del').on('switchChange.bootstrapSwitch', function(e) {
					window.location.href = '<?= site_url('appmgr/roles/roles_list?deleted=') ?>' + this.checked
				});
			</script>
		</div>
	</div>
	<div class="col-md-8">
		<h2 class="text-center">ROLE Listing</h2>
		<p class="text-center">
			Roles are a grouping of permissions or an empty assignment that drives site navigational displays.
		</p>
	</div>
</div>
<div class="row mt-5">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="toolbar">
					<!--        Here you can write extra buttons/actions for the toolbar              -->
				</div>
				<table id="TBL_roles" class="table table-striped" data-renderdatatable='true'>
					<thead>
						<tr>
							<th>Role Name</th>
							<th>Description</th>
							<th class="text-right">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($roles->result() as $role) : ?>
							<tr>
								<td><?= $role->role_name ?></td>
								<td><?= $role->description ?></td>
								<td class="text-right" data-order="">
									<?php if (!to_boolean($role->super_admin)) : // Never permit SA role to be deleted. ?>
										<?php if (to_boolean($role->deleted)) : ?>
											<form action="<?= site_url('appmgr/roles/restore_role') ?>" method="post" id="form_restore_<?= $role->role_id ?>"><input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" /> <input type="hidden" name="role_id" value='<?= $role->role_id ?>'></form>
											<a href="javascript:confirmAction('Re-Activate Role: <?= $role->role_name ?>', function(){document.getElementById('form_restore_<?= $role->role_id ?>').submit()});" class="btn btn-link btn-success btn-icon btn-md m3-2"><i class="fa-fw fa-2x fad fa-trash-undo"></i></a>
										<?php else : ?>
											<form action="<?= site_url('appmgr/roles/delete_role') ?>" method="post" id="form_del_<?= $role->role_id ?>"><input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" /> <input type="hidden" name="role_id" value='<?= $role->role_id ?>'></form>
											<a href="<?= site_url(['appmgr/roles/edit_role', $role->role_id]); ?>" class=" btn btn-link btn-warning btn-icon btn-md edit m3-2"><i class="fa-fw fa-2x fad fa-pencil"></i></a>
											<a href="<?= site_url(['appmgr/roles', 'associate_permissions', $role->role_id]); ?>" class=" btn btn-link btn-info btn-icon btn-md edit m3-2"><i class="fa-fw fa-2x fad fa-bezier-curve"></i></a>
											<a href="javascript:confirmDelete(function(){document.getElementById('form_del_<?= $role->role_id ?>').submit()});" class="btn btn-link btn-danger btn-icon btn-md remove m3-2"><i class="fa-fw fa-2x fad fa-times"></i></a>
										<?php endif; ?>

									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<!-- end content-->
		</div>
		<!--  end card  -->
	</div>
	<!-- end col-md-12 -->
</div>
<!---role_list CONTENT -->
