<!--- USER LIST CONTENT -->
<div class="row">
	<div class="col-md-2">
		<div class="row">
			<div class="col-sm-12">
				<a href="<?= site_url('/appmgr/usermgt/user_add') ?>" class="btn btn-sm btn-info">Add New User</a>
				<br><br><br>
			</div>
			<div class="col-sm-12">
				Deleted Users
				<?php
				if (isset($_GET['deleted']) && to_boolean($_GET['deleted'])) {
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
		<h2 class="text-center">Application User Listing</h2>
		<p class="text-center">
			Here is a listing off all the users in the MTM application.
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
				<table id="TBL_user_listing" class="table table-striped" data-renderdatatable='true'>
					<thead>
						<tr>
							<th>Email/Login</th>
							<th>Name</th>
							<th>Company</th>
							<th>State</th>
							<th class="text-right">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users->result() as $user) : ?>
							<?php $trClass =  to_boolean($user->deleted) ? "text-red" : ''; ?>
							<tr>
								<td class='<?= $trClass ?>'><?= $user->email ?></td>
								<td class='<?= $trClass ?>'><?= $user->first_name ?> <?= $user->last_name ?></td>
								<td class='<?= $trClass ?>'><?= $user->company_name ?></td>
								<td class='<?= $trClass ?>'><?= $user->state ?></td>
								<td class="text-right" data-order="<?= $user->deleted ?>">
									<?php
									if (to_boolean($user->deleted)) {
										$formURL = site_url(['appmgr/usermgt', 'activate_user', $user->user_id]);
									} else {
										$formURL = site_url(['appmgr/usermgt', 'remove_user', $user->user_id]);
									}
									?>
									<form action="<?= $formURL ?>" method="post" id="form_del_<?= $user->user_id ?>"><input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" /> <input type="hidden" name="user_id" value='<?= $user->user_id ?>'></form>
									<?php if (to_boolean($user->deleted)) : ?>
										<a href="javascript:confirmAction('Re-Activate User: <?= $user->email ?>', function(){document.getElementById('form_del_<?= $user->user_id ?>').submit()});" class="btn btn-link btn-success btn-icon btn-md m3-2"><i class="fa-fw fa-2x fad fa-trash-undo"></i></a>
									<?php else : ?>
										<a href="<?= site_url(['appmgr/wizard', 'user_details', $user->user_id]) ?>" class=" btn btn-link btn-info btn-icon btn-md edit m3-2"><i class="fa-fw fa-2x fad fa-eye"></i></a>
										<a href="<?= site_url(['appmgr/usermgt', 'edit_user', $user->user_id]) ?>" class=" btn btn-link btn-warning btn-icon btn-md edit m3-2"><i class="fa-fw fa-2x fad fa-pencil"></i></a>
										<a href="<?= site_url(['appmgr/usermgt', 'user_role_manager', $user->user_id]) ?>" class=" btn btn-link btn-info btn-icon btn-md edit m3-2"><i class="fa-fw fa-2x fad fa-user-shield"></i></a>
										<a href="javascript:confirmDelete(function(){document.getElementById('form_del_<?= $user->user_id ?>').submit()});" class="btn btn-link btn-danger btn-icon btn-md remove m3-2"><i class="fa-fw fa-2x fad fa-times"></i></a>
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


<script src="<?= site_media('js', '/assets/js/validations.js') ?>"></script>
<script>
	$('#show_del').on('switchChange.bootstrapSwitch', function(e) {
		window.location.href = '<?= site_url('appmgr/usermgt/user_list?deleted=') ?>' + this.checked
	});
</script>
<!--- USER LIST CONTENT -->
