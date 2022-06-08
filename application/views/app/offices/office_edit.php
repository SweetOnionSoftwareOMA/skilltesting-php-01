<div class="row">
	<div class="col-md-4">
		<h3>Editing Office</h3>
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
							<i class="fas fa-warehouse-alt fa-6x"></i>
							<h3 class="title"><?= $office->office_name ?></h3>
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
	<div class="col-md-8">
		<form method="post" action="<?= base_url('/appmgr/offices/save_office') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='<?= $office->office_id ?>'>
			<input type="hidden" name="old_org_id" value='<?= $office->organization_id ?>'>
			<div class="card">
				<div class="card-header">
					<h4 class="title">Create A New Office</h4>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<div class="form-group">
									<label>Belongs to Organization:</label>
									<select name="organization_id" id="organization_id" class="selectpicker " data-style="select-with-transition" data-live-search="true" title="Select Organization" data-size="7" required>
										<?php foreach ($orgs as $id => $name) : ?>
											<option value='<?= $id ?>' <?= ($id == $office->organization_id) ? 'selected' : '' ?>> <?= $name ?> </option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Office Name</label>
								<input type="text" class="form-control" value='<?= $office->office_name ?>' name="office_name" required>
							</div>
						</div>
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Tax Rate</label>
								<input type="number" class="form-control" value='<?= $office->taxrate ?>' name="taxrate" required min='0' max='99.9' step='any'>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Address</label>
								<input type="text" class="form-control" value='<?= $office->address1 ?>' name="address1" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Additional Address</label>
								<input type="text" class="form-control" value='<?= $office->address2 ?>' name="address2">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 pr-md-1">
							<div class="form-group">
								<label>City</label>
								<input type="text" class="form-control" value='<?= $office->city ?>' name="city" required>
							</div>
						</div>
						<div class="offset-md-1 col-md-4 pr-md-1">
							<div class="form-group">
								<label>State</label>
								<select name="state" id="state" class="selectpicker " data-style="select-with-transition" data-live-search="true" title="Select State" data-size="7" required>
									<?php foreach ($states as $abbr => $name) : ?>
										<option value='<?= $abbr ?>' <?= ($abbr == $office->state) ? 'selected' : '' ?>> <?= $name ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-3 pr-md-1">
							<div class="form-group">
								<label>Zip</label>
								<input type="text" class="form-control" value='<?= $office->zip ?>' name="zip" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 pr-md-1">
							<div class="form-group">
								<label>Phone</label>
								<input type="tel" class="form-control" value='<?= $office->phone ?>' name="phone" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 pr-md-1">
							<div class="form-group">
								<label>Application URL</label>
								<input type="url" class="form-control" value='<?= $office->app_url ?>' name="app_url">
							</div>
						</div>
						<div class="col-md-6 pr-md-1">
							<div class="form-group">
								<label>location URL</label>
								<input type="url" class="form-control" value='<?= $office->location_url ?>' name="location_url">
							</div>
						</div>

					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-fill btn-primary">Update New Office</button>
				</div>
			</div>
	</div>
	</form>
</div>

</div>
<div class="row justify-content-center">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="toolbar">
					<h1>User List</h1>
					These are the Users associated to this office.
				</div>
				<table id="TBL_users" class="table table-striped">
					<thead>
						<tr>
							<th>Active?</th>
							<th>UserName</th>
							<th>Name</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users->result() as $user) : ?>
							<tr>
								<td> <?= (to_boolean($user->deleted)) ? 'Deleted' : 'Active'; ?> </td>
								<td> <?= $user->email ?> </td>
								<td> <?= $user->last_name ?>, <?= $user->first_name ?> </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</form>
			</div>
			<!-- end content-->
		</div>
		<!--  end card  -->
	</div>
</div>
