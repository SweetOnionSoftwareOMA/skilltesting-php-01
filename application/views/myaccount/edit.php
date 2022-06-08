
				<!-- Left section -->
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-4">
							<div class="card card-user"><?php /* ?>
								<div class="card-body">
									<p class="card-text">
										<div class="author text-center">
											<div class="block block-one"></div>
											<div class="block block-two"></div>
											<div class="block block-three"></div>
											<div class="block block-four"></div>
											<a href="javascript:void(0)">
												<i class="fa fa-user fa-6x"></i>
												<h3 class="title"><?= $user->title ?> <?= $user->first_name ?> <?= $user->last_name ?></h3>
											</a>
											<p class="description"><?= $user->email ?></p>
										</div>
									</p>
									<div class="card-description"></div>
								</div><?php */?>
								<div class="card-footer">
									<form action="<?= base_url('myaccount/profile/changepassword') ?>" method="post" id='FRM_passwordReset'>
										<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
										<input type="hidden" name="user_id" value='<?= $user->user_id ?>'>
										<div class="row">
											<div class="col-md-12 pr-md-1">
												<div class="form-group">
													<label for="pass1">Change Password<br><br></label>
													<input type="password" class="form-control" value="" name="pass1" id="pass1" required placeholder="New Password" autocomplete="false">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 pr-md-1">
												<div class="form-group">
													<input type="password" class="form-control" value="" name="pass2" id="pass2" required placeholder="Retype New Password"  autocomplete="false">
													<div class="text-right"><a href="#" id="toggleHidden" class="link footer-link">Show Password</a></div>
												</div>
											</div>
										</div>
										<button type="submit" class="btn btn-block btn-primary">Update Password</button>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<form method="post" action="<?= base_url('/myaccount/profile/update') ?>">
								<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
								<input type="hidden" name="user_id" value='<?= $user->user_id ?>'>
								<div class="card">
									<div class="card-header">
										<h4 class="title">Edit Profile</h4>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-2 pl-md-1">
												<div class="form-group">
													<label for="title">Title</label>
													<input type="text" class="form-control" value="<?= $user->title ?>" name="title" id="title">
												</div>
											</div>
											<div class="col-md-5 pr-md-1">
												<div class="form-group">
													<label for="first_name">First Name</label>
													<input type="text" class="form-control" value='<?= $user->first_name ?>' required name="first_name" id="first_name">
												</div>
											</div>
											<div class="col-md-5 pl-md-1">
												<div class="form-group">
													<label for="last_name">Last Name</label>
													<input type="text" class="form-control" value='<?= $user->last_name ?>' required name="last_name" id="last_name">
												</div>
											</div>
										</div>
										<div class="row sr-only">
											<div class="col-md-12 pr-md-1">
												<div class="form-group">
													<label for="company_name">Company</label>
													<input type="text" class="form-control" value="<?= $user->company_name ?>" name="company_name" id="company_name">
												</div>
											</div>
										</div>
										<div class="row sr-only">
											<div class="col-md-12">
												<div class="form-group">
													<label for="address">Address</label>
													<input type="text" class="form-control" placeholder="Home Address" value='<?= $user->address ?>' name="address" id="address">
												</div>
											</div>
										</div>
										<div class="row sr-only">
											<div class="col-md-4 pr-md-1">
												<div class="form-group">
													<label for="city">City</label>
													<input type="text" class="form-control" value='<?= $user->city ?>' name="city" id="city">
												</div>
											</div>
											<div class="col-md-4 pr-md-1">
												<div class="form-group">
													<label for="state">State</label>
													<select name="state" id="state" class="form-control selectpicker">
														<?php foreach ($states as $abbr => $name) : ?>
															<?php $selected = ($abbr == $user->state) ? 'selected' : null; ?>
															<option value='<?= $abbr ?>' <?=  $selected ?> > <?= $name ?> </option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="col-md-4 pl-md-1">
												<div class="form-group">
													<label for="zip">Postal Code</label>
													<input type="number" class="form-control" placeholder="ZIP Code" value='<?= $user->zip ?>' name="zip" id="zip">
												</div>
											</div>
										</div>
										<div class="row sr-only">
											<div class="col-md-12">
												<div class="form-group">
													<label for="question1">Security Question 1</label>
													<select name="question1" id="question1" class='form-control selectpicker' data-style="select-with-transition" data-live-search="true">
														<?php foreach ($this->authuser->getChallengeQuestions() as $id => $name) : ?>
															<?php if ($id != 0) : ?>
																<?php $selected = ($id == $user->question1) ? 'selected' : null; ?>
																<option value='<?= $id ?>' <?= $selected ?>> <?= $name ?> </option>
															<?php endif; ?>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>
										<div class="row sr-only">
											<div class="col-md-12">
												<div class="form-group">
													<input type="text" class="form-control" value='<?php if ($user->question1 != 0) {
																										echo $user->question1_answer;
																									} ?>' name="question1_answer">
												</div>
											</div>
										</div>
										<div class="row sr-only">
											<div class="col-md-12">
												<div class="form-group">
													<label for="question2">Security Question 2</label>
													<select name="question2" id="question2" class='form-control selectpicker' data-style="select-with-transition" data-live-search="true">
														<?php foreach ($this->authuser->getChallengeQuestions() as $id => $name) : ?>
															<?php if ($id != 0) : ?>
																<?php $selected = ($id == $user->question1) ? 'selected' : null; ?>
																<option value='<?= $id ?>' <?= $selected ?>> <?= $name ?> </option>
															<?php endif; ?>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>
										<div class="row sr-only">
											<div class="col-md-12">
												<div class="form-group">
													<input type="text" class="form-control" value='<?php if ($user->question1 != 0) {
																										echo $user->question2_answer;
																									} ?>' name="question2_answer">
												</div>
											</div>
										</div>

									</div>
									<div class="card-footer text-right">
										<button type="submit" class="btn btn-fill btn-primary">Update Profile</button>
										<a href="<?php echo base_url();?>app/dashboard" class="btn btn-fill btn-default">Cancel</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
