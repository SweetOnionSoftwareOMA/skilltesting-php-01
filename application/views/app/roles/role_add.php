        <div class="row">
        	<div class="col-md-4">
        		<h3>Creating New Role</h3>
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
        							<i class="fad fa-users-crown fa-6x"></i>
        						</a>
        					</div>
        				</p>
        				<div class="card-description"></div>
        			</div>
        			<div class="card-footer">
        			</div>
        		</div>
        	</div>
        	<div class="col-md-8">
        		<form method="post" action="<?= base_url('/appmgr/roles/save_role') ?>">
					<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
					<input type="hidden" name="role_id" value="0">
        			<div class="card">
        				<div class="card-header">
        					<h4 class="title">Create A New Role</h4>
        				</div>
        				<div class="card-body">
        					<div class="row">
        						<div class="col-md-5 pr-md-1">
        							<div class="form-group">
        								<label>Role Name</label>
        								<input type="text" class="form-control" value="" name="role_name">
        							</div>
        						</div>
        					</div>
        					<div class="row">
        						<div class="col-md-5 pr-md-1">
        							<div class="form-group">
        								<label>Description</label>
        								<textarea name="description" id="description" cols="70" rows="4" class="form-control"></textarea>
        							</div>
        						</div>
        					</div>
        				</div>
        				<div class="card-footer">
        					<button type="submit" class="btn btn-fill btn-primary">Save New Role</button>
        				</div>
        			</div>
        		</form>
        	</div>

        </div>
