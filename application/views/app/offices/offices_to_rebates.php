<script>
	function toggleSelectAll(formID) {
		$('#' + formID + ' input:checkbox').each(function() {
			$(this).prop('checked', !$(this).prop('checked')).trigger('change');
		})
	}
</script>


<div class="row">
	<div class="col-md-6">
		<h3>Associating Rebates to Office: <?= $office->office_name ?></h3>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="card card-rebate">
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
		<form method="post" action="<?= base_url('/appmgr/offices/save_rebates_associations') ?>" id="FORM_office_configuration_rebates">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='<?= $office->office_id ?>'>
			<input type="hidden" name="previous_rebates" value='<?= implode(',', $office_rebates_array) ?>'>
			<input type="hidden" name="all_rebates" value='<?= implode(',', query_column_to_array($rebates->result(), 'rebate_id')) ?>'>
			<table id="rebates" class="table table-striped" data-renderdatatable='true'>
				<thead>
					<tr>
						<th><a href="#" onClick="toggleSelectAll('FORM_office_configuration_rebates');">Select All</a></th>
						<th>Manufacturer</th>
						<th>Rebate Name</th>
						<th>Start Date</th>
						<th>End Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($rebates->result() as $rebate) : ?>
						<?php
							$checked = (in_array($rebate->rebate_id, $office_rebates_array)) ? 'checked' : 'no';
							$office_rebate_id = (isset($office_rebates[$rebate->rebate_id])) ? $office_rebates[$rebate->rebate_id]['office_rebate_id'] : null;
						?>
						<tr>
							<td>
								<input type="hidden" name="office_rebate_id[<?= $rebate->rebate_id ?>]" value="<?= $office_rebate_id ?>">
								<input type="hidden" name="manufacturer_name[<?= $rebate->rebate_id ?>]" value='<?= $rebate->manufacturer_name ?>'>
								<input class="form-input" type="checkbox" name="rebate_ids[<?= $rebate->rebate_id ?>]" value='<?= $rebate->rebate_id ?>' <?= $checked ?>>
							</td>
							<td><?= $rebate->manufacturer_name ?></td>
							<td><?= $rebate->rebate_name ?></td>
							<td><?= $rebate->start_date ?></td>
							<td><?= $rebate->end_date ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<input type="submit" value="Assign Rebates to Office" class="btn btn-primary">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

</div>
