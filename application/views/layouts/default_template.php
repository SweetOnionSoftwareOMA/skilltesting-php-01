<?php /**
	   * This layout has no side navgation bar.
	   */?>
<?php $this->load->view('layouts/partials/header');?>
<!-- you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->

<body data-page="<?php echo $pageFunction ?>" class="<?php echo $pageClass;?>">
<?php
	if ($this->session->logged_in == true) {?>
	<div class="wrapper wrapper-full-page">
		<div class="full-page" data-color="blue">
			<div class="content ml-5 mr-5">
				<!-- START specific Page -->
				<?php $this->load->view($primaryView);?>
				<!-- END specific Page -->
			</div>
			<!-- footer here -->
			<?php $this->load->view('layouts/partials/footer') ?>
		</div>
	</div>
<?php
	} else {?>
	<!-- START specific Page -->
	<?php $this->load->view($primaryView) ?>
	<!-- END specific Page -->
<?php
	}?>

<!--  JS PRELOADER  -->
<?php echo asset_preloader('js');?>
<script src="https://kit.fontawesome.com/5b1aec6b4e.js" crossorigin="anonymous"></script>
<!--  ./JS PRELOADER  -->
<script src="https://www.google.com/recaptcha/api.js"></script>
<?php if ($this->session->flashdata('userMessageTitle')) :?>
<script>
	var swal_html;
<?php if ($this->session->flashdata('userMessages')) : ?>
	var swal_html = '' + <?php foreach ($this->session->flashdata('userMessages') as $message) : ?> '<p><?php echo $message;?></p>' + <?php endforeach;?> '';
<?php endif; ?>
	let timerInterval;
	Swal.fire({
		icon: '<?php echo $this->session->flashdata('userMessageType');?>',
		title: '<?php echo $this->session->flashdata('userMessageTitle');?>',
		html: swal_html,
		timer: 5000,
		showConfirmButton: false,
		position: 'center',
	});
</script>
<?php endif;?>
</body>
