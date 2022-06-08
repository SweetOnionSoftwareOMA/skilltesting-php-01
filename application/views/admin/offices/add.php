
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-sm-12">
<?php
						$attributes = array('method' => 'POST', 'id' => 'add_office');?>
						<?php echo form_open(base_url().$formSubmitHandler, $attributes);?>
						<fieldset>
							<!-- Form Information -->
							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Office Information</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
													<div class="col-lg-12 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'office_name';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '1',
								        								  'required' => 'required',
								        								  'maxlength' => '255',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Office Name.');?>
															<label for="<?php echo $inputName;?>">Office Name<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'office_color';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '2',
								        								  'required' => 'required',
								        								  'maxlength' => '7',
								        								  'placeholder' => '#FF00FF',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Office Color.');?>
															<label for="<?php echo $inputName;?>">Office Color<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
														</div>
													</div>
													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'notify_email_address';
															$data = array('type' => 'email',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '3',
								        								  'required' => 'required',
								        								  'maxlength' => '255',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Email Address.');?>
															<label for="<?php echo $inputName;?>">Email Address for Notifications<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
														</div>
													</div>
													<div class="col-lg-4 col-sm-12">
														<label for="notify_new_data">Notify for New Data</label>
														<div class="form-group">
															<select class="form-control" name="notify_new_data" id="notify_new_data" tabindex="4">
																<option selected="selected" value="1">Notify for New Data</option>
																<option value="0">Don't Notify for New Data</option>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-6 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'address1';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '5',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Address 1</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-6 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'address2';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '6',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Address 2</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-3 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'city';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '7',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">City</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-3 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'state';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '8',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">State</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-3 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'zip';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '9',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Zip Code</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-3 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'phone';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '10',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Phone #</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'app_url';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '11',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">APP URL</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'taxrate';
															$data = array('type' => 'number',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => 0,
								        								  'class' => 'form-control',
								        								  'tabindex' => '12',
								        								  'step' => '0.001',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Tax Rate</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'location_url';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '13',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Location URL</label>
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
							<!-- /Form Information -->

							<!-- Organization Association -->
							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Assign Organization</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
<?php
												$required = ' required tabindex="14"';
												foreach ($organizations as $row) :?>
													<div class="col-md-4">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="<?php echo $row->organization_id;?>" id="cbOrganizations<?php echo $row->organization_id;?>" name="cbOrganizations[]"<?php echo $required;?>>
															<label class="form-check-label" for="cbOrganizations<?php echo $row->organization_id;?>"><?php echo $row->organization_name;?></label>
														</div>
													</div>
<?php
												endforeach;?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Organization Association -->

							<!-- Users Association -->
							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Assign User</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
<?php
												$required = ' required tabindex="15"';
												foreach ($users as $row) :?>
													<div class="col-md-4">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="<?php echo $row->user_id;?>" id="cbUsers<?php echo $row->user_id;?>" name="cbUsers[]"<?php echo $required;?>>
															<label class="form-check-label" for="cbUsers<?php echo $row->user_id;?>"><?php echo trim($row->title.' '.$row->first_name.' '.$row->last_name);?></label>
														</div>
													</div>
<?php
												endforeach;?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Users Association -->

							<div class="row">
								<div class="col-lg-12 col-sm-12">
			            			<!-- Bootstrap Switch -->
			            			<div class="card card-secondary">
			              				<div class="card-body text-center">
											<input type="submit" class="btn btn-primary" value="Add Office" tabindex="16" />
											<input type="reset" class="btn btn-default" value="Reset Data" tabindex="17" />
			              				</div>
			            			</div>
			            		</div>
			            	</div>
						</fieldset>
						<?php echo form_close();?>

					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->
