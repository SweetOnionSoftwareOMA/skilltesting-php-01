<div class="login-box" style="width: auto;">
	<div class="card" style="background-color: #e9ecef; box-shadow: none;">
		<div class="card-body p-0" style="margin: 0 auto; background: #fff; border: 5px solid #e9ecfe; border-radius: 15px; box-shadow: 0px 0px 3px #ccc; display: flex; padding: 0 !important; overflow: hidden;">
			<div class="row">
				<div class="col-md-6 pr-0 pl-0">
					<!-- /.login-logo -->
					<div class="card card-outline" style="border-radius: 0px; box-shadow: none;">
						<div class="card-header text-center pb-0">
							<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/img/mtm-logo.png" alt="" width="250"></a>
						</div>
						<div class="card-body">
<?php
							$message = $this->session->flashdata('message');
                			if($message) {?>
                    		<div class="alert alert-danger"><?php echo $message;?></div>
<?php
                			}?>
							<h3 class="login-heading">Timed Out.</h3>
		        			<div class="alert alert-danger pl-1 pr-1 text-center">Your session is ended, login to continue.</div>
							<form class="form" id="frmLogin" method="post" action="<?php echo site_url('auth/login/authenticate');?>">
							<div class="input-group mb-4">
																<input type="text" name="username" id="username" minlength="4" maxlength="20" pattern="[A-Za-z0-9\w]{4,20}" class="form-control" placeholder="Username" value="<?php echo ((ENVIRONMENT == 'development') ? 'admin' : '' ) ?>" required>
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-user"></span>
									</div>
								</div>
							</div>
							<div class="input-group mb-4">
								<input type="password" name="password" id="password" placeholder="Password" class="form-control" value="<?php echo ((ENVIRONMENT == 'development') ? 'password' : '' ) ?>" required>
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-lock"></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6 mb-4">
									<div class="icheck-primary">
										<input type="checkbox" name="remember" id="remember">
										<label for="remember">Remember Me</label>
									</div>
								</div>
								<!-- /.col -->
								<div class="col-6">
									<button type="submit" class="btn btn-primary btn-block">Login</button>
								</div>
								<!-- /.col -->
							</div>
							</form>
							<!-- /.social-auth-links -->
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!--end:col-md-6 -->
				<div class="col-md-6 pr-0 pl-0 d-none d-xl-block">
					<img class="img-full" src="<?php echo base_url();?>assets/img/login-right.png" style="width: 100%; height: 100%; object-fit: cover;">
				</div>
				<!--end:col-md-6 -->
			</div>
			<!--end:row -->
		</div>
		<!--end:card-body -->
	</div>
	<!--end:card -->
</div>
<!-- /.login-box -->

