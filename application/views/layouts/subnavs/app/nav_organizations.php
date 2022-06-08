
<div class="sidebar" data="primary">
	<!-- Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red" -->
	<div class="sidebar-wrapper">
		<div class="logo">
			<a href="javascript:void(0)" class="simple-text logo-normal">
				Organizations Manager
			</a>
		</div>
		<ul class="nav">
			<li>
				<a href="<?= site_url('appmgr/organizations/org_list') ?>">
					<i class="fad fa-2x fa-fw fa-warehouse-alt"></i>
					<p>Organization Listing</p>
				</a>
			</li>
			<li>
				<a href="<?= site_url('appmgr/organizations/add_organization') ?>">
					<i class="fad fa-plus-circle"></i>
					<p>Create Organization</p>
				</a>
			</li>
		</ul>
		<div class="logo">
			<a href="javascript:void(0)" class="simple-text logo-normal">
				Offices-
			</a>
		</div>
		<ul class="nav">
			<li>
				<a href="<?= site_url('appmgr/offices/offices_list') ?>">
					<i class="fad fa-2x fa-fw fa-clinic-medical"></i>
					<p>Offices Listing</p>
				</a>
			</li>
			<li>
				<a href="<?= site_url('appmgr/offices/add_office') ?>">
					<i class="fad fa-2x fa-fw fa-plus-circle"></i>
					<p>Create Office</p>
				</a>
			</li>
		</ul>
		<div class="logo">
			<a href="javascript:void(0)" class="simple-text logo-normal">
				System notifications
			</a>
		</div>
		<ul class="nav">
			<li>
				<a href="<?= site_url('appmgr/notifications/listing') ?>">
					<i class="fad fa-2x fa-fw fa-comment-alt-lines"></i>
					<p>Notifications Listing</p>
				</a>
			</li>
			<li>
				<a href="<?= site_url('appmgr/notifications/create') ?>">
					<i class="fad fa-2x fa-fw fa-comment-alt-plus"></i>
					<p>Create Notification</p>
				</a>
			</li>
		</ul>
	</div>
</div>
