	<!-- Main Sidebar Container -->
	<aside class="main-sidebar sidebar-dark-primary elevation-1">
		<!-- Brand Logo -->
		<a href="<?php echo base_url();?>" class="brand-link" style="text-align: center; padding-top: 0.29rem;padding-bottom: 0.29rem;">
			<img src="<?php echo base_url();?>assets/img/mtm-logo-dark.png" alt="<?php echo ucwords(str_replace('_', ' ', $this->config->item('app_name')));?>" class="" height="55">
		</a>

	    <!-- Sidebar -->
	    <div class="sidebar">
			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-item"><a href="<?php echo base_url();?>admin/dashboard" class="nav-link<?php echo (($this->uri->segment(2) == 'dashboard') ? ' active' : '' );?>"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
					<li class="nav-item<?php echo ((in_array($this->uri->segment(2), array('offices'))) ? ' menu-open' : '' );?>">
						<a href="#" class="nav-link<?php echo (($this->uri->segment(2) == 'offices') ? ' active' : '' );?>"><i class="nav-icon fas fa-clinic-medical"></i><p>Offices<i class="right fas fa-angle-left"></i></p></a>
            			<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url();?>admin/offices/add" class="nav-link<?php echo (($this->uri->segment(2) == 'offices' && $this->uri->segment(3) == 'add') ? ' active' : '' );?>"><i class="fas fa-plus nav-icon"></i><p>Add Office</p></a></li>
							<li class="nav-item"><a href="<?php echo base_url();?>admin/offices" class="nav-link<?php echo (($this->uri->segment(2) == 'offices' && $this->uri->segment(3) == '') ? ' active' : '' );?>"><i class="fas fa-th-list nav-icon"></i><p>View Offices</p></a></li>
            			</ul>
          			</li>
          			<li class="nav-item<?php echo ((in_array($this->uri->segment(2), array('users'))) ? ' menu-open' : '' );?>">
						<a href="#" class="nav-link<?php echo (($this->uri->segment(2) == 'users') ? ' active' : '' );?>"><i class="nav-icon fas fa-users"></i><p>Users<i class="right fas fa-angle-left"></i></p></a>
            			<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url();?>admin/users/add" class="nav-link<?php echo (($this->uri->segment(2) == 'users' && $this->uri->segment(3) == 'add') ? ' active' : '' );?>"><i class="fas fa-user-plus nav-icon"></i><p>Add User</p></a></li>
							<li class="nav-item"><a href="<?php echo base_url();?>admin/users" class="nav-link<?php echo (($this->uri->segment(2) == 'users' && $this->uri->segment(3) == '') ? ' active' : '' );?>"><i class="fas fa-user nav-icon"></i><p>View Users</p></a></li>
            			</ul>
          			</li>
          			<li class="nav-item<?php echo ((in_array($this->uri->segment(2), array('roles'))) ? ' menu-open' : '' );?>">
						<a href="#" class="nav-link<?php echo (($this->uri->segment(2) == 'roles') ? ' active' : '' );?>"><i class="nav-icon fas fa-user-tag"></i><p>Roles<i class="right fas fa-angle-left"></i></p></a>
            			<ul class="nav nav-treeview">
							<li class="nav-item"><a href="<?php echo base_url();?>admin/roles/add" class="nav-link<?php echo (($this->uri->segment(2) == 'roles' && $this->uri->segment(3) == 'add') ? ' active' : '' );?>"><i class="fas fa-plus nav-icon"></i><p>Add Role</p></a></li>
							<li class="nav-item"><a href="<?php echo base_url();?>admin/roles" class="nav-link<?php echo (($this->uri->segment(2) == 'roles' && $this->uri->segment(3) == '') ? ' active' : '' );?>"><i class="fas fa-th-list nav-icon"></i><p>View Roles</p></a></li>
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
		    		<li class="nav-item"><a href="<?php echo base_url()?>app/dashboard" class="nav-link">STUFF</a></li>
<?php if ($this->authuser->hasRole('Office User Manager') && !$this->authuser->isSuperAdmin()) :?>
		    		<li class="nav-item"><a href="<?php echo base_url()?>office/manager" class="nav-link">OFFICE</a></li>
<?php endif;?>
		    	</ul>
		    </div>
			<div class="mini-footer text-center ml-0 p-3">
				Copyright &copy; <?php echo date('Y');?><br><a href="<?php echo base_url();?>"><?php echo ucwords(str_replace('_', ' ', $this->config->item('app_name')));?></a>.
			</div>
	   	</div>
	</aside>
