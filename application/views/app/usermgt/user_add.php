        <div class="row">
        	<div class="col-md-4">
        		<h3>Create a New User</h3>
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
        							<i class="fa fa-user fa-6x text-white"></i>
        							<h3 class="title"></h3>
        						</a>
        						<h4 class="title"></h4>
        						<p class="description"></p>
        					</div>
        				</p>
        				<div class="card-description"></div>
        			</div>
        			<div class="card-footer">
        			</div>
        		</div>
        	</div>
        	<div class="col-md-8">
        		<form method="post" action="<?= base_url('/appmgr/usermgt/update') ?>">
        			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
					<input type="hidden" name="user_id" value='0'>
					<input type="hidden" name="password" value='password'>
        			<div class="card">
        				<div class="card-header">
        					<h4 class="title">Edit Profile</h4>
        				</div>
        				<div class="card-body">
        					<div class="row">
        						<div class="col-md-6 pr-md-1">
        							<div class="form-group">
        								<label>Email</label>
        								<input type="email" class="form-control" value="" name="email" id="email">
        							</div>
								</div>
								<div class="col-md-6 pl-md-1">
									<div class="form-group">
        								<label>Username</label>
        								<input type="text" class="form-control" value="" name="username" id="username">
        							</div>
								</div>
							</div>
        						<div class="row">
        							<div class="col-md-5 pr-md-1">
        								<div class="form-group">
        									<label>Company</label>
        									<input type="text" class="form-control" value="" name="company_name">
        								</div>
        							</div>
        							<div class="col-md-4 pl-md-1">
        								<div class="form-group">
        									<label>Title</label>
        									<input type="text" class="form-control" value="" name="title">
        								</div>
        							</div>
        						</div>
        						<div class="row">
        							<div class="col-md-6 pr-md-1">
        								<div class="form-group">
        									<label>First Name</label>
        									<input type="text" class="form-control" value='' required name="first_name">
        								</div>
        							</div>
        							<div class="col-md-6 pl-md-1">
        								<div class="form-group">
        									<label>Last Name</label>
        									<input type="text" class="form-control" value='' required name="last_name">
        								</div>
        							</div>
        						</div>
        						<div class="row">
        							<div class="col-md-12">
        								<div class="form-group">
        									<label>Address</label>
        									<input type="text" class="form-control" placeholder="Home Address" value='' name="address">
        								</div>
        							</div>
        						</div>
        						<div class="row">
        							<div class="col-md-3 pr-md-1">
        								<div class="form-group">
        									<label>City</label>
        									<input type="text" class="form-control" value='' name="city">
        								</div>
        							</div>
        							<div class="offset-md-1 col-md-4 pr-md-1">
        								<div class="form-group">
        									<label>State</label>
        									<select name="state" id="state" class="selectpicker " data-style="select-with-transition" data-live-search="true" title="Select State" data-size="7">
        										<?php foreach ($states as $abbr => $name) : ?>
        											<option value='<?= $abbr ?>'> <?= $name ?> </option>
        										<?php endforeach; ?>
        									</select>
        								</div>
        							</div>
        							<div class="col-md-3 offset-md-1 pl-md-1">
        								<div class="form-group">
        									<label>Postal Code</label>
        									<input type="number" class="form-control" placeholder="ZIP Code" value='' name="zip">
        								</div>
        							</div>
        						</div>

        					</div>
        					<div class="card-footer">
        						<button type="submit" class="btn btn-fill btn-primary">Save New User</button>
        					</div>
        				</div>
        		</form>
        	</div>

        </div>
