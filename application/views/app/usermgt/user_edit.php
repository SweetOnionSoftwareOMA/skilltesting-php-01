        <div class="row">
        	<div class="col-md-4">
        		<h3>Personal Profile</h3>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-3">
        		<div class="card card-user">
        			<div class="card-body">
        				<p class="card-text">
        					<div class="author">
        						<div class="block block-one"></div>
        						<div class="block block-two"></div>
        						<div class="block block-three"></div>
        						<div class="block block-four"></div>
        						<a href="javascript:void(0)">
        							<i class="fa fa-user fa-6x"></i>
        							<h3 class="title"><?= $user->first_name ?> <?= $user->last_name ?></h3>
        						</a>
        						<h4 class="title"><?= $user->title ?></h4>
        						<p class="description">
        							<?= $user->email ?>
        						</p>
        					</div>
        				</p>
						<form method="post" action="<?= base_url('/appmgr/usermgt/update_password') ?>">

        				<div class="card-description"> 
							<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
							<input type="hidden" name="user_id" value='<?= $user->user_id ?>'>
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" id="username" name="username" placeholder="Username" class="form-control" value='<?= $user->username ?>'>
							</div>
							<div class="form-group">
								<label for="new_password">New Password</label>
								<input type="password" required id="new_password" name="new_password" class="form-control" value=''>
							</div>
							<div class="form-group">
								<label for="confirm_new_password">Confirm New Password</label>
								<input type="password" required id="confirm_new_password" name="confirm_new_password" class="form-control" value=''>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-fill btn-primary">Update Password</button>
							</div>
						</div>
        			</div>
						
					</form>

        		</div>
        	</div>
        	<div class="col-md-8">
        		<form method="post" action="<?= base_url('/appmgr/usermgt/update') ?>">
        			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
        			<input type="hidden" name="user_id" value='<?= $user->user_id ?>'>
        			<div class="card">
        				<div class="card-header">
        					<h4 class="title">Edit Profile</h4>
        				</div>
        				<div class="card-body">
        					<div class="row">
        						<div class="col-md-5 pr-md-1">
        							<div class="form-group">
        								<label>Company</label>
        								<input type="text" class="form-control" value="<?= $user->company_name ?>" name="company_name">
        							</div>
        						</div>
        						<div class="col-md-4 pl-md-1">
        							<div class="form-group">
        								<label>Title</label>
        								<input type="text" class="form-control" value="<?= $user->title ?>" name="title">
        							</div>
        						</div>
        					</div>
        					<div class="row">
        						<div class="col-md-6 pr-md-1">
        							<div class="form-group">
        								<label>First Name</label>
        								<input type="text" class="form-control" value='<?= $user->first_name ?>' required name="first_name">
        							</div>
        						</div>
        						<div class="col-md-6 pl-md-1">
        							<div class="form-group">
        								<label>Last Name</label>
        								<input type="text" class="form-control" value='<?= $user->last_name ?>' required name="last_name">
        							</div>
        						</div>
        					</div>
        					<div class="row">
        						<div class="col-md-12">
        							<div class="form-group">
        								<label>Address</label>
        								<input type="text" class="form-control" placeholder="Home Address" value='<?= $user->address ?>' name="address">
        							</div>
        						</div>
        					</div>
        					<div class="row">
        						<div class="col-md-3 pr-md-1">
        							<div class="form-group">
        								<label>City</label>
        								<input type="text" class="form-control" value='<?= $user->city ?>' name="city">
        							</div>
        						</div>
        						<div class="offset-md-1 col-md-4 pr-md-1">
        							<div class="form-group">
        								<label>State</label>
        								<select name="state" id="state" class="form-control selectpicker">
        									<?php foreach ($states as $abbr => $name) : ?>
												<?php $selected = ($abbr == $user->state) ? 'selected' : null;?>
												<option value='<?=$abbr?>' <?=$selected?> > <?=$name?> </option>
        									<?php endforeach; ?>
        								</select>
        							</div>
        						</div>
        						<div class="col-md-3 offset-md-1 pl-md-1">
        							<div class="form-group">
        								<label>Postal Code</label>
        								<input type="number" class="form-control" placeholder="ZIP Code" value='<?= $user->zip ?>' name="zip">
        							</div>
        						</div>
        					</div>
        					<div class="row">
        						<div class="col-md-5">
        							<div class="form-group">
        								<label>Email</label>
        								<input type="email" class="form-control" placeholder="Email" value='<?= $user->email ?>' name="email" id="email">
        							</div>
        						</div>
        					</div>
        				</div>
        				<div class="card-footer">
        					<button type="submit" class="btn btn-fill btn-primary">Update Profile</button>
        				</div>
        			</div>
        		</form>
        	</div>

        </div>
