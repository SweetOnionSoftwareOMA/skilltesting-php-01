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

						if (isset($form_data['location_form_data_id'])) {
							$hidden['location_form_data_id'] = $form_data['location_form_data_id'];
							$hidden['office_id'] = $form_data['office_id'];
							$hidden['reporting_week'] = $reporting_week;
						}?>
						<?php echo form_open(base_url().$formSubmitHandler, $attributes, $hidden);?>
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
															$inputName = 'office_id'.((isset($form_data['location_form_data_id'])) ? '_disabled' : '' );
															$locations = array('' => '- Select -');
															foreach ($this->session->userdata('user_offices') as $key => $value) {
																$locations[$key] = $value['name'];
															}
															$attributes = 'class="form-control" id="'.$inputName.'" tabindex="1"'.((isset($form_data['location_form_data_id'])) ? ' readonly="readonly" disabled' : '' ).' required data-rule-required="true" data-msg-required="Please choose your Location."';?>
															<label for="<?php echo $inputName;?>">Choose Location<sup class="text-danger">*</sup></label>
															<?php echo form_dropdown($inputName, $locations, @$form_data['office_id'], $attributes);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'reporting_week'.((isset($form_data['location_form_data_id'])) ? '_disabled' : '' );
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => @$reporting_week,
								        								  'class' => 'form-control',
								        								  'tabindex' => '2',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please select Reporting Week.');

															if (isset($form_data['location_form_data_id'])) {
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
						                	<h3 class="card-title">Practice Cash</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'cash_not_collected';
															$data = array('type'     => 'number',
																		  'name'     => $inputName,
																		  'id'       => $inputName,
																		  'min'      => 0,
								        								  'value'    => @$form_data[$inputName],
								        								  'class'    => 'form-control',
								        								  'tabindex' => '3',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Cash Not Collected.');?>
															<label for="<?php echo $inputName;?>">Cash Not Collected<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'cash_collected';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '4',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Cash Collected.');?>
															<label for="<?php echo $inputName;?>">Cash Collected<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'cash_collection_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
								        								  'readonly' => 'readonly');?>
															<label for="<?php echo $inputName;?>">Cash Collection Rate</label>
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
															$inputName = 'dailylog_cash';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '5',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Sum Daily Log.');?>
															<label for="<?php echo $inputName;?>">Sum Daily Log $$ for Reporting Week<sup class="text-danger">*</sup></label>
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
							<!-- /Practice Cash -->

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
															$inputName = 'scheduled_encounters';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '6',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Scheduled Encounters.');?>
															<label for="<?php echo $inputName;?>">Scheduled Encounters<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-5 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'ecounters_confirmed';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '7',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Patient Encounters.');?>
															<label for="<?php echo $inputName;?>">Confirmed Appointments<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'ecounters_confirmed_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
								        								  'readonly' => 'readonly');?>
															<label for="<?php echo $inputName;?>">Confirmation Rate</label>
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
															$inputName = 'encounters_patients';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '8',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Patient Encounters.');?>
															<label for="<?php echo $inputName;?>">Patient Encounters<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'encounters_no_show_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
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
															$inputName = 'encounters_newpatients';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '9',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter New Patient Encounters.');?>
															<label for="<?php echo $inputName;?>">New Patient Encounters<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'enconters_newpatient_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
								        								  'readonly' => 'readonly');?>
															<label for="<?php echo $inputName;?>">New Patients Rate</label>
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
															$inputName = 'insurance_authorizations';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '10',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Completed Insurance Authorizations.');?>
															<label for="<?php echo $inputName;?>">Completed Insurance Authorizations<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'insurance_compliance_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
								        								  'readonly' => 'readonly');?>
															<label for="<?php echo $inputName;?>">Authorization Compliance Rate</label>
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
															$inputName = 'encounters_routine';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '11',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Routine Encounters.');?>
															<label for="<?php echo $inputName;?>">Routine Encounters<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-8 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'total_retinal_images_accepted';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '12',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Total Retinal Images Accepted.');?>
															<label for="<?php echo $inputName;?>">Total Retinal Images Accepted (Optos & Clarius)<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'retinal_images_accepted_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
								        								  'readonly' => 'readonly');?>
															<label for="<?php echo $inputName;?>">Retinal Images Accepted Rate</label>
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
						                	<h3 class="card-title">Medical Encounters</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
													<div class="col-lg-8 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'encounters_medical';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '13',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Medical Encounters.');?>
															<label for="<?php echo $inputName;?>">Medical Encounters<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'medical_conversion_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
								        								  'readonly' => 'readonly');?>
															<label for="<?php echo $inputName;?>">Medical Conversion Rate</label>
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
															$inputName = 'medical_insurance_card_collected';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '14',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Insurance Card Entries.');?>
															<label for="<?php echo $inputName;?>">Insurance Card Entries (Medical Only)<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'insurance_conversion_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
								        								  'readonly' => 'readonly');?>
															<label for="<?php echo $inputName;?>">Insurance Conversion Rate</label>
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
							<!-- /Medical Encounters -->

							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Sales Data</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'glasses_eligible_encounters';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '15',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Glasses Eligible Patients.');?>
															<label for="<?php echo $inputName;?>">Glasses Eligible Patients<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'glasses_purchase_encounters';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '16',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Patients Purchasing Glasses.');?>
															<label for="<?php echo $inputName;?>">Patients Purchasing Glasses<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'glasses_capture_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
								        								  'readonly' => 'readonly');?>
															<label for="<?php echo $inputName;?>">Glasses Capture Rate</label>
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
													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'contacts_eligible_encounters';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '17',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Contact Eligible Patients.');?>
															<label for="<?php echo $inputName;?>">Contact Eligible Patients<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'contacts_purchase';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '18',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Patients Purchasing Contacts.');?>
															<label for="<?php echo $inputName;?>">Patients Purchasing Contacts<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName 	= 'contact_capture_rate';
															$data = array('type' => 'number',
																		  'id' => $inputName,
								        								  'value' => number_format(@$form_data[$inputName], 2),
								        								  'class' => 'form-control',
								        								  'readonly' => 'readonly');?>
															<label for="<?php echo $inputName;?>">Contacts Capture Rate</label>
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
															$inputName = 'payment_plans_accepted';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '19',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter # of Payment Plans Accepted.');?>
															<label for="<?php echo $inputName;?>"># of Payment Plans Accepted<sup class="text-danger">*</sup></label>
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
							<!-- /Sales Data -->

							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Social Media Interactions</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'social_reviews_google';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '20',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Google Reviews.');?>
															<label for="<?php echo $inputName;?>">Google Reviews<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'social_reviews_facebook';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
																		  'min' => 0,
								        								  'value' => @$form_data[$inputName],
								        								  'class' => 'form-control',
								        								  'tabindex' => '21',
								        								  'required' => 'required',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Facebook Reviews.');?>
															<label for="<?php echo $inputName;?>">Facebook Reviews<sup class="text-danger">*</sup></label>
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
							<!-- /Social Media Interactions -->

							<div class="row">
								<div class="col-lg-12 col-sm-12">
			            			<!-- Bootstrap Switch -->
			            			<div class="card card-secondary">
			              				<div class="card-body text-center">
											<input type="submit" class="btn btn-primary" value="<?php echo ((isset($form_data['location_form_data_id'])) ? 'Update' : 'Save' );?> Data" tabindex="22" />
											<input type="reset" class="btn btn-default" value="Reset Data" tabindex="23" />
			              				</div>
			            			</div>
			            		</div>
			            	</div>
						</fieldset>
						<?php echo form_close();?>
					</div>
				</div>
			</div>
