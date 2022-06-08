<div class="row">
	<div class="col-md-6">
		<h3>Associating Users to Office: <?= $office->office_name ?></h3>
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
							<i class="fad fa-hospital-user fa-6x"></i>
							<h3 class="title">
								<?= $office->office_name ?>
							</h3>
						</a>
					</div>
				</p>
				<div class="card-description">
					<h4 class="title">At A Glance</h4>
					<p class="description">
						Start Date: <?= date('Y-m-d', strtotime($office->created_at))  ?>
					</p>
					<p class="description">
						Total Users: <?= $office->office_users_count ?>
					</p>
				</div>

			</div>
			<div class="card-footer">
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<form method="post" action="<?= base_url('/appmgr/offices/save_users_associations') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='<?= $office->office_id ?>'>
			<table id="users" class="table table-striped" data-renderdatatable='true'>
				<thead>
					<tr>
						<th></th>
						<th>UserName/Email</th>
						<th>Name</th>
						<th>In Org</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users->result() as $user) : ?>
						<?php $checked = (in_array($user->user_id, $office_users)) ? 'checked' : 'no'; ?>
						<tr>
							<td>
								<input class="form-input" type="checkbox" name="users[]" value='<?= $user->user_id ?>' <?= $checked ?>>
							</td>
							<td><?= $user->email ?></td>
							<td><?= $user->last_name ?>, <?= $user->first_name ?></td>
							<td><?php if (in_array($user->user_id, $organization_users)) { echo 'Yes'; } ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<input type="submit" value="Assign Users to Office" class="btn btn-primary">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

</div>
