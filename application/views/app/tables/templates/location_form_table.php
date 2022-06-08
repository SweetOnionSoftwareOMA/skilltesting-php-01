
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
<?php
	if (sizeof($dataTable[$form->name]['data'])) :?>
						<table id="<?php echo strtolower($form->name);?>-table" class="table table-bordered table-hover">
							<thead>
							<tr>
<?php
								foreach ($dataTable[$form->name]['headings'] as $column) {?>
								<th><?php echo $column;?></th>
<?php
								}?>
							</tr>
							</thead>
							<tbody>
<?php
								foreach ($dataTable[$form->name]['data'] as $result) {?>
							<tr>
<?php
									foreach ($result as $key => $value) {
										$value = str_replace('"', "", $value);?>
								<td><?php echo $value;?></td>
<?php							}?>
							</tr>
<?php
								}?>
							</tbody>
							<tfoot>
							<tr>
<?php
								foreach ($dataTable[$form->name]['headings'] as $column) {?>
								<th><?php echo $column;?></th>
<?php
								}?>
							</tr>
							</tfoot>
						</table>
<?php
	else:?>
						<div class="alert alert-danger">No entry found!</div>
<?php
	endif;?>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->
