<!--- offices_to_services CONTENT -->

<script>
	var sequenced_services = null;

	function buildServicesSortable() {
		el = document.getElementById("serviceSorter");
		console.log('building Sortable')
		sequenced_services = Sortable.create(el, {
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
		reorderServicesSortable();
	}

	function reorderServicesSortable() {
		order = sequenced_services.toArray()
		sequenced_services.sort(order.sort());
	}

	function toggleSelectAll(formID) {
		$('#' + formID + ' input:checkbox').each(function() {
			$(this).prop('checked', !$(this).prop('checked')).trigger('change');
		})
	}
</script>

<div class="row">
	<div class="col-md-6">
		<h3>Associating Services to Office: <?= $office->office_name ?></h3>
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
				<ul class="list-group sortable-emptycontainer" id="serviceSorter">
					<?php foreach ($office_services as $id => $row) : ?>
						<li class="list-group-item" id="sorter_service_<?= $id ?>" data-sort="<?= $row['sort_order'] ?>" data-id="<?= $id ?>" data-name="<?= $row['service_name'] ?>"><i class="fas fa-arrows-alt sortable_handle fa-fw"></i><?= $row['service_name'] ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<form method="post" action="<?= base_url('/appmgr/offices/save_services_associations') ?>" id="FORM_office_configuration_services">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='<?= $office->office_id ?>'>
			<input type="hidden" name="previous_services" value='<?= implode(',', $office_services_array) ?>'>
			<input type="hidden" name="all_services" value='<?= implode(',', query_column_to_array($services->result(), 'service_id')) ?>'>
			<table id="services" class="table table-striped" data-renderdatatable='true'>
				<thead>
					<tr>
						<th nowrap>
							Assign Service<BR>
							<a href="#" onClick="toggleSelectAll('FORM_office_configuration_services');">Select All</a>
						</th>
						<th>Service</th>
						<th>Display As</th>
						<th>Sort Order</th>
						<th>Office MSRP</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($services->result() as $service) : ?>
						<?php
						// GET FORM VALUES
						$checked = (in_array($service->service_id, $office_services_array)) ?  'checked ' : 'n';
						$sort_order = (isset($office_services[$service->service_id])) ? $office_services[$service->service_id]['sort_order'] : null;
						$display_as = (isset($office_services[$service->service_id])) ? $office_services[$service->service_id]['display_as'] : null;
						$office_service_id = (isset($office_services[$service->service_id])) ? $office_services[$service->service_id]['office_service_id'] : null;
						$office_msrp = (isset($office_services[$service->service_id])) ? $office_services[$service->service_id]['msrp'] : null;
						?>
						<tr>
							<td data-sort="<?= $checked ?>">
								<input type="hidden" name="office_service_id[<?= $service->service_id ?>]" value="<?= $office_service_id ?>">
								<input class="form-input" type="checkbox" id="service_ids_<?= $service->service_id ?>" name="service_ids[<?= $service->service_id ?>]" value='<?= $service->service_id ?>' <?= $checked ?>>
								<script>
									$('#service_ids_<?= $service->service_id ?>').change(function() {
										li = '<li class="list-group-item" data-sort="99" id="sorter_service_<?= $service->service_id ?>" data-id="<?= $service->service_id ?>" data-name="<?= $service->service_name ?>"><i class="fas fa-arrows-alt sortable_handle fa-fw"></i><?= $service->service_name ?></li>';
										if ($(this).is(":checked")) {
											$(li).appendTo('#serviceSorter');
											$('#sequence_id_<?= $service->service_id ?>').attr('required', true)
										} else {
											$('#sequence_id_<?= $service->service_id ?>').removeAttr('required')
											$('#sorter_service_<?= $service->service_id ?>').detach();
										}
										reorderServicesSortable()
									});
								</script>
							</td>
							<td><?= $service->service_name ?></td>
							<td>
								<input type="text" class="form-control" name="display_as[<?= $service->service_id ?>]" value="<?= $display_as ?>">
							</td>
							<td><input type="number" class="form-control" id="sort_order_<?= $service->service_id ?>" name="sort_order[<?= $service->service_id ?>]" value="<?= $sort_order ?>" maxlength="4" size="4"></td>
							<td><input type="number" class="form-control" name="msrp[<?= $service->service_id ?>]" value="<?= $office_msrp ?>"></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<input type="submit" value="Assign Services to Office" class="btn btn-primary">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

</div>


<script>
	$(document).ready(function() {
		buildServicesSortable();
		$('#FORM_office_configuration_services').on('submit', function(e) {
			e.preventDefault();
			err = false;
			$('[id^=ssequence_id]').each(function(index) {
				// Reset the elements state.
				$(this).removeClass('is-invalid');

				id = this.id.split("_")[2]
				checked = $('#service_ids_' + id).prop("checked")
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

<!--- offices_to_services CONTENT -->
