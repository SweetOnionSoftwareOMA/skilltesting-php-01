<div class="row">
	<div class="col-md-4">
		<h3>Editing Organization</h3>
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
		<form method="post" action="<?= base_url('/appmgr/organizations/save_organization') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="organization_id" value='<?= $organization->organization_id ?>'>
			<div class="card">
				<div class="card-header">
					<h4 class="title">Create A New Organization</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Organization Name</label>
								<input type="text" class="form-control" value='<?= $organization->organization_name ?>' name="organization_name" required>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-fill btn-primary">Update New Organization</button>
				</div>
			</div>
		</form>
	</div>

</div>
<div class="row justify-content-between">
	<div class="col-md-3">
		<div class="card">
			<div class="card-body">
				<div class="toolbar">
					<a href="<?= site_url('') ?>">
						<div class="btn btn-primary btn-sm pull-right">

							<i class="fa fa-fa-plus-circle"></i> Update Users

						</div>
					</a>
					<h1>User List</h1>
					These are the Users associated to this organization.
				</div>
				<table id="TBL_users" class="table table-striped" data-renderdatatable='true'>
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
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">
				<div class="toolbar">
					<a href="<?= site_url('') ?>">
						<div class="btn btn-primary btn-sm pull-right">
							<i class="fa fa-fa-plus-circle"></i> Update Offices
						</div>
					</a>
					<h1>Office List</h1>
					These are the offices associated to this organization.
				</div>
				<table id="TBL_offices" class="table table-striped" data-renderdatatable='true'>
					<thead>
						<tr>
							<th>Active?</th>
							<th>Office</th>
							<th>Address</th>
							<th>City</th>
							<th>state</th>
							<th>Zip</th>
							<th>Phone</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($offices->result() as $office) : ?>
							<tr>
								<td> <?= (to_boolean($office->deleted)) ? 'Closed' : 'Active'; ?> </td>
								<td> <?= $office->office_name ?> </td>
								<td> <?= $office->address1 ?> </td>
								<td> <?= $office->city ?> </td>
								<td> <?= $office->state ?> </td>
								<td> <?= $office->zip ?> </td>
								<td> <?= $office->phone ?> </td>
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
