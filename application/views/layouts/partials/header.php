<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $pageTitle;?></title>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">

	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>favicon-16x16.png">
	<link rel="manifest" href="<?php echo base_url();?>site.webmanifest">

	<!--  CSS PRELOADER  -->
	<?php echo asset_preloader('css');?>
	<!--  ./CSS PRELOADER  -->
	<script type="text/javascript">
		let project_url = '<?php echo base_url();?>';
		let is_super_admin = <?php echo (($this->authuser->isSuperAdmin()) ? '1' : '0' );?>;
	</script>
</head>
