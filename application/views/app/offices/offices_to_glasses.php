<!--- offices_to_glasses CONTENT -->

<script>
	var sequenced_glasses = null;

	function buildGlassesSortable() {
		el = document.getElementById("glassesorter");
		console.log('building Sortable')
		sequenced_glasses = Sortable.create(el, {
			animation: 150,
			handle: '.sortable_handle',
			dataIdAttr: "data-sort",
			onSort: function( /**Event*/ e) {
				console.log('sorted')
				var items = e.to.children;
				var ids = [];
				var names = [];
				for (var i = 0; i < items.length; i++) {
					ids.push($(items[i]).data('id'));
					$('#sort_order_' + $(items[i]).data('id')).val(i);

				}
			},

		});
		// The initial load is arbitrary rendering from PHP, this fixes initial sort.
		reorderGlassesSortable();
	}

	function reorderGlassesSortable() {
		order = sequenced_glasses.toArray()
		sequenced_glasses.sort(order.sort());
	}

	function toggleSelectAll(formID) {
		$('#' + formID + ' input:checkbox').each(function() {
			$(this).prop('checked', !$(this).prop('checked')).trigger('change');
		})
	}
</script>

<div class="row">
	<div class="col-md-6">
		<h3>Associating Lenses to Office: <?= $office->office_name ?></h3>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="card card-service">
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
		<form method="post" action="<?= base_url('/appmgr/offices/save_glasses_associations') ?>" id="FORM_office_configuration_glasses">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='<?= $office->office_id ?>'>
			<input type="hidden" name="previous_glasses" value='<?= implode(',', $office_glasses_array) ?>'>
			<input type="hidden" name="all_glasses" value='<?= implode(',', query_column_to_array($glasses->result(), 'glasses_id')) ?>'>
			<table id="glasses" class="table table-striped" data-renderdatatable='true'>
				<thead>
					<tr>
						<th nowrap>
							Assign Lens<BR>
							<a href="#" onClick="toggleSelectAll('FORM_office_configuration_glasses');">Select All</a>
						</th>
						<th>Lens Type</th>
						<th>Lens</th>
						<th>Design MSRP</th>
						<th>Material MSRP</th>
						<th>Type MSRP</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($glasses->result() as $glasses) : ?>
						<?php
						// GET FORM VALUES
						$checked = (in_array($glasses->glasses_id, $office_glasses_array)) ?  'checked ' : 'n';
						$office_glasses_id = (isset($office_glasses[$glasses->glasses_id])) ? $office_glasses[$glasses->glasses_id]['office_glasses_id'] : null;
						$office_design_msrp = (isset($office_glasses[$glasses->glasses_id])) ? $office_glasses[$glasses->glasses_id]['design_msrp'] : null;
						$office_material_msrp = (isset($office_glasses[$glasses->glasses_id])) ? $office_glasses[$glasses->glasses_id]['material_msrp'] : null;
						$office_type_msrp = (isset($office_glasses[$glasses->glasses_id])) ? $office_glasses[$glasses->glasses_id]['type_msrp'] : null;
						?>
						<tr>
							<td data-sort="<?= $checked ?>">
								<input type="hidden" name="office_glasses_id[<?= $glasses->glasses_id ?>]" value="<?= $office_glasses_id ?>">
								<input class="form-input" type="checkbox" id="glasses_ids_<?= $glasses->glasses_id ?>" name="glasses_ids[<?= $glasses->glasses_id ?>]" value='<?= $glasses->glasses_id ?>' <?= $checked ?>>
								<script>
									$('#glasses_ids_<?= $glasses->glasses_id ?>').change(function() {
										li = '<li class="list-group-item" data-sort="99" id="sorter_service_<?= $glasses->glasses_id ?>" data-id="<?= $glasses->glasses_id ?>" data-name="<?= $glasses->glasses_name ?>"><i class="fas fa-arrows-alt sortable_handle fa-fw"></i><?= $glasses->glasses_name ?></li>';
										if ($(this).is(":checked")) {
											$(li).appendTo('#glassesorter');
											$('#sequence_id_<?= $glasses->glasses_id ?>').attr('required', true)
										} else {
											$('#sequence_id_<?= $glasses->glasses_id ?>').removeAttr('required')
											$('#sorter_service_<?= $glasses->glasses_id ?>').detach();
										}
										reorderGlassesSortable()
									});
								</script>
							</td>
							<td><?= $glasses->glasses_style ?> - <?= $glasses->lensstyle_name ?></td>
							<td><?= $glasses->lens_design ?> <?= $glasses->lens_material ?> <?= $glasses->lens_type ?></td>
							<td><input type="number" class="form-control" name="design_msrp[<?= $glasses->glasses_id ?>]" value="<?= $office_design_msrp ?>" size="8"></td>
							<td><input type="number" class="form-control" name="material_msrp[<?= $glasses->glasses_id ?>]" value="<?= $office_material_msrp ?>" size="8"></td>
							<td><input type="number" class="form-control" name="type_msrp[<?= $glasses->glasses_id ?>]" value="<?= $office_type_msrp ?>" size="8"></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<input type="submit" value="Assign glasses to Office" class="btn btn-primary">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

</div>


<script>
	$(document).ready(function() {
		buildGlassesSortable();
		$('#FORM_office_configuration_glasses').on('submit', function(e) {
			e.preventDefault();
			err = false;
			$('[id^=ssequence_id]').each(function(index) {
				// Reset the elements state.
				$(this).removeClass('is-invalid');

				id = this.id.split("_")[2]
				checked = $('#glasses_ids_' + id).prop("checked")
				if (checked) {
					// Only required id the user wants to include this service in the office.
					if (this.selectedIndex <= 0) {
						$(this).addClass('is-invalid');
						err = true;
					}

				}
			});
			if (!err) this.submit()
		})
	});
</script>

<!--- offices_to_glasses CONTENT -->
