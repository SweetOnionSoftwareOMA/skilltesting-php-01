	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box">
						<span class="info-box-icon bg-info elevation-1"><i class="fas fa-clinic-medical"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Offices</span>
							<span class="info-box-number"><a href="<?php echo base_url();?>admin/offices"><?php echo number_format($total_offices, 0);?></a></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Users</span>
							<span class="info-box-number"><a href="<?php echo base_url();?>admin/users"><?php echo number_format($total_users, 0);?></a></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

				<!-- fix for small devices only -->
				<div class="clearfix hidden-md-up"></div>
				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-tag"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Roles</span>
							<span class="info-box-number"><a href="<?php echo base_url();?>admin/roles"><?php echo number_format($total_roles, 0);?></a></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

				<div class="col-12 col-sm-6 col-md-3">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-warning elevation-1"><i class="fab fa-wpforms"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Forms</span>
							<span class="info-box-number"><a href="<?php echo base_url();?>admin/dashboard"><?php echo number_format($total_forms, 0);?></a></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
	</section>
	<!-- /.content -->
