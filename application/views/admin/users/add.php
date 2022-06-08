
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-sm-12">
<?php
						$attributes = array('method' => 'POST', 'id' => 'add_user');?>
						<?php echo form_open(base_url().$formSubmitHandler, $attributes);?>
						<fieldset>
							<!-- Form Information -->
							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">User Information</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
													<div class="col-lg-2 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'title';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '1',
								        								  'maxlength' => '15');?>
															<label for="<?php echo $inputName;?>">Title</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-5 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'first_name';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '2',
								        								  'required' => 'required',
								        								  'maxlength' => '255',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter First Name.');?>
															<label for="<?php echo $inputName;?>">First Name<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-5 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'last_name';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '3',
								        								  'required' => 'required',
								        								  'maxlength' => '255',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Last Name.');?>
															<label for="<?php echo $inputName;?>">Last Name<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'email';
															$data = array('type' => 'email',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '4',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Email</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'username';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '5',
								        								  'required' => 'required',
								        								  'minlength' => '4',
								        								  'maxlength' => '20',
								        								  'pattern' => '[A-Za-z0-9\w]{4,20}',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Useranme.');?>
															<label for="<?php echo $inputName;?>">Username<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
<?php
															$inputName = 'password';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => random_password(),
								        								  'class' => 'form-control',
								        								  'tabindex' => '6',
								        								  'required' => 'required',
								        								  'readonly' => 'readonly',
								        								  'minlength' => '8',
								        								  'maxlength' => '255',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Password.');?>
														<label for="<?php echo $inputName;?>">Password<sup class="text-danger">*</sup></label>
														<div class="input-group">
															<?php echo form_input($data);?>
															<div class="input-group-prepend">
																<span class="input-group-text"><a href="#" onclick="copyToClipBoard();"><i class="far fa-copy"></i></a></span>
															</div>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12 sr-only">
														<div class="form-group">
<?php
															$inputName = 'company_name';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '7',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Company Name</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>
												</div>

												<div class="row sr-only">
													<div class="col-lg-3 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'address';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '8',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Address</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-3 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'city';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '9',
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
								        								  'tabindex' => '10',
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
								        								  'tabindex' => '11',
								        								  'maxlength' => '255');?>
															<label for="<?php echo $inputName;?>">Zip Code</label>
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

							<!-- Offices Association -->
							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Assign Offices</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
<?php
												$required = ' required tabindex="12"';
												foreach ($offices as $row) :?>
													<div class="col-md-4">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="<?php echo $row->office_id;?>" id="cbOffices<?php echo $row->office_id;?>" name="cbOffices[]"<?php echo $required;?>>
															<label class="form-check-label" for="cbOffices<?php echo $row->office_id;?>"><?php echo $row->office_name;?></label>
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
							<!-- /Offices Association -->

							<!-- Roles Association -->
							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Assign Roles</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
<?php
												$required = ' required tabindex="13"';
												foreach ($roles as $row) :?>
													<div class="col-md-4">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="<?php echo $row->role_id;?>" id="cbRoles<?php echo $row->role_id;?>" name="cbRoles[]"<?php echo $required;?><?php echo (($row->role_id == 2) ? ' checked="checked"' : '' );?>>
															<label class="form-check-label" for="cbRoles<?php echo $row->role_id;?>"><?php echo $row->role_name;?></label>
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
							<!-- /Roles Association -->

							<div class="row">
								<div class="col-lg-12 col-sm-12">
			            			<!-- Bootstrap Switch -->
			            			<div class="card card-secondary">
			              				<div class="card-body text-center">
											<input type="submit" class="btn btn-primary" value="Add User" tabindex="14" />
											<input type="reset" class="btn btn-default" value="Reset Data" tabindex="15" />
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
