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
<?php if ($this->authuser->hasRole('General Access') || $this->authuser->hasRole('OD Form') || $this->authuser->hasRole('Location Form') || $this->authuser->hasRole('VC Form')) :?>
					<li class="nav-item<?php echo ((in_array($this->uri->segment(2), array('forms', 'od_form', 'location_form', 'vc_form'))) ? ' menu-open' : '' );?>">
            			<a href="<?php echo base_url();?>app/forms/list" class="nav-link<?php echo (($this->uri->segment(2) == 'forms') ? ' active' : '' );?>"><i class="nav-icon fas fa-edit"></i><p>Forms<?php echo (($this->authuser->hasRole('OD Form') || $this->authuser->hasRole('Location Form') || $this->authuser->hasRole('VC Form')) ? '<i class="fas fa-angle-left right"></i>' : '' );?></p></a>
<?php
						if ($this->authuser->hasRole('OD Form') || $this->authuser->hasRole('Location Form') || $this->authuser->hasRole('VC Form')):?>
            			<ul class="nav nav-treeview">
<?php
							if ($this->authuser->hasRole('OD Form')):?>
              				<li class="nav-item"><a href="<?php echo base_url();?>app/od_form" class="nav-link<?php echo (($this->uri->segment(2) == 'od_form') ? ' active' : '' );?>"><i class="fas fa-th nav-icon"></i> <p>OD Form</p></a></li>
<?php
							endif;
							if ($this->authuser->hasRole('Location Form')):?>
              				<li class="nav-item"><a href="<?php echo base_url();?>app/location_form" class="nav-link<?php echo (($this->uri->segment(2) == 'location_form') ? ' active' : '' );?>"><i class="fas fa-th nav-icon"></i> <p>Location Form</p></a></li>
<?php
							endif;
							if ($this->authuser->hasRole('VC Form')):?>
              				<li class="nav-item"><a href="<?php echo base_url();?>app/vc_form" class="nav-link<?php echo (($this->uri->segment(2) == 'vc_form') ? ' active' : '' );?>"><i class="fas fa-th nav-icon"></i> <p>VC Form</p></a></li>
<?php
							endif;?>
						</ul>
<?php
						endif;?>
					</li>
<?php endif;?>
<?php if ($this->authuser->hasRole('Data Analyst')) :?>
					<li class="nav-item<?php echo ((in_array($this->uri->segment(2), array('datasets', 'od_dataset', 'location_dataset', 'vc_dataset'))) ? ' menu-open' : '' );?>">
            			<a href="#" class="nav-link<?php echo (($this->uri->segment(2) == 'datasets') ? ' active' : '' );?>"><i class="nav-icon fas fa-table"></i></i><p>Datasets<i class="fas fa-angle-left right"></i></p></a>
            			<ul class="nav nav-treeview">
              				<li class="nav-item"><a href="<?php echo base_url();?>app/od_dataset" class="nav-link<?php echo (($this->uri->segment(2) == 'od_dataset') ? ' active' : '' );?>"><i class="fas fa-table nav-icon"></i> <p>OD DataSet</p></a></li>
              				<li class="nav-item"><a href="<?php echo base_url();?>app/location_dataset" class="nav-link<?php echo (($this->uri->segment(2) == 'location_dataset') ? ' active' : '' );?>"><i class="fas fa-table nav-icon"></i> <p>Location DataSet</p></a></li>
              				<li class="nav-item"><a href="<?php echo base_url();?>app/vc_dataset" class="nav-link<?php echo (($this->uri->segment(2) == 'vc_dataset') ? ' active' : '' );?>"><i class="fas fa-table nav-icon"></i> <p>VC DataSet</p></a></li>
						</ul>
					</li>
<?php endif;?>
<?php if ($this->authuser->hasRole('Super Admin') || $this->authuser->hasRole('Data Analyst')) :?>
					<li class="nav-item"><a href="<?php echo base_url();?>app/charts" class="nav-link<?php echo (($this->uri->segment(2) == 'charts') ? ' active' : '' );?>"><i class="nav-icon fas fa-chart-bar"></i><p>Chart Builder</p></a></li>
<?php endif;?>
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
