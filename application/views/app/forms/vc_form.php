
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-sm-12">
<?php
			$attributes = array('method' => 'post', 'id' => $form['template_url']);
			$hidden = array('user_id' => $this->session->userdata('user_id'));
			$reporting_week = '';
			if (isset($form_data['reporting_week'])){
				$date = new DateTime($form_data['reporting_week']);
				$reporting_week = $date->format("Y-W");
			}

			if (isset($form_data['vc_form_data_id'])) {
				$hidden['vc_form_data_id'] = $form_data['vc_form_data_id'];
				$hidden['office_id'] = $form_data['office_id'];
				$hidden['reporting_week'] = $reporting_week;
			}
			echo form_open(base_url().$formSubmitHandler, $attributes, $hidden);?>
			<fieldset>
				<div class="row">
					<div class="col-lg-12">
						<!-- Reporter Information -->
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">Reporter Information</h3>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'office_id'.((isset($form_data['vc_form_data_id'])) ? '_disabled' : '' );
												$locations = array('' => '- Select -');
												foreach ($this->session->userdata('user_offices') as $key => $value) {
													$locations[$key] = $value['name'];
												}
												$attributes = 'class="form-control" id="'.$inputName.'" tabindex="1"'.((isset($form_data['vc_form_data_id'])) ? ' readonly="readonly" disabled' : '' ).' required data-rule-required="true" data-msg-required="Please choose your Location."';?>
												<label for="<?php echo $inputName;?>">Choose Location<sup class="text-danger">*</sup></label>
												<?php echo form_dropdown($inputName, $locations, @$form_data['office_id'], $attributes);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'reporting_week'.((isset($form_data['vc_form_data_id'])) ? '_disabled' : '' );
												$data = array('type' => 'text',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => @$reporting_week,
					        								  'class' => 'form-control',
					        								  'tabindex' => '3',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please select Reporting Week.');

												if (isset($form_data['vc_form_data_id'])) {
													$data['readonly'] = 'readonly';
													$data['disabled'] = 'disabled';
												}?>
												<label for="<?php echo $inputName;?>">Reporting Week<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

									</div>
								</div>
			              	</div>
			              	<!-- /.card-body -->
			            </div>
			            <!--/.card -->
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<!-- Reporter Information -->
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">Sales Data</h3>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-lg-8 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'location_gross_sales';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'tabindex' => '4',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Total Weekly Sales.');?>
												<label for="<?php echo $inputName;?>">Total Weekly Sales (this location)<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'secondpair_eligible';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'tabindex' => '5',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Second Pair Offerings.');?>
												<label for="<?php echo $inputName;?>">Second Pair Offerings<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'secondpair_accepted';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'tabindex' => '6',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Second Pair Sold.');?>
												<label for="<?php echo $inputName;?>">Second Pairs Sold<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName 	= 'secondpair_conversion_rate';
												$data = array('type'     => 'number',
															  'id'       => $inputName,
					        								  'value'    => number_format(@$form_data[$inputName], 2),
					        								  'class'    => 'form-control',
					        								  'readonly' => 'readonly');?>
												<label for="<?php echo $inputName;?>">Second Pair Conversion</label>
												<div class="input-group">
													<?php echo form_input($data);?>
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-percentage"></i></span>
													</div>
												</div>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>
									</div>
								</div>
			              	</div>
			              	<!-- /.card-body -->
			            </div>
			            <!--/.card -->
					</div>
				</div>
				<!-- /Patient Encounters -->

				<div class="row">
					<div class="col-lg-12 col-sm-12">
            			<!-- Bootstrap Switch -->
            			<div class="card card-secondary">
              				<div class="card-body text-center">
								<input type="submit" class="btn btn-primary" value="<?php echo ((isset($form_data['vc_form_data_id'])) ? 'Update' : 'Save' );?>  Data" tabindex="11" />
								<input type="reset" class="btn btn-default" value="Reset Data" tabindex="12" />
              				</div>
            			</div>
            		</div>
            	</div>
			</fieldset>
			<?php echo form_close();?>
		</div>
	</div>
</div>
