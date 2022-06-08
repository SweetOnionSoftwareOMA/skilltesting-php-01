
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<table id="view-users" class="table table-bordered table-hover">
							<thead>
							<tr>
<?php
								foreach ($dataTable['headings'] as $column) {?>
								<th nowrap="nowrap"><?php echo $column;?></th>
<?php
								}?>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->

			<!-- #user-modal -->
			<div class="modal fade" data-toggle="modal" data-backdrop="static" data-keyboard="false" id="user-modal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-body">
							<h4 class="modal-title">User Information</h4>
							<ul class="list-group list-group-unbordered mb-3">
								<li class="list-group-item">
									<strong>Name</strong> <span class="float-right" id="name"></span>
								</li>
								<li class="list-group-item">
									<strong>Email</strong> <span class="float-right" id="email"></span>
								</li>
								<li class="list-group-item">
									<strong>Username</strong> <span class="float-right" id="username"></span>
								</li>
							</ul>
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<h4 class="modal-title">User Offices</h4>
									<ul class="list-group list-group-unbordered mb-3" id="offices">
									</ul>
								</div>
								<div class="col-md-6 col-sm-12">
									<h4 class="modal-title">User Roles</h4>
									<ul class="list-group list-group-unbordered mb-3" id="roles">
									</ul>
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /#user-modal -->
