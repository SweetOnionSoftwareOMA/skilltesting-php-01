
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

			if (isset($form_data['od_form_data_id'])) {
				$hidden['od_form_data_id'] = $form_data['od_form_data_id'];
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
												$inputName = 'office_id'.((isset($form_data['od_form_data_id'])) ? '_disabled' : '' );
												$locations = array('' => '- Select -');
												foreach ($this->session->userdata('user_offices') as $key => $value) {
													$locations[$key] = $value['name'];
												}
												$attributes = 'class="form-control" id="'.$inputName.'" tabindex="1"'.((isset($form_data['od_form_data_id'])) ? ' readonly="readonly" disabled' : '' ).' required data-rule-required="true" data-msg-required="Please choose your Location."';?>
												<label for="<?php echo $inputName;?>">Choose Location<sup class="text-danger">*</sup></label>
												<?php echo form_dropdown($inputName, $locations, @$form_data['office_id'], $attributes);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'reporting_week'.((isset($form_data['od_form_data_id'])) ? '_disabled' : '' );
												$data = array('type' => 'text',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => @$reporting_week,
					        								  'class' => 'form-control',
					        								  'tabindex' => '2',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please select Reporting Week.');

												if (isset($form_data['od_form_data_id'])) {
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
			                	<h3 class="card-title">Patient Encounters</h3>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'routine_encounters';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'tabindex' => '3',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Routine Encounters.');?>
												<label for="<?php echo $inputName;?>">Routine Encounters<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'followup_encounters';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'tabindex' => '4',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter F/U Appointments.');?>
												<label for="<?php echo $inputName;?>">F/U Appointments<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName 	= 'followup_routing_rate';
												$data = array('type'     => 'number',
															  'id'       => $inputName,
					        								  'value'    => number_format(@$form_data[$inputName], 2),
					        								  'class'    => 'form-control',
					        								  'readonly' => 'readonly');?>
												<label for="<?php echo $inputName;?>">Conversion Rate</label>
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
					<div class="col-lg-12">
						<!-- Reporter Information -->
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">NeuroLens Data</h3>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'neurolens_eligble_patients';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'tabindex' => '5',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Eligble Neurolens Patients.');?>
												<label for="<?php echo $inputName;?>">Eligble Neurolens Patients<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'neurolens_accepted';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'tabindex' => '6',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Neurolens Accepted.');?>
												<label for="<?php echo $inputName;?>">Neurolens Accepted<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName 	= 'neurolens_conversion_rate';
												$data = array('type'     => 'number',
															  'id'       => $inputName,
					        								  'value'    => number_format(@$form_data[$inputName], 2),
					        								  'class'    => 'form-control',
					        								  'readonly' => 'readonly');?>
												<label for="<?php echo $inputName;?>">Neurolens Conversion Rate</label>
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
				<!-- NeuroLens Data -->

				<div class="row">
					<div class="col-lg-12">
						<!-- Reporter Information -->
			            <div class="card card-primary card-outline ose_card<?php echo ((isset($form_data['od_form_data_id'])) ? ((to_boolean(@$form_data['has_ose_data'])) ? '' : ' collapsed-card' ) : ' collapsed-card' );?>">
			            	<div class="card-header">
			                	<h3 class="card-title">Ocular Surface Exams</h3>
				                <div class="card-tools">
			                  		<small>Report OSE data? <input id="has_ose_data" name="has_ose_data" type="checkbox"<?php echo ((isset($form_data['od_form_data_id']) && to_boolean(@$form_data['has_ose_data'])) ? ' checked="checked"' : '' );?> data-on-color="primary" data-off-color="default" data-on-text="Yes" data-off-text="No" data-size="mini" data-bootstrap-switch tabindex="8"></small>
			                	</div>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'occular_surface_scheduled';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter OSEs on Schedule.');?>
												<label for="<?php echo $inputName;?>">OSEs on Schedule<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'occular_surface_performed';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter OSEs Performed.');?>
												<label for="<?php echo $inputName;?>">OSEs Performed<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName 	= 'occular_surface_exam_rate';
												$data = array('type'     => 'number',
															  'id'       => $inputName,
					        								  'value'    => number_format(@$form_data[$inputName], 2),
					        								  'class'    => 'form-control',
					        								  'readonly' => 'readonly');?>
												<label for="<?php echo $inputName;?>">No Show Rate</label>
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
									<div class="row">
										<div class="col-lg-8 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'lipiflow_treatments_performed';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Lipiflow Treatments Administered.');?>
												<label for="<?php echo $inputName;?>">Lipiflow Treatments Administered</label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName 	= 'lipiflow_conversion_rate';
												$data = array('type'     => 'number',
															  'id'       => $inputName,
					        								  'value'    => number_format(@$form_data[$inputName], 2),
					        								  'class' 	 => 'form-control',
					        								  'readonly' => 'readonly');?>
												<label for="<?php echo $inputName;?>">Lipiflow Conversion Rate</label>
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
				<!-- Ocular Surface Exams -->

				<div class="row">
					<div class="col-lg-12">
						<!-- Reporter Information -->
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">Myopia Exams</h3>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'myopia_eligble_patients';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'tabindex' => '9',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Eligble Myopia Patients.');?>
												<label for="<?php echo $inputName;?>">Eligble Myopia Patients<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'myopia_accepted';
												$data = array('type'     => 'number',
															  'name'     => $inputName,
															  'id'       => $inputName,
															  'min'      => 0,
					        								  'value'    => @$form_data[$inputName],
					        								  'class'    => 'form-control',
					        								  'tabindex' => '10',
					        								  'required' => 'required',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Myopia Exam Accepted.');?>
												<label for="<?php echo $inputName;?>">Myopia Exam Accepted<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>

										<div class="col-lg-4 col-sm-12">
											<div class="form-group">
<?php
												$inputName 	= 'myopia_conversion_rate';
												$data = array('type'     => 'number',
															  'id'       => $inputName,
					        								  'value'    => number_format(@$form_data[$inputName], 2),
					        								  'class'    => 'form-control',
					        								  'readonly' => 'readonly');?>
												<label for="<?php echo $inputName;?>">Myopia Conversion Rate</label>
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
				<!-- Myopia Exams -->

				<div class="row">
					<div class="col-lg-12 col-sm-12">
            			<!-- Bootstrap Switch -->
            			<div class="card card-secondary">
              				<div class="card-body text-center">
								<input type="submit" class="btn btn-primary" value="<?php echo ((isset($form_data['od_form_data_id'])) ? 'Update' : 'Save' );?> Data" tabindex="11" />
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
