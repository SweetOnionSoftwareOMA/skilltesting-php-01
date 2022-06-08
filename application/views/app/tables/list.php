		<!-- Left section -->
		<div class="chart-section custom_chartWrap">
			<div class="row">
				<div class="col-md">
<?php
				if ($forms->num_rows()) {?>
					<div class="card card-primary card-outline card-outline-tabs">
						<div class="card-header p-0 border-bottom-0">
							<ul class="nav nav-tabs nav-fill" id="form-tabs-four-tab" role="tablist">
<?php
					foreach ($forms->result() as $row) {
						$activeTab = (($activeTab == '') ? strtolower($row->name) : $activeTab );?>
								<li class="nav-item">
									<a class="nav-link<?php echo (($activeTab == strtolower($row->name)) ? ' active' : '' );?>" id="form-<?php echo strtolower($row->name);?>-tab" data-toggle="pill" href="#form-<?php echo strtolower($row->name);?>" role="tab" aria-controls="form-<?php echo strtolower($row->name);?>" aria-selected="true"><?php echo $row->name;?> MTM</a>
								</li>
<?php
					}?>
    						</ul>
  						</div>
  						<div class="card-body">
    						<div class="tab-content" id="form-tabs">
<?php
					foreach ($forms->result() as $row) {
						$formTemplateError = $formView = '';
						if ($row->template_url != '' && @file_exists(FCPATH.'application'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'forms'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$row->template_url.'.php')) {
							$formView = 'app/tables/templates/'.$row->template_url.'_table';
						} else {
							$formTemplateError = "\t\t\t\t\t\t\t".'<div class="alert alert-danger">Form template'.(($row->template_url == '') ? ' is not defined.' : ' ('.$row->template_url.') does not exists.' ).'</div>'."\n";
						}?>
      							<div class="tab-pane fade show<?php echo (($activeTab == strtolower($row->name)) ? ' active' : '' );?>" id="form-<?php echo strtolower($row->name);?>" role="tabpanel" aria-labelledby="form-<?php echo strtolower($row->name);?>-tab">
<?php
							echo $formTemplateError;
							if ($formView != '') {
								$this->load->view($formView, array('formSubmitHandler' => $formSubmitHandler, 'form' => $row, 'dataTable' => $dataTable));
							}?>
      							</div>
<?php
					}?>
	      					</div>
	      				</div>
						<!-- /.card -->
					</div>
<?php
				} else {
					echo '<div class="alert alert-warning">Sorry, no active form found!</div>';
				}?>
				</div>
			</div>
		</div>
