        <div class="row">
        	<div class="col-md-4">
        		<h3>Creating New Organization</h3>
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
        							<i class="fas fa-warehouse-alt fa-6x"></i>
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
        		<form method="post" action="<?= base_url('/appmgr/organizations/save_organization') ?>">
        			<input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
        			<input type="hidden" name="organization_id" value="0">
        			<div class="card">
        				<div class="card-header">
        					<h4 class="title">Create A New Organization</h4>
        				</div>
        				<div class="card-body">
        					<div class="row">
        						<div class="col-md-5 pr-md-1">
        							<div class="form-group">
        								<label>Organization Name</label>
        								<input type="text" class="form-control" value="" name="organization_name" required>
        							</div>
        						</div>
        					</div>
        				</div>
        				<div class="card-footer">
        					<button type="submit" class="btn btn-fill btn-primary">Save New Organization</button>
        				</div>
        			</div>
        		</form>
        	</div>

        </div>
