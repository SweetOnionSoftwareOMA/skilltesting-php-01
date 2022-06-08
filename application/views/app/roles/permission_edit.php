<div class="row">
	<div class="col-md-4">
		<h3>Editing Permission</h3>
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
								<?= $permission->permission_name ?>
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
		<form method="post" action="<?= base_url('/appmgr/permissions/update_permission') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="permission_id" value='<?= $permission->permission_id ?>'>
			<div class="card">
				<div class="card-header">
					<h4 class="title">Edit Permission</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Permission Name</label>
								<input type="text" class="form-control" value="<?= $permission->permission_name ?>" name="permission_name">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8 pr-md-1">
							<div class="form-group">
								<label>Description</label>
								<textarea name="description" id="description" cols="90" rows="4" class="form-control"><?= $permission->description ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Controller</label>
								<input type="text" class="form-control" value="<?= $permission->controller ?>" name="controller" disabled>
							</div>
						</div>
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Page Method</label>
								<input type="text" class="form-control" value="<?= $permission->page_method ?>" name="page_method" disabled>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-fill btn-primary">Update Permission</button>
				</div>
			</div>
		</form>
	</div>

</div>

<div class="row">
	<div class="col-sm-8">
		<h1>Associate Permission to Roles</h1>
	</div>
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<div class="toolbar">
					<!--        Here you can write extra buttons/actions for the toolbar              -->
				</div>
				<form action="<?= site_url('/appmgr/permissions/associate_to_role') ?>" method="post" role="form">
					<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
					<input type="hidden" name="permission_id" value='<?= $permission->permission_id ?>'>
					<table id="datatable" class="table table-striped">
						<thead>
							<tr>
								<th>Check to Assign Permission to Role</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($roles->result() as $role) : ?>

								<?php //  Only allow user to edit roles they have right to
									if ($this->authuser->hasRole($role->role_id)): ?>
								<tr>
									<td>
										<div class="form-check abc-checkbox abc-checkbox-success">
											<?php $checked = (to_boolean($role->haspermission)) ? 'n' : 'checked'; ?>
											<input class="form-check-input" type="checkbox" name="roles[]" id="role_<?= $role->role_id ?>" value='<?= $role->role_id ?>' <?= $checked ?>>
											<label class='form-check-label' for="role_<?= $role->role_id ?>">
												<?= $role->role_name ?>
											</label>
										</div>
									</td>
									<td> <?= $role->description ?> </td>
								</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2">
									<input type="submit" value="Assign Permission to Roles" class="btn btn-primary">
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
