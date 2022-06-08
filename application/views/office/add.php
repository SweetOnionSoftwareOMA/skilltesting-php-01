
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-sm-12">
<?php
			$attributes = array('method' => 'POST', 'id' => 'add_office_user');
			$hidden = array('user_organizations' => implode(',', array_keys($user_organizations)));
			echo form_open(base_url().$formSubmitHandler, $attributes, $hidden);?>
			<fieldset>
				<!-- User Information -->
				<div class="row">
					<div class="offset-lg-2 col-lg-8">
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">User Information</h3>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'title';
												$data = array('type' => 'text',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => set_value($inputName),
					        								  'class' => 'form-control',
					        								  'tabindex' => '1',
					        								  'maxlength' => '50',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Title.');?>
												<label for="<?php echo $inputName;?>">Title</label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'first_name';
												$data = array('type' => 'text',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => set_value($inputName),
					        								  'class' => 'form-control',
					        								  'tabindex' => '1',
					        								  'required' => 'required',
					        								  'maxlength' => '150',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter First Name.');?>
												<label for="<?php echo $inputName;?>">First Name<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'last_name';
												$data = array('type' => 'text',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => set_value($inputName),
					        								  'class' => 'form-control',
					        								  'tabindex' => '1',
					        								  'required' => 'required',
					        								  'maxlength' => '150',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Last Name.');?>
												<label for="<?php echo $inputName;?>">Last Name<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'username';
												$data = array('type' => 'text',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => set_value($inputName),
					        								  'class' => 'form-control',
					        								  'tabindex' => '4',
					        								  'required' => 'required',
					        								  'minlength' => '4',
					        								  'maxlength' => '20',
					        								  'pattern' => '[A-Za-z0-9\w]{4,20}',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter a valid Username.');?>
												<label for="<?php echo $inputName;?>">Username<sup class="text-danger">*</sup></label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'email';
												$data = array('type' => 'email',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => set_value($inputName),
					        								  'class' => 'form-control',
					        								  'tabindex' => '5',
					        								  'maxlength' => '200');?>
												<label for="<?php echo $inputName;?>">Email</label>
												<?php echo form_input($data);?>
												<span class="text-danger"><?php echo form_error($inputName);?></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="form-group">
<?php
												$inputName = 'password';
												$data = array('type' => 'text',
															  'name' => $inputName,
															  'id' => $inputName,
					        								  'value' => set_value($inputName),
					        								  'class' => 'form-control password',
					        								  'tabindex' => '6',
					        								  'required' => 'required',
					        								  'maxlength' => '100',
					        								  'data-rule-required' => 'true',
					        								  'data-msg-required'  => 'Please enter Password.');?>
												<label for="<?php echo $inputName;?>">Password<sup class="text-danger">*</sup></label>
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
				<!-- /User Information -->

				<!-- Accessible Offices -->
				<div class="row">
					<div class="offset-lg-2 col-lg-8">
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">Accessible Offices</h3>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="container">
									<div class="row">
<?php
									$required = ' required tabindex="7"';
									foreach ($user_offices as $key => $value) :?>
										<div class="col-md-4">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value="<?php echo $key;?>" id="cbOffices<?php echo $key;?>" name="cbOffices[]"<?php echo $required;?>>
												<label class="form-check-label" for="cbOffices<?php echo $key;?>"><?php echo $value['name'];?></label>
											</div>
										</div>
<?php
										$required = '';
									endforeach;?>
									</div>
								</div>
			              	</div>
			              	<!-- /.card-body -->
			            </div>
			            <!--/.card -->
					</div>
				</div>
				<!-- Accessible Offices -->

				<!-- User Roles -->
				<div class="row">
					<div class="offset-lg-2 col-lg-8">
			            <div class="card card-primary card-outline">
			            	<div class="card-header">
			                	<h3 class="card-title">User Roles</h3>
			              	</div>
							<!-- /.card-header -->
							<div class="card-body">
								<div class="container">
									<div class="row">
<?php
									$required = ' required tabindex="8"';
									foreach ($user_roles->result() as $row) :
										if ($this->authuser->hasRole($row->role_name)) :?>
										<div class="col-md-4">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value="<?php echo $row->role_id;?>" id="cbRoles<?php echo $row->role_id;?>" name="cbRoles[]"<?php echo $required;?>>
												<label class="form-check-label" for="cbRoles<?php echo $row->role_id;?>"><?php echo $row->role_name;?></label>
											</div>
										</div>
<?php
										$required = '';
										endif;
									endforeach;?>
									</div>
								</div>
			              	</div>
			              	<!-- /.card-body -->
			            </div>
			            <!--/.card -->
					</div>
				</div>
				<!-- User Roles -->

				<div class="row">
					<div class="col-lg-12 col-sm-12">
            			<!-- Bootstrap Switch -->
            			<div class="card card-secondary">
              				<div class="card-body text-center">
								<input type="submit" class="btn btn-primary" value="Add User" tabindex="9" />
								<input type="reset" class="btn btn-default" value="Reset Data" tabindex="10" />
              				</div>
            			</div>
            		</div>
            	</div>
			</fieldset>
			<?php echo form_close();?>
		</div>
	</div>
</div>
