<!--- users_to_roles  CONTENT -->
<div class="row">
	<div class="col-sm-12">
		<h2>Assigning Roles to User:</h2>
	</div>
	<div class="col-sm-4">
		<h2><?= $user->first_name ?> <?= $user->last_name ?>
	</div>
	<div class="col-sm-4">
		<h4><?= $user->email ?></h2>
	</div>
	<div class="col-md-12">
		<p>
			Check the appropriate option next to a role. If you don't see a role listed, it is most likely
			because you do not have that role assigned to you.
		</p>
	</div>
</div>
<div class="row mt-5">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="toolbar">
					<!-- Here you can write extra buttons/actions for the toolbar -->
				</div>
				<form action="<?= site_url('/appmgr/usermgt/update_roles') ?>" method="post" role="form">
					<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
					<input type="hidden" name="user_id" value='<?= $user->user_id ?>'>
					<table id="datatable" class="table table-striped">
						<thead>
							<tr>
								<th>Check to Assign Role</th>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($roles->result() as $role) : ?>
								<tr>
									<td>
										<div class="form-check abc-checkbox abc-checkbox-success">
											<?php $checked = ($role->hasrole == null) ? 'not' : 'checked'; ?>
											<input class="form-check-input" type="checkbox" name="roles[]" id="role_<?= $role->role_id ?>" value='<?= $role->role_id ?>' <?= $checked ?>>
											<label class='form-check-label' for="role_<?= $role->role_id ?>">
												<?= $role->role_name ?>
											</label>
										</div>
									</td>
									<td> <?= $role->description ?> </td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2">
									<input type="submit" value="Update Roles" class="btn btn-primary">
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
	<!-- end col-md-12 -->
</div>
<!--- users_to_roles  CONTENT -->
