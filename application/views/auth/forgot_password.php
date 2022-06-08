
<div class="login-box" style="width: 50%;">
	<div class="card" style="background-color: #e9ecef; box-shadow: none;">
		<div class="card-body p-0" style="margin: 0 auto; background: #fff; border: 5px solid #e9ecfe; border-radius: 15px; box-shadow: 0px 0px 3px #ccc; display: flex; padding: 0 !important; overflow: hidden;">
			<div class="row">
				<div class="col-md-6 pr-0 pl-0">
					<!-- /.login-logo -->
					<div class="card card-outline" style="border-radius: 0px; box-shadow: none;">
						<div class="card-header text-center">
							<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/img/logo.png" alt=""></a>
						</div>
						<div class="card-body">
							<h3 class="login-heading">Forgot Password?</h3>
							<form class="form" id="frmForgetPassword" method="post" action="<?php echo  site_url('auth/login/forgot_password/2');?>">
	                        <input type="hidden" name="action" value="user_login_form">
							<div class="input-group mb-4">
								<input type="email" name="email" id="email" class="form-control" placeholder="Email" value="" required>
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-envelope"></span>
									</div>
								</div>
							</div>
	                        <div class="form-group">        
	                            <div class="card-description">
	                                <p>If the supplied username matches, an email with reset instructions will be sent to you.</p>
	                                <p>Please check your SPAM/TRASH folders before attempting another reset.</p>
	                            </div>
	                        </div>
	                        <div class="form-group row">
	                            <div class="col-md-12">
	                                <a href="<?php echo site_url('login');?>" class="blue-txt-link no-padding">Remember Password?</a>
	                            </div>
	                        </div>
	                        <div class="form-group row">
	                            <div class="col-md-12">
	                                <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Request Reset</button>
	                            </div>
	                        </div>
	                    	</form>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!--end:col-md-6 -->
				<div class="col-md-6 pr-0 pl-0">
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
