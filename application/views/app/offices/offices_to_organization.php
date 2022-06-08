<div class="row">
	<div class="col-md-6">
		<h3>Associate Offices to <?= $organization->organization_name ?></h3>
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
		<div class="card">
			<div class="card-body">
				<div class="toolbar">
				</div>
				<form action="<?= site_url('/appmgr/organizations/saveOfficeAssociations') ?>" method="post" office="form">
					<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
					<input type="hidden" name="organization_id" value='<?= $organization->organization_id ?>'>
					<table id="TBL_offices_to_orgs" class="table table-striped" data-renderdatatable='true'>
						<thead>
							<tr>
								<th>Office Name</th>
								<th>Office Location</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($offices->result() as $office) : ?>
								<?php $checked = ($office->organization_id == $organization->organization_id) ? 'checked' : null; ?>
								<tr>
									<td data-order="<?= $checked ?>">
										<input class="form-input" type="checkbox" name="offices[]" id="office_<?= $office->office_id ?>" value='<?= $office->office_id ?>' <?= $checked ?>>
										<label class='form-label' for="office_<?= $office->office_id ?>">
											<?= $office->office_name ?>
										</label>
									</td>
									<td> <?= $office->city ?>, <?= $office->state ?> </td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2">
									<input type="submit" value="Assign Offices" class="btn btn-primary">
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