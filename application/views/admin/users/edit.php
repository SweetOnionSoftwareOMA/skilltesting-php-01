
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-sm-12">
<?php
						$attributes = array('method' => 'POST', 'id' => 'edit_user');
						$hidden = array('user_id' => $user->user_id);
						echo form_open(base_url().$formSubmitHandler, $attributes, $hidden);?>
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
													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'title';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => $user->title,
								        								  'class' => 'form-control',
								        								  'tabindex' => '1',
								        								  'maxlength' => '15');?>
															<label for="<?php echo $inputName;?>">Title</label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'first_name';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => $user->first_name,
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

													<div class="col-lg-4 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'last_name';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => $user->last_name,
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
								        								  'value' => $user->email,
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
																		  'id' => $inputName,
								        								  'value' => $user->username,
								        								  'class' => 'form-control',
								        								  'tabindex' => '5',
								        								  'minlength' => '4',
								        								  'maxlength' => '20',
								        								  'readonly' => 'readonly',
								        								  'pattern' => '[A-Za-z0-9\w]{4,20}',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Useranme.');?>
															<label for="<?php echo $inputName;?>">Username</label>
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
								        								  'value' => '',
								        								  'class' => 'form-control',
								        								  'tabindex' => '6',
								        								  'minlength' => '8',
								        								  'maxlength' => '25');?>
														<label for="<?php echo $inputName;?>">Password</label>
														<?php echo form_input($data);?>
														<span class="text-danger"><?php echo form_error($inputName);?></span>
													</div>

													<div class="col-lg-4 col-sm-12 sr-only">
														<div class="form-group">
<?php
															$inputName = 'company_name';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => $user->company_name,
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
								        								  'tabindex' => '7',
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
								        								  'tabindex' => '8',
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
								        								  'tabindex' => '9',
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
								        								  'tabindex' => '10',
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
												$required = ' required tabindex="11"';

												$office_id = array();
												foreach ($users_offices as $row) :
													$office_id[] = $row['office_id'];
												endforeach;

												foreach ($offices as $row) :?>
													<div class="col-md-4">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="<?php echo $row->office_id;?>" id="cbOffices<?php echo $row->office_id;?>" name="cbOffices[]"<?php echo $required;?><?php echo ((in_array($row->office_id, $office_id)) ? ' checked' : '' );?>>
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
												$required = ' required tabindex="12"';

												$role_id = array();
												foreach ($users_roles as $row) :
													$role_id[] = $row['role_id'];
												endforeach;

												foreach ($roles as $row) :?>
													<div class="col-md-4">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="<?php echo $row->role_id;?>" id="cbRoles<?php echo $row->role_id;?>" name="cbRoles[]"<?php echo $required;?><?php echo ((in_array($row->role_id, $role_id)) ? ' checked' : '' );?>>
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
											<input type="submit" class="btn btn-primary" value="Update User" tabindex="13" />
											<input type="reset" class="btn btn-default" value="Reset Data" tabindex="14" />
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
