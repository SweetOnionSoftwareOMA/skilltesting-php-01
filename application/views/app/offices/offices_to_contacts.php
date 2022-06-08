<script>
	function toggleSelectAll(formID) {
		$('#' + formID + ' input:checkbox').each(function() {
			$(this).prop('checked', !$(this).prop('checked')).trigger('change');
		})
	}
</script>

<div class="row">
	<div class="col-md-6">
		<h3>Associating Contact Lenses to Office: <?= $office->office_name ?></h3>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="card card-lenscoating">
			<div class="card-body">
				<p class="card-text">
					<div class="author">
						<div class="block block-one"></div>
						<div class="block block-two"></div>
						<div class="block block-three"></div>
						<div class="block block-four"></div>
						<a href="javascript:void(0)">
							<i class="fad fa-genderless fa-6x"></i>
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
		<form method="post" action="<?= base_url('/appmgr/offices/save_contact_associations') ?>" id='FORM_office_configuration_contacts'>
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='<?= $office->office_id ?>'>
			<input type="hidden" name="previous_contacts" value='<?= implode(',', $office_contacts_array) ?>'>
			<input type="hidden" name="all_contacts" value='<?= implode(',', query_column_to_array($contacts->result(), 'contact_id')) ?>'>
			<table id="contacts" class="table table-striped" data-renderdatatable='true'>
				<thead>
					<tr>
						<th><a href="#" onClick="toggleSelectAll('FORM_office_configuration_contacts');">Select All</a></th>
						<th>Manufacturer</th>
						<th>Brand Name</th>
						<th>Qty</th>
						<th>Year Supply Discount</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($contacts->result() as $contactLens) : ?>
						<?php
							$checked = (in_array($contactLens->contact_id, $office_contacts_array)) ? 'checked' : 'no';
							$year_supply_discount = (isset($office_contacts[$contactLens->contact_id])) ? $office_contacts[$contactLens->contact_id]['year_supply_discount'] : null;
							$office_contact_id = (isset($office_contacts[$contactLens->contact_id])) ? $office_contacts[$contactLens->contact_id]['office_contact_id'] : null;
						?>
						<tr>
							<td>
								<input type="hidden" name="office_contact_id[<?= $contactLens->contact_id ?>]" value="<?= $office_contact_id ?>">
								<input class="form-input" type="checkbox" name="contact_ids[<?= $contactLens->contact_id ?>]" value='<?= $contactLens->contact_id ?>' <?= $checked ?>>
							</td>
							<td><?= $contactLens->manufacturer_name ?></td>
							<td><?= $contactLens->brand_name ?></td>
							<td><?= $contactLens->quantity ?></td>
							<td><input type="number" class="form-control" name="year_supply_discount[<?= $contactLens->contact_id ?>]" value="<?= $year_supply_discount ?>" size="8"></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<input type="submit" value="Assign contacts to Office" class="btn btn-primary">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

</div>
