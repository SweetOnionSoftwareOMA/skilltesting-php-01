
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-sm-12">
<?php
						$attributes = array('method' => 'POST', 'id' => 'add_role');?>
						<?php echo form_open(base_url().$formSubmitHandler, $attributes);?>
						<fieldset>
							<!-- Form Information -->
							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Role Information</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
													<div class="col-lg-12 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'role_name';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '1',
								        								  'required' => 'required',
								        								  'maxlength' => '255',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Role Name.');?>
															<label for="<?php echo $inputName;?>">Role Name<sup class="text-danger">*</sup></label>
															<?php echo form_input($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-12 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'description';
															$data = array('type' => 'text',
																		  'name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => set_value($inputName),
								        								  'class' => 'form-control',
								        								  'tabindex' => '2',
								        								  'required' => 'required',
								        								  'maxlength' => '255',
								        								  'rows' => '3',
								        								  'data-rule-required' => 'true',
								        								  'data-msg-required'  => 'Please enter Role Description.');?>
															<label for="<?php echo $inputName;?>">Role Description<sup class="text-danger">*</sup></label>
															<?php echo form_textarea($data);?>
															<span class="text-danger"><?php echo form_error($inputName);?></span>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-6 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'super_admin';
															$data = array('name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => '1',
								        								  'class' => 'custom-control-input',
								        								  'tabindex' => '4');?>
															<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
																<?php echo form_checkbox($data);?>
																<label class="custom-control-label" for="<?php echo $inputName;?>"> Super Admin</label>
															</div>
														</div>
													</div>

													<div class="col-lg-6 col-sm-12">
														<div class="form-group">
<?php
															$inputName = 'office_manager_can_assign';
															$data = array('name' => $inputName,
																		  'id' => $inputName,
								        								  'value' => '1',
								        								  'class' => 'custom-control-input',
								        								  'tabindex' => '5');?>
															<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
																<?php echo form_checkbox($data);?>
																<label class="custom-control-label" for="<?php echo $inputName;?>"> Manager Can Delegate</label>
															</div>
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

							<!-- Permissions Association -->
							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Assign Permissions</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
<?php
												$required = ' required tabindex="6"';
												foreach ($permissions as $row) :?>
													<div class="col-md-4">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="<?php echo $row->permission_id;?>" id="cbPermissions<?php echo $row->permission_id;?>" name="cbPermissions[]"<?php echo $required;?>>
															<label class="form-check-label" for="cbPermissions<?php echo $row->permission_id;?>"><?php echo $row->permission_name;?></label>
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
							<!-- /Permissions Association -->

							<!-- Users Association -->
							<div class="row">
								<div class="col-lg-12">
						            <div class="card card-primary card-outline">
						            	<div class="card-header">
						                	<h3 class="card-title">Assign Users</h3>
						              	</div>
										<!-- /.card-header -->
										<div class="card-body">
											<div class="container">
												<div class="row">
<?php
												$required = ' required tabindex="7"';
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
			            			<div class="card card-secondary">
			              				<div class="card-body text-center">
											<input type="submit" class="btn btn-primary" value="Add Role" tabindex="8" />
											<input type="reset" class="btn btn-default" value="Reset Data" tabindex="9" />
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
