			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<table id="<?php echo strtolower(str_replace(' ', '-', $form['name']));?>-dataset" class="table table-bordered table-hover">
							<thead>
							<tr>
<?php
								foreach ($dataTable['headings'] as $column) {?>
								<th><?php echo $column;?></th>
<?php
								}?>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->
