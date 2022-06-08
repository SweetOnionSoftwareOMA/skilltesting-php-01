<div class="row">
	<div class="col-md-6">
		<h3>Associating Lens Coatings to Office: <?= $office->office_name ?></h3>
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
							<i class="fad fa-spray-can fa-6x"></i>
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
		<form method="post" action="<?= base_url('/appmgr/offices/save_coatings_associations') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='<?= $office->office_id ?>'>
			<input type="hidden" name="previous_lenscoatings" value='<?= implode(',', $office_lenscoatings_array) ?>'>
			<input type="hidden" name="all_lenscoatings" value='<?= implode(',', query_column_to_array($lenscoatings->result(), 'lenscoating_id')) ?>'>
			<table id="lenscoatings" class="table table-striped" data-renderdatatable='true'>
				<thead>
					<tr>
						<th></th>
						<th>Coating Name</th>
						<th>AR U&C</th>
						<th>UV U&C</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($lenscoatings->result() as $coating) : ?>
						<?php
							$checked = (in_array($coating->lenscoating_id, $office_lenscoatings_array)) ? 'checked' : 'no';
							$msrp_ar = (isset($office_lenscoatings[$coating->lenscoating_id])) ? $office_lenscoatings[$coating->lenscoating_id]['msrp_ar'] : null;
							$msrp_uv = (isset($office_lenscoatings[$coating->lenscoating_id])) ? $office_lenscoatings[$coating->lenscoating_id]['msrp_uv'] : null;
							$office_lenscoatings_id = (isset($office_lenscoatings[$coating->lenscoating_id])) ? $office_lenscoatings[$coating->lenscoating_id]['office_lenscoatings_id'] : null;
						?>
						<tr>
							<td>
								<input type="hidden" name="office_lenscoatings_id[<?= $coating->lenscoating_id ?>]" value="<?= $office_lenscoatings_id ?>">
								<input class="form-input" type="checkbox" name="lenscoating_ids[<?= $coating->lenscoating_id ?>]" value='<?= $coating->lenscoating_id ?>' <?= $checked ?>>
							</td>
							<td><?= $coating->coating_name ?></td>
							<td><input type="number" class="form-control" name="msrp_ar[<?= $coating->lenscoating_id ?>]" value="<?= $msrp_ar ?>" size="8"></td>
							<td><input type="number" class="form-control" name="msrp_uv[<?= $coating->lenscoating_id ?>]" value="<?= $msrp_uv ?>" size="8"></td>

						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<input type="submit" value="Assign lenscoatings to Office" class="btn btn-primary">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

</div>
