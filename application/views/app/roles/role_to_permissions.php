<div class="row">
	<div class="col-md-4">
		<h3>Associating Permissions to Roles</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<div class="card card-user">
			<div class="card-body">
				<p class="card-text">
					<div class="author">
						<div class="block block-one"></div>
						<div class="block block-two"></div>
						<div class="block block-three"></div>
						<div class="block block-four"></div>
						<a href="javascript:void(0)">
							<i class="fad fa-users-crown fa-6x"></i>
							<h3 class="title">
								<?= $role->role_name ?>
							</h3>
						</a>
					</div>
				</p>
				<div class="card-description"></div>
			</div>
			<div class="card-footer">
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<form method="post" action="<?= base_url('/appmgr/roles/associate_to_permission') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="role_id" value='<?= $role->role_id ?>'>
			<table id="datatable" class="table table-striped" data-renderdatatable='true'>
				<thead>
					<tr>
						<th></th>
						<th>Description</th>
						<th>App Name</th>
						<th>Controller</th>
						<th>Page Method</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($permissions->result() as $permission) : ?>
						<tr>
							<td>
								<?php $checked = (to_boolean($permission->hasrole)) ? 'checked' : 'no'; ?>
								<input class="form-input" type="checkbox" name="permissions[]" id="role_<?= $permission->permission_id ?>" value='<?= $permission->permission_id ?>' <?= $checked ?>>
								<label class='form-label' for="permission_<?= $permission->permission_id ?>">
									<?= $permission->permission_name ?>
								</label>
							</td>
							<td><?= $permission->app ?></td>
							<td><?= $permission->description ?></td>
							<td><?= $permission->controller ?></td>
							<td><?= $permission->page_method ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<input type="submit" value="Assign Permissions to Role" class="btn btn-primary">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

</div>
