<!---org_list CONTENT -->
<div class="row">
	<div class="col-md-2">
		<div class="row">
			<div class="col-sm-12">
				<a href="<?= site_url('/appmgr/organizations/add_organization') ?>" class="btn btn-sm btn-info">Add New Organization</a>
				<br><br><br>
			</div>
			<div class="col-sm-12">
				Deleted Organizations
				<?php
				if (isset($_GET['deleted']) && $_GET['deleted'] == 'true') {
					$userDelChecked = 'checked';
				} else {
					$userDelChecked = false;
				}
				?>
				<input type="checkbox" name="show_del" id="show_del" data-on-label='Hide' data-off-label='Show' class='bootstrap-switch' <?= $userDelChecked ?>>
			</div>
		</div>

	</div>
	<div class="col-md-8">
		<h2 class="text-center">Organization Listing</h2>
		<p class="text-center">
			An Organization is the parent group that allows for central management of multiple
			office locations. Users and locations (offices) can be assigned to Organizations, allowing users
			to move between locations (offices) and patient base be accessible from any office.
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
				<table id="TBL_organizations_listing" class="table table-striped" data-renderdatatable='true' data-dt_filtercolumns='[0]'>
					<thead>
						<tr>
							<th>Organization Name</th>
							<th>Users</th>
							<th>Offices (locations)</th>
							<th class="text-right">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($organizations->result() as $org) : ?>
							<tr>
								<td><?= $org->organization_name ?></td>
								<td>
									<?= $org->org_users ?>&nbsp;&nbsp;
									<a href="<?= site_url(['appmgr/organizations/associateUsers', $org->organization_id]) ?>" class=" btn btn-link btn-success btn-icon btn-md " data-toggle="tooltip" data-placement="right" title='Associate Users'><i class="fa-fw fa-2x fad fa-hospital-user"></i></a>
								</td>
								<td>
									<?= $org->org_offices ?>&nbsp;&nbsp;
									<a href="<?= site_url(['appmgr/organizations', 'associateOffices', $org->organization_id]) ?>" class=" btn btn-link btn-success btn-icon btn-md " data-toggle="tooltip" data-placement="right" title='Associate Offices'><i class="fa-fw fa-2x fad fa-clinic-medical"></i></a>
								</td>
								<td class="text-right" data-order="">
									<?php if (to_boolean($org->deleted)) : ?>
										<form action="<?= site_url('appmgr/organizations/restore_organization') ?>" method="post" id="form_del_<?= $org->organization_id ?>"><input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" /> <input type="hidden" name="organization_id" value='<?= $org->organization_id ?>'></form>
										<a href="javascript:confirmAction('Re-Activate Company: <?= $org->organization_name ?>', function(){document.getElementById('form_del_<?= $org->organization_id ?>').submit()});" class="btn btn-link btn-success btn-icon btn-md m3-2"><i class="fa-fw fa-2x fad fa-trash-undo"></i></a>
									<?php else : ?>
										<form action="<?= site_url('appmgr/organizations/delete_organization') ?>" method="post" id="form_del_<?= $org->organization_id ?>"><input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" /> <input type="hidden" name="organization_id" value='<?= $org->organization_id ?>'></form>
										<a href="<?= site_url(['appmgr/organizations', 'edit_organization', $org->organization_id]) ?>" class=" btn btn-link btn-warning btn-icon btn-md edit m3-2"><i class="fa-fw fa-2x fad fa-pencil"></i></a>
										<a href="javascript:confirmDelete(function(){document.getElementById('form_del_<?= $org->organization_id ?>').submit()});" class="btn btn-link btn-danger btn-icon btn-md remove m3-2"><i class="fa-fw fa-2x fad fa-times"></i></a>
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

<script>
	$('#show_del').on('switchChange.bootstrapSwitch', function(e) {
		window.location.href = '<?= site_url('appmgr/organizations/org_list?deleted=') ?>' + this.checked
	});
</script>

<!---org_list CONTENT -->
