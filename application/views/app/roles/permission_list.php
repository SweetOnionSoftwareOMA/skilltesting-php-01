<!--- permission_list CONTENT -->

<div class="row">
	<div class="col-md-2">
		<div class="row">
			<div class="col-sm-12">
				Deleted permissions
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
					window.location.href = '<?= site_url('appmgr/permissions/permissions_list?deleted=') ?>' + this.checked
				});
			</script>
		</div>
	</div>
	<div class="col-md-8">
		<h2 class="text-center">Permissions Listing</h2>
		<p class="text-center">
			Permissions are a listing of all pages (controller & method). Permissions can be assigned to a
			role to permit access to a particular function.
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
				<table id="TBL_permissions_listing" class="table table-striped" data-renderdatatable='true'>
					<thead>
						<tr>
							<th>Permission Name<br>Can be modified from autoassign</th>
							<th>Description</th>
							<th>Controller</th>
							<th>Method</th>
							<th class="text-right">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($permissions->result() as  $permission) : ?>
							<tr>
								<td><?= $permission->permission_name ?></td>
								<td><?= $permission->description ?></td>
								<td><?= $permission->controller ?></td>
								<td><?= $permission->page_method ?></td>
								<td class="text-right" data-order="">
									<form action="<?= site_url('appmgr/permissions/delete_permission') ?>" method="post" id="form_del_<?= $permission->permission_id ?>"><input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" /> <input type="hidden" name="permission_id" value='<?= $permission->permission_id ?>'></form>
									<a href="<?= site_url(['appmgr/permissions/edit_permission', $permission->permission_id]); ?>" class=" btn btn-link btn-warning btn-icon btn-md edit m3-2"><i class="fa-fw fa-2x fad fa-pencil"></i></a>
									<?php if ($this->authuser->isSuperAdmin()) : //TODO: change this to in_array for DB efficentcy ?>
										<a href="javascript:confirmDelete(function(){document.getElementById('form_del_<?= $permission->permission_id ?>').submit()});" class="btn btn-link btn-danger btn-icon btn-md remove m3-2"><i class="fa-fw fa-2x fad fa-times"></i></a>
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
<!--- permission_list CONTENT -->
