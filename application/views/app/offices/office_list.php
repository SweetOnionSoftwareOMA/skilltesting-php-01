<!--- office_list CONTENT -->

<div class="row">
	<div class="col-md-2">
		<div class="row">
			<div class="col-sm-12">
				<a href="<?= site_url('/appmgr/offices/add_office') ?>" class="btn btn-sm btn-info">Add New Office</a>
				<br><br><br>
			</div>
			<div class="col-sm-12">
				Deleted Offices
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
		<h2 class="text-center">Office Listing</h2>
		<p class="text-center">
			An Office is the primary object which associates clients, benefits, and the
			retail/exam process to each other. An office must belong to an office, but that
			is permit patients and employees to move between locations with ease.
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
				<table id="TBL_office_listing" class="table table-striped" data-renderdatatable='true'>
					<thead>
						<tr>
							<th>Office Name</th>
							<th>Organization</th>
							<th>Users</th>
							<th>Location</th>
							<th>Configure Office</th>
							<th class="text-right">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($offices->result() as $office) : ?>
							<tr>
								<td><?= $office->office_name ?></td>
								<td><?= $office->organization_name ?></td>
								<td>
									<?= $office->office_users_count ?>&nbsp;&nbsp;
									<a href="<?= site_url(['appmgr/offices', 'associate_users', $office->office_id]) ?>" class=" btn btn-link btn-success btn-icon btn-md " data-toggle="tooltip" data-placement="right" title='Associate Users'><i class="fa-fw fa-2x fad fa-hospital-user"></i></a>
								</td>
								<td>
									<?= $office->city ?>, <?= $office->state ?>
								</td>
								<td>
									<?php if (! to_boolean($office->deleted)) : ?>
										<a href="<?= site_url(['appmgr/offices', 'associate_plans', $office->office_id]) ?>" class=" btn btn-link btn-info btn-icon btn-md edit mx-1"  data-toggle="tooltip" data-placement="right" title="Configure Insurance Plans"><i class="fa-fw fa-2x fad fa-address-card"></i></a>
										<a href="<?= site_url(['appmgr/offices', 'associate_glasses', $office->office_id]) ?>" class=" btn btn-link btn-warning btn-icon btn-md edit mx-1"  data-toggle="tooltip" data-placement="right" title="Configure Glasses/Lenses"><i class="fa-fw fa-2x fad fa-glasses"></i></a>
										<a href="<?= site_url(['appmgr/offices', 'associate_services', $office->office_id]) ?>" class=" btn btn-link btn-success btn-icon btn-md edit mx-1"  data-toggle="tooltip" data-placement="right" title="Configure Services"><i class="fa-fw fa-2x fad fa-dollar-sign"></i></a>
										<a href="<?= site_url(['appmgr/offices', 'associate_coatings', $office->office_id]) ?>" class=" btn btn-link btn-danger btn-icon btn-md edit mx-1"  data-toggle="tooltip" data-placement="right" title="Configure Coatings"><i class="fa-fw fa-2x fad fa-spray-can"></i></a>
										<a href="<?= site_url(['appmgr/offices', 'associate_finishes', $office->office_id]) ?>" class=" btn btn-link btn-warning btn-icon btn-md edit mx-1"  data-toggle="tooltip" data-placement="right" title="Configure Finishes"><i class="fa-fw fa-2x fad fa-pencil-paintbrush"></i></a>
										<a href="<?= site_url(['appmgr/offices', 'associate_contacts', $office->office_id]) ?>" class=" btn btn-link btn-info btn-icon btn-md edit mx-1"  data-toggle="tooltip" data-placement="right" title="Configure Contact Lenses"><i class="fa-fw fa-2x fad fa-genderless"></i></a>
										<a href="<?= site_url(['appmgr/offices', 'associate_rebates', $office->office_id]) ?>" class=" btn btn-link btn-success btn-icon btn-md edit mx-1"  data-toggle="tooltip" data-placement="right" title="Configure Rebates"><i class="fa-fw fa-2x fad fa-box-usd"></i></a>
									<?php endif; ?>
								</td>
								<td class="text-right" data-order="">
									<?php if (to_boolean($office->deleted)) : ?>
										<form action="<?= site_url('appmgr/offices/restore_office') ?>" method="post" id="form_del_<?= $office->office_id ?>"><input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" /> <input type="hidden" name="office_id" value='<?= $office->office_id ?>'></form>
										<a href="javascript:confirmAction('Re-Activate Company: <?= $office->office_name ?>', function(){document.getElementById('form_del_<?= $office->office_id ?>').submit()});" class="btn btn-link btn-success btn-icon btn-md mx-1"><i class="fa-fw fa-2x fad fa-trash-undo"></i></a>
									<?php else : ?>
										<form action="<?= site_url('appmgr/offices/delete_office') ?>" method="post" id="form_del_<?= $office->office_id ?>"><input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" /> <input type="hidden" name="office_id" value='<?= $office->office_id ?>'></form>
										<a href="<?= site_url(['appmgr/offices', 'edit_office', $office->office_id]) ?>" class=" btn btn-link btn-warning btn-icon btn-md edit mx-1"><i class="fa-fw fa-2x fad fa-pencil"></i></a>
										<a href="javascript:confirmDelete(function(){document.getElementById('form_del_<?= $office->office_id ?>').submit()});" class="btn btn-link btn-danger btn-icon btn-md remove mx-1"><i class="fa-fw fa-2x fad fa-times"></i></a>
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
		window.location.href = '<?= site_url('appmgr/offices/offices_list?deleted=') ?>' + this.checked
	});
</script>
<!--- office_list CONTENT -->
