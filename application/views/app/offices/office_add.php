<div class="row">
	<div class="col-md-4">
		<h3>Creating New Office Location</h3>
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
							<i class="fad fa-clinic-medical fa-6x"></i>
							<h3 class="title">New Office</h3>
						</a>
					</div>
				</p>
				<div class="card-description">
				</div>
			</div>
			<div class="card-footer">
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<form method="post" action="<?= base_url('/appmgr/offices/save_office') ?>">
			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
			<input type="hidden" name="office_id" value='0'>
			<input type="hidden" name="old_org_id" value='0'>
			<div class="card">
				<div class="card-header">
					<h4 class="title">Create A New Office</h4>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<div class="form-group">
									<label>Belongs to Organization:</label>
									<select name="organization_id" id="organization_id" class="selectpicker " data-style="select-with-transition" data-live-search="true" title="Select Organization" data-size="7" required>
										<?php foreach ($orgs as $id => $name) : ?>
											<option value='<?= $id ?>'> <?= $name ?> </option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Office Name</label>
								<input type="text" class="form-control" name="office_name" required>
							</div>
						</div>
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Tax Rate</label>
								<input type="number" class="form-control" name="taxrate" required min='0' max='99.9' step='any'>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Address</label>
								<input type="text" class="form-control" name="address1" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 pr-md-1">
							<div class="form-group">
								<label>Additional Address</label>
								<input type="text" class="form-control" name="address2">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 pr-md-1">
							<div class="form-group">
								<label>City</label>
								<input type="text" class="form-control" name="city" required>
							</div>
						</div>
						<div class="offset-md-1 col-md-4 pr-md-1">
							<div class="form-group">
								<label>State</label>
								<select name="state" id="state" class="selectpicker " data-style="select-with-transition" title="Select State" data-live-search="true" data-size="7" required>
									<?php foreach ($states as $abbr => $name) : ?>
										<option value='<?= $abbr ?>'> <?= $name ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-3 pr-md-1">
							<div class="form-group">
								<label>Zip</label>
								<input type="text" class="form-control" name="zip" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 pr-md-1">
							<div class="form-group">
								<label>Phone</label>
								<input type="tel" class="form-control" name="phone" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 pr-md-1">
							<div class="form-group">
								<label>Application URL</label>
								<input type="url" class="form-control" name="app_url" default="http(s)://www.site.com">
							</div>
						</div>
						<div class="col-md-6 pr-md-1">
							<div class="form-group">
								<label>location URL</label>
								<input type="url" class="form-control" name="location_url" default="http(s)://www.site.com">
							</div>
						</div>

					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-fill btn-primary">Create Office</button>
				</div>
			</div>
		</form>
	</div>
</div>
