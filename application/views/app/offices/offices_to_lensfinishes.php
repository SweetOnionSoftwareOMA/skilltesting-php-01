<div class="row">
	<div class="col-md-6">
		<h3>Associating Lens Finishes to Office: <?= $office->office_name ?></h3>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="card card-lensfinish">
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
		<form method="post" action="<?= base_url('/appmgr/offices/save_finishes_associations') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='<?= $office->office_id ?>'>
			<input type="hidden" name="previous_lensfinishes" value='<?= implode(',', $office_lensfinishes_array) ?>'>
			<input type="hidden" name="all_lensfinishes" value='<?= implode(',', query_column_to_array($lensfinishes->result(), 'lensfinish_id')) ?>'>
			<table id="lensfinishes" class="table table-striped" data-renderdatatable='true'>
				<thead>
					<tr>
						<th></th>
						<th>Finish Name</th>
						<th>Office MSRP</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($lensfinishes->result() as $finish) : ?>
						<?php
							$checked = (in_array($finish->lensfinish_id, $office_lensfinishes_array)) ? 'checked' : 'no';
							$msrp = (isset($office_lensfinishes[$finish->lensfinish_id])) ? $office_lensfinishes[$finish->lensfinish_id]['msrp'] : null;
							$office_lensfinishes_id = (isset($office_lensfinishes[$finish->lensfinish_id])) ? $office_lensfinishes[$finish->lensfinish_id]['office_lensfinish_id'] : null;
						?>
						<tr>
							<td>
								<input type="hidden" name="office_lensfinish_id[<?= $finish->lensfinish_id ?>]" value="<?= $office_lensfinishes_id ?>">
								<input class="form-input" type="checkbox" name="lensfinish_ids[<?= $finish->lensfinish_id ?>]" value='<?= $finish->lensfinish_id ?>' <?= $checked ?>>
							</td>
							<td><?= $finish->lensfinish_name ?></td>
							<td><input type="number" class="form-control" name="msrp[<?= $finish->lensfinish_id ?>]" value="<?= $msrp ?>" size="8"></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<input type="submit" value="Assign lensfinishes to Office" class="btn btn-primary">
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>

</div>
