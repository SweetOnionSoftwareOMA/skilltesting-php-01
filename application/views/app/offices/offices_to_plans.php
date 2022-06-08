<div class="row">
	<div class="col-md-6">
		<h3>Associating Plans to Office: <?= $office->office_name ?></h3>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="card card-plan">
			<div class="card-body">
				<p class="card-text">
					<div class="author">
						<div class="block block-one"></div>
						<div class="block block-two"></div>
						<div class="block block-three"></div>
						<div class="block block-four"></div>
						<a href="javascript:void(0)">
							<i class="fad fa-address-card fa-6x"></i>
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
				</div>

			</div>
			<div class="card-footer">
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<form method="post" action="<?= base_url('/appmgr/offices/save_plans_associations') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='<?= $office->office_id ?>'>
			<input type="hidden" name="old_plans" value='<?= implode(',', $office_plans) ?>'>
			<table id="plans" class="table table-striped" data-renderdatatable='true'>
				<thead>
					<tr>
						<th></th>
						<th>Plan Name</th>
						<th>Parent Company</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($plans->result() as $plan) : ?>
						<?php $checked = (in_array($plan->plan_id, $office_plans)) ? 'checked' : 'no'; ?>
						<tr>
							<td>
								<input class="form-input" type="checkbox" name="plans[]" value='<?= $plan->plan_id ?>' <?= $checked ?>>
							</td>
							<td><?= $plan->plan_name ?></td>
							<td><?= $plan->company_name ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<input type="submit" value="Assign Plans to Office" class="btn btn-primary">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

</div>
