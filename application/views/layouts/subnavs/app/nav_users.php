<div class="sidebar" data="primary">
	<!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
	<div class="sidebar-wrapper">
		<div class="logo">
			<a href="javascript:void(0)" class="simple-text logo-normal">
				User Manager
			</a>
		</div>
		<ul class="nav">
			<li>
				<a href="<?= site_url('app/usermgt/user_list') ?>">
					<i class="fad fa-2x fa-fw fa-users"></i>
					<p>User Listing</p>
				</a>
			</li>
			<li>
				<a href="<?= site_url('app/usermgt/user_add') ?>">
					<i class="fad fa-2x fa-fw fa-user-plus"></i>
					<p>Create User</p>
				</a>
			</li>
		</ul>

		<div class="logo">
			<a href="javascript:void(0)" class="simple-text logo-normal">
				Roles
			</a>
		</div>
		<ul class="nav">
			<li>
				<a href="<?= site_url('app/roles/roles_list') ?>">
					<i class="fad fa-2x fa-fw fa-user-shield"></i>
					<p>Roles Listing</p>
				</a>
			</li>
			<li>
				<a href="<?= site_url('app/roles/add_role') ?>">
					<i class="fad fa-2x fa-fw fa-plus-circle"></i>
					<p>Create Role</p>
				</a>
			</li>
			<div class="logo">
				<a href="javascript:void(0)" class="simple-text logo-normal">
					Permissions
				</a>
			</div>
			<li>
				<a href="<?= site_url('app/permissions/permissions_list') ?>">
					<i class="fad fa-2x fa-fw fa-file-user"></i>
					<p>Permissions Listing</p>
				</a>
			</li>
		</ul>
	</div>
</div>
