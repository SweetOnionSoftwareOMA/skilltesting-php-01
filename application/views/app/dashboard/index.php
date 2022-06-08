		<!-- Left section -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3 sr-only">
					<div class="card">
						<img class="card-img-top" src="<?php echo site_url('assets/img/bg-tables.jpg');?>" alt="Tables">
						<div class="card-body text-center">
							<h5 class="text-primary">Datasets</h5>
							<p class="card-text text-primary">Review and edit previously submitted data. In addition, you can download your datasets for offline analysis.</p>
<?php 						if ($this->authuser->hasRole('Data Analyst')): ?>
							<a href="<?php echo base_url();?>app/datasets/list" class="btn btn-primary btn-block">View Datasets</a>
<?php 						else :?>
							<a href="javascript:void(0);" class="btn btn-primary btn-block disabled">View Datasets</a>
<?php 						endif; ?>
						</div>
					</div>
				</div>
				<div class="col-md-3 sr-only">
					<div class="card">
						<div class="card-body text-center">
							<h5 class="text-primary">Practice Form</h5>
							<p class="card-text text-primary">Use our forms increase visibility into your locations performance through focused Metrics that Matter.</p>
<?php 						if ($this->authuser->hasRole('OD Form') || $this->authuser->hasRole('Location Form') || $this->authuser->hasRole('VC Form')): ?>
							<a href="<?php echo base_url();?>app/forms/list" class="btn btn-primary btn-block">View Forms</a>
<?php 						else :?>
							<a href="javascript:void(0);" class="btn btn-primary btn-block disabled">View Forms</a>
<?php 						endif; ?>
						</div>
						<img class="card-img-top" src="<?php echo site_url('assets/img/bg-practice-form.jpg');?>" alt="Practice Form">
					</div>
				</div>
				<div class="col-md-6">
<?php
				$office_id = array();

				foreach($offices as $key => $value) {
					$office_id[] = $key;
				}

				foreach ($office_stats as $row) :

					if (!in_array($row->office_id, $office_id)):
						continue;

					endif;?>
					<div class="row">
						<div class="col-md-6 col-sm-12 col-12">
							<div class="info-box" style="border-radius: 2.3rem;">
								<div class="info-box-content">
									<span class="info-box-text" data-tooltip="<?php echo $offices[$row->office_id]['name'];?>"><?php echo ((strlen($offices[$row->office_id]['name'])>22) ? substr($offices[$row->office_id]['name'], 0, 22).'&hellip;' : $offices[$row->office_id]['name'] );?></span>
		                			<span class="info-box-number"><?php echo number_format($row->patient_encounters, 2);?> Patient<br>Encounters (MTD)</span>
								</div>
								<span class="info-box-icon" style="width: 50px;"><i class="fas fa-head-side-medical text-primary"></i></span>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<!-- /.col -->

						<div class="col-md-6 col-sm-12 col-12">
							<div class="info-box" style="border-radius: 2.3rem;">
								<div class="info-box-content">
									<span class="info-box-text" data-tooltip="<?php echo $offices[$row->office_id]['name'];?>"><?php echo ((strlen($offices[$row->office_id]['name'])>22) ? substr($offices[$row->office_id]['name'], 0, 22).'&hellip;' : $offices[$row->office_id]['name'] );?></span>
									<span class="info-box-number">$<?php echo number_format($row->total_sales, 2);?> Total<br>Sales (MTD)</span>
								</div>
								<span class="info-box-icon" style="width: 50px;"><i class="fas fa-money-bill-alt text-primary"></i></span>
								<!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
<?php
				endforeach;?>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
