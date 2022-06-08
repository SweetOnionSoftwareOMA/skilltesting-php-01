<?php
// THis layout has no side navgation bar.?>

<?php $this->load->view('layouts/partials/header'); ?>
<!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->

<body data-page="<?php echo $pageFunction ?>" class="<?php echo $pageClass;?>">
<div class="wrapper">
	<!-- Preloader -->
	<div class="preloader flex-column justify-content-center align-items-center">
		<img class="animation__shake" src="<?php echo base_url();?>assets/img/mtm-logo<?php echo (($this->uri->segment('1') == 'admin') ? '-dark' : '' );?>.png" alt="<?php echo ucwords(str_replace('_', ' ', $this->config->item('app_name')));?>" style="height: 60px;">
	</div>

	<!-- START NAVBAR -->
<?php
		$this->load->view('layouts/partials/navbar_top_auth');?>
	<!-- END NAVBAR -->

	<!-- START SUBNAVBAR -->
<?php
		$this->load->view('layouts/subnavs/' . $subNavBar);?>
	<!-- END SUBNAVBAR -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url();?>"><i class="fas fa-home"></i></a></li>
<?php
					foreach ($breadcrumb as $key => $value) :?>
		          			<li class="breadcrumb-item">
<?php
						if ($key == '#'):?>
								<?php echo $value;?>
<?php
						else:?>
		          				<a href="<?php echo $key;?>"><?php echo $value;?></a>
<?php
						endif;?>
							</li>
<?php
					endforeach;?>
		        		</ol>
		      		</div><!-- /.col -->
		    	</div><!-- /.row -->
				<div class="callout callout-primary">
	            	<?php echo ((isset($heading)) ? '<h5 class="mb-0">'.$heading.((isset($subHeading)) ? ' <small>'.$subHeading.'</small>' : '' ).'</h5> ' : '' );?>

            		<?php echo ((isset($pageDescription)) ? $pageDescription : '' );?>
	            </div>
	        </div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<div class="content">
			<!-- START specific Page -->
<?php
			$this->load->view($primaryView, array('name' => @$name, 'formSubmitHandler' => @$formSubmitHandler));?>
			<!-- END specific Page -->
		</div>
		<!-- END content -->
	</div>
	<!-- END main-panel -->
</div>
<!-- START FOOTER -->
<?php $this->load->view('layouts/partials/footer') ?>
<!-- END FOOTER -->
<!--  JS PRELOADER  -->
<?php echo asset_preloader('js');?>
<script src="https://kit.fontawesome.com/5b1aec6b4e.js" crossorigin="anonymous"></script>
<!--  ./JS PRELOADER  -->
<?php if ($this->session->flashdata('userMessageTitle')) : ?>
<script>
	var swal_html;
<?php if ($this->session->flashdata('userMessages')) : ?>
	var swal_html = '' +
<?php foreach ($this->session->flashdata('userMessages') as $message) : ?> '<p> <?= $message ?> </p>' +
<?php endforeach; ?> '';
<?php endif; ?>

	let timerInterval;

	Swal.fire({
		icon: '<?= $this->session->flashdata('userMessageType') ?>',
		title: '<?= $this->session->flashdata('userMessageTitle') ?>',
		html: swal_html,
		timer: 5000,
		showConfirmButton: false,
		position: 'center'
	});
</script>
<?php endif; ?>
</body>
</html>
