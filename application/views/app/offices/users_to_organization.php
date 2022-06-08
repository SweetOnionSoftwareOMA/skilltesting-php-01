<div class="row">
	<div class="col-md-6">
		<h3>Associate Users to <?= $organization->organization_name ?></h3>
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
							<i class="fas fa-users fa-6x"></i>
							<h3 class="title"><?= $organization->organization_name ?></h3>
						</a>
					</div>
				</p>
				<div class="card-description">
					<h4 class="title">At A Glance</h4>
					<p class="description">
						Start Date: <?= date('Y-m-d', strtotime($organization->created_at))  ?>
					</p>

					<p class="description">
						Total Offices: <?= $organization->org_offices ?>
					</p>
					<p class="description">
						Total Users: <?= $organization->org_users ?>
					</p>
				</div>
			</div>
			<div class="card-footer">
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<div class="toolbar">
				</div>
				<form action="<?= site_url('/appmgr/organizations/saveUsersAssociations') ?>" method="post" user="form">
					<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
					<input type="hidden" name="organization_id" value='<?= $organization->organization_id ?>'>
					<table id="datatable" class="table table-striped">
						<thead>
							<tr>
								<th>Email/Login</th>
								<th>User's Name</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users->result() as $user) : ?>
								<?php $checked = (in_array($user->user_id, $organization_users)) ? 'checked' : null; ?>
								<tr>
									<td data-order="<?= $checked ?>">
										<input class="form-input" type="checkbox" name="users[]" id="user_<?= $user->user_id ?>" value='<?= $user->user_id ?>' <?= $checked ?>>
										<label class='form-label' for="user_<?= $user->user_id ?>">
											<?= $user->email ?>
										</label>
									</td>
									<td> <?= $user->last_name ?>,  <?= $user->first_name ?> </td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2">
									<input type="submit" value="Assign Users to Organization" class="btn btn-primary">
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