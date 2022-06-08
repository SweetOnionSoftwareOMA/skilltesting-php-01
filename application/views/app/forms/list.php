
				<!-- Left section -->
				<div class="container-fluid">
					<div class="row">
<?php
					if ($forms->num_rows()) {?>
<?php
						$count = 1;
						foreach ($forms->result() as $row) {
							$role = '';
							if ($row->form_id == 1):
								$role = 'OD Form';
							elseif ($row->form_id == 2):
								$role = 'Location Form';
							elseif ($row->form_id == 3):
								$role = 'VC Form';
							endif;?>
						<div class="col-md-4">
							<div class="card">
<?php
							if ($count%2 == 0): ?>
								<div class="card-body text-center">
	                    			<h5 class="text-center text-primary <?php echo ($count%2);?>"><?php echo $row->name;?></h5>
	                    			<p class="card-text text-primary pb-2 pt-1"><?php echo substr($row->description, 0, 155);?></p>
	                    			<a href="<?php echo (($this->authuser->hasRole($role)) ? base_url().'app/'.$row->template_url : 'javascript:void();' );?>" class="btn btn-primary<?php echo (($this->authuser->hasRole($role)) ? '' : ' disabled' );?>">Complete <?php echo $row->name;?></a>
								</div>
								<img class="card-img-top" src="<?php echo site_url('assets/img/bg-practice-form.jpg');?>" alt="<?php echo $row->name;?>">
<?php
							else: ?>
								<img class="card-img-top" src="<?php echo site_url('assets/img/bg-tables.jpg');?>" alt="<?php echo $row->name;?>">
								<div class="card-body text-center">
	                    			<h5 class="text-center text-primary"><?php echo $row->name;?></h5>
	                    			<p class="card-text text-primary pb-2 pt-1"><?php echo substr($row->description, 0, 155);?></p>
	                    			<a href="<?php echo (($this->authuser->hasRole($role)) ? base_url().'app/'.$row->template_url : 'javascript:void();' );?>" class="btn btn-primary<?php echo (($this->authuser->hasRole($role)) ? '' : ' disabled' );?>">Complete <?php echo $row->name;?></a>
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
