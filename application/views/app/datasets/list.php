
				<!-- Left section -->
				<div class="container-fluid">
					<div class="row">
<?php
					if ($forms->num_rows()) {?>
<?php
						$count = 1;
						foreach ($forms->result() as $row) {?>
						<div class="col-md-4">
							<div class="card">
<?php
							if ($count%2 == 0): ?>
								<div class="card-body text-center">
	                    			<h5 class="text-center text-primary <?php echo ($count%2);?>"><?php echo $row->name;?> DataSet</h5>
	                    			<p class="card-text text-primary pb-2 pt-1"><?php echo substr($row->description, 0, 155);?></p>
	                    			<a href="<?php echo base_url();?>app/<?php echo str_replace('_form', '', $row->template_url);?>_dataset" class="btn btn-primary">View <?php echo $row->name;?> DataSet</a>
								</div>
								<img class="card-img-top" src="<?php echo site_url('assets/img/bg-tables.jpg');?>" alt="<?php echo $row->name;?>">
<?php
							else: ?>
								<img class="card-img-top" src="<?php echo site_url('assets/img/bg-practice-form.jpg');?>" alt="<?php echo $row->name;?>">
								<div class="card-body text-center">
	                    			<h5 class="text-center text-primary"><?php echo $row->name;?> DataSet</h5>
	                    			<p class="card-text text-primary pb-2 pt-1"><?php echo substr($row->description, 0, 155);?></p>
	                    			<a href="<?php echo base_url();?>app/<?php echo str_replace('_form', '', $row->template_url);?>_dataset" class="btn btn-primary">View <?php echo $row->name;?> DataSet</a>
								</div>
<?php
							endif;?>
							</div>
						</div>
<?php
							$count++;
						}?>
<?php
					} else {?>
						<div class="alert alert-warning">Sorry, no active form found!</div>
<?php
					}?>
					</div>
				</div>
