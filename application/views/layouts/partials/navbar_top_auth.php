	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand<?php echo (($this->uri->segment('1') == 'admin') ? ' navbar-dark navbar-dark' : ' navbar-white navbar-light' );?>">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		  	</li>
		  	<li class="nav-item d-none d-sm-inline-block">
				<div class="punch-line-tag">Simple.Modern.<span>Eye care</span></div>
		  	</li>
		  	<li class="nav-item d-none d-sm-inline-block">
				<div class="org-tg-inbfo">
					<span class="org-name"><?php echo ((sizeof($this->session->userdata('user_organizations'))) ? implode(', ',$this->	session->userdata('user_organizations')) : '&nbsp;' );?></span>
					<span class="ofc-name">
<?php
						if (sizeof($this->session->userdata('user_offices'))) {
							$user_offices = '';

							foreach($this->session->userdata('user_offices') as $key => $value) {
								$user_offices .= (($user_offices) ? ', ' : '' ).$value['name'];
							}
							echo substr($user_offices, 0, 50).((strlen($user_offices) > 50) ? '&hellip;' : '' );
						}?>
					</span>
				</div>
		  	</li>
		</ul>

		<!-- Right navbar links -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item asdfasfdasdf">
				<a class="nav-link" data-widget="fullscreen" href="#" role="button">
			  		<i class="fas fa-expand-arrows-alt"></i>
				</a>
		  	</li>
			<!-- User Account: style can be found in dropdown.less -->
			<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#">
				  	<i class="far fa-user"></i>
				</a>
				<ul class="dropdown-menu pt-2 pb-2 pl-5 pr-5">
					<!-- User image -->
					<li class="user-header text-center">
						<p style="margin-top:1rem; width:150px;"><?php echo $this->session->userdata('name');?></p>
					</li>
					<li class="user-footer">
						<div class="text-center">
							<a href="<?php echo base_url();?>my-profile" class="btn btn-primary btn-block">My Profile</a>
							<a href="<?php echo base_url();?>logout" class="btn btn-default btn-block">Sign out</a>
						</div>
					</li>
				</ul>
			</li>
			<!-- Control Sidebar Toggle Button -->
		</ul>
	</nav>
	<!-- /.navbar -->
