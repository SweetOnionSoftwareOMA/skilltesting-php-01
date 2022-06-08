	<!-- Main Sidebar Container -->
	<aside class="main-sidebar sidebar-light-primary elevation-1">
		<!-- Brand Logo -->
		<a href="<?php echo base_url();?>" class="brand-link" style="text-align: center; padding-top: 0.29rem;padding-bottom: 0.29rem;">
			<img src="<?php echo base_url();?>assets/img/mtm-logo.png" alt="<?php echo ucwords(str_replace('_', ' ', $this->config->item('app_name')));?>" class="" height="55">
		</a>

	    <!-- Sidebar -->
	    <div class="sidebar">
			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
					<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
					<li class="nav-item"><a href="<?php echo base_url();?>app/dashboard" class="nav-link<?php echo (($this->uri->segment(2) == 'dashboard') ? ' active' : '' );?>"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
					<li class="nav-item menu-open">
            			<a href="#" class="nav-link active"><i class="nav-icon fas fa-users"></i></i><p>Users<i class="fas fa-angle-left right"></i></p></a>
            			<ul class="nav nav-treeview">
              				<li class="nav-item"><a href="<?php echo base_url();?>office/manager/add" class="nav-link<?php echo (($this->uri->segment(3) == 'user_add') ? ' active' : '' );?>"><i class="fas fa-user-plus nav-icon"></i> <p>Add Office User</p></a></li>
              				<li class="nav-item"><a href="<?php echo base_url();?>office/manager" class="nav-link<?php echo (($this->uri->segment(3) == 'user_list') ? ' active' : '' );?>"><i class="fas fa-user nav-icon"></i> <p>View Office Users</p></a></li>
						</ul>
					</li>
				</ul>
			</nav>
	      <!-- /.sidebar-menu -->
		</div>
	    <!-- /.sidebar -->

	    <div class="sidebar-footer">
		    <div class="sidebar">
		    	<ul class="nav nav-pills nav-sidebar">
		    		<li class="nav-item"><a href="<?php echo base_url()?>" class="nav-link">HOME</a></li>
		    		<li class="nav-item"><a href="https://support.somediagroup.com" target="_blank" class="nav-link">HELP</a></li>
<?php if ($this->authuser->hasRole('Super Admin')) :?>
		    		<li class="nav-item"><a href="<?php echo base_url()?>admin/dashboard" class="nav-link">ADMIN</a></li>
<?php endif;?>
		    		<li class="nav-item"><a href="<?php echo base_url()?>app/dashboard" class="nav-link">STUFF</a></li>
		    	</ul>
		    </div>
			<div class="mini-footer text-center ml-0 p-3">
				Copyright &copy; <?php echo date('Y');?><br><a href="<?php echo base_url();?>"><?php echo ucwords(str_replace('_', ' ', $this->config->item('app_name')));?></a>.
			</div>
	   	</div>
	</aside>
