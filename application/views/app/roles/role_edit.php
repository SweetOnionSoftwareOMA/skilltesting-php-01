<div class="row">
	<div class="col-md-4">
		<h3>Editing Role</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
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
	<div class="col-md-8">
		<form method="post" action="<?= base_url('/appmgr/roles/update_role') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="role_id" value='<?= $role->role_id ?>'>
			<div class="card">
				<div class="card-header">
					<h4 class="title">Edit Role</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Role Name</label>
								<input type="text" class="form-control" value="<?= $role->role_name ?>" name="role_name">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Description</label>
								<textarea name="description" id="description" cols="70" rows="4" class="form-control"><?= $role->description ?></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-fill btn-primary">Update Role</button>
				</div>
			</div>
		</form>
	</div>

</div>


<div class="row">
	<div class="col-lg-10">
		<div class="col-sm-12">
			<h1>Associate Permissions to Role</h1>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<div class="toolbar">
						<!--        Here you can write extra buttons/actions for the toolbar              -->
						Check to Assign Permission to Role
					</div>
					<form action="<?= site_url('/appmgr/roles/associate_to_permission') ?>" method="post" role="form">
						<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
						<input type="hidden" name="role_id" value='<?= $role->role_id ?>'>
						<input type="hidden" name="rdr" value="appmgr/roles/edit_role/<?= $role->role_id ?>">
						<table id="permissions" class="table table-striped" data-renderdatatable='true'>
							<thead>
								<tr>
									<th></th>
									<th>Permission</th>
									<th>Description</th>
									<th>Controller</th>
									<th>Method</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($permissions->result() as $permission) : ?>

									<?php //  Only allow user to edit permissions they have right to
									if ($this->authuser->haspermission($permission->permission_id)) : ?>
										<?php $checked = (in_array($permission->permission_id, $role_permissions)) ? 'checked' : 'n'; ?>
										<tr>
											<td data-sort="<?= $checked ?>">
												<input class="form-check-input" type="checkbox" name="permissions[]" value='<?= $permission->permission_id ?>' <?= $checked ?>>
											<td><?= $permission->permission_name ?></td>
											<td> <?= $permission->description ?> </td>
											<td> <?= $permission->controller ?> </td>
											<td> <?= $permission->page_method ?> </td>
										</tr>
									<?php endif; ?>
								<?php endforeach; ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2">
										<input type="submit" value="Assign Permissions to Role" class="btn btn-primary">
									</td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
				<!-- end content-->
			</div>
			<!--  end card  -->
		</div>
	</div>
	<div class="col-lg-6">

	</div>
</div>