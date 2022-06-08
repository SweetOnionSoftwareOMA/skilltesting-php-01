<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Configuration variables that permit usign CDNs, load balancers and offloading of assets
 * to 3rd party storage solutions. Eg. Cloudfront, S3 buckets, or assets servers.
 */
$config['assets_assetURL'] = null;
$config['assets_cloudfrontURL'] = null;
$config['assets_jsURL'] = null;
$config['assets_cssURL'] = null;
$config['assets_imageURL'] = null;
$config['assets_videoURL'] = null;

/**
 * Array of CDNs to preload in the application, the order matters as they are written out in
 * the exact order of the array. The key should be a unique name : TYPE. The value is the fully qualified
 * location of the file.
 * EXCEPTION:  {asseturl} will be replaced using the media_url function
 *
 *
 *      Prototype:
 *
 *   $preloadCDN = [
 *       'jquery:js'    => 'http(s)://cdn.com/path/to/class/file.js',
 *       'jquery:css'   => 'http(s)://cdn.com/path/to/class/file.js',
 *       'internal:js   => '{asseturl}/path/to/class/file.js'
 *   ];
 *
 */

$config['assets_preloadCDN'] = [
	"googlefont:css"           => "https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback",
	"admin:css"                => "assets/dist/css/adminlte.min.css",
	"ionicframework:css"       => "https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css",
	"tempusdominus:css"        => "assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css",
	"icheck-bootstrap:css"     => "assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css",
	"jqvmap:css"               => "assets/plugins/jqvmap/jqvmap.min.css",
	"overlayScrollbars:css"    => "assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css",
	"daterangepicker:css"      => "assets/plugins/daterangepicker/daterangepicker.css",
	"summernote:css"           => "assets/plugins/summernote/summernote-bs4.min.css",
	"jquery:js"                => "assets/plugins/jquery/jquery.min.js",
	'jqueryui:css'             => "assets/plugins/jquery-ui/jquery-ui.min.css",
	"jqueryui:js"              => "assets/plugins/jquery-ui/jquery-ui.min.js",
	"bootstrap:js"             => "assets/plugins/bootstrap/js/bootstrap.bundle.min.js",
	// "mdbootstrap:css"          => 'https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css',
	// "mdbootstrap:js"           => 'https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js',
	"chart:js"                 => "assets/plugins/chart.js/Chart.min.js",
	"sparkline:js"             => "assets/plugins/sparklines/sparkline.js",
	// "jqvmap:js"             => "assets/plugins/jqvmap/jquery.vmap.min.js",
	// "jqvmapusa:js"          => "assets/plugins/jqvmap/maps/jquery.vmap.usa.js",
	"bootstrapSwitch:js"       => "assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
	"jqueryknob:js"            => "assets/plugins/jquery-knob/jquery.knob.min.js",
	"moment:js"                => "assets/plugins/moment/moment.min.js",
	"daterangepicker:js"       => "assets/plugins/daterangepicker/daterangepicker.js",
	"tempusdominus:js"         => "assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js",
	"summernote:js"            => "assets/plugins/summernote/summernote-bs4.min.js",
	"overlayScrollbars:js"     => "assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js",
	"validate:js"              => "assets/plugins/jquery-validation/jquery.validate.min.js",
	"additionalMethods:js"     => "assets/plugins/jquery-validation/additional-methods.min.js",
	'swal:css'     	           => "assets/plugins/sweetalert2/sweetalert2.min.css",
	'swal:js'     	           => "assets/plugins/sweetalert2/sweetalert2.min.js",
	'weekPicker:js'     	   => "assets/plugins/jquery-week-picker/weekPicker.js",
	'colorpicker:css' 		   => "assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css",
	'colorpicker:js' 		   => "assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"
	// "mdbootstrap:css"          => 'assets/mdb/pro-4.19.2/css/mdb.min.css',
	// "mdbootstrap:js"           => 'assets/mdb/pro-4.19.2/js/mdb.min.js',
];

if (isset($_SERVER['REQUEST_URI'])){
	if(editor_data_table($_SERVER['REQUEST_URI'])) {
		$config['assets_preloadCDN'] += [
			'dtable1:css'          => "assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css",
			'dtable2:css'          => "assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css",
			'dtable3:css'          => "assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css",
			'dtable1:js'           => "assets/plugins/datatables/jquery.dataTables.min.js",
			'dtable3:js'           => "assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
			'dtable4:js'           => "assets/plugins/datatables-responsive/js/dataTables.responsive.min.js",
			'dtable5:js'           => "assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js",
			'dtable6:js'           => "assets/plugins/datatables-buttons/js/dataTables.buttons.min.js",
			'dtable7:js'           => "assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js",
			'dtable8:js'           => "assets/plugins/jszip/jszip.min.js",
			'dtable9:js'           => "assets/plugins/pdfmake/pdfmake.min.js",
			'dtable10:js'          => "assets/plugins/pdfmake/vfs_fonts.js",
			'dtable11:js'          => "assets/plugins/datatables-buttons/js/buttons.html5.min.js",
			'dtable12:js'          => "assets/plugins/datatables-buttons/js/buttons.print.min.js",
			'dtable13:js'          => "assets/plugins/datatables-buttons/js/buttons.colVis.min.js"
		];
	}
}

$config['assets_preloadCDN'] += [
	"admin:js"                 => "assets/dist/js/adminlte.min.js",
	"app:css"                  => "assets/dist/css/app.css",
	"app:js"                   => "assets/dist/js/app.js"
];

/**
 * @param $url
 * @return bool
 * check if the view is of editor data table
 */
function editor_data_table($url) {
	//Removing local folder name from $url
	$url = str_replace('/metrics-that-matter', '', $url);
	$response = false;
	switch ($url) {
		case stristr($url,'/app/od_dataset'):
		case stristr($url,'/app/vc_dataset'):
		case stristr($url,'/app/location_dataset'):
		case stristr($url,'/office/manager'):
		case stristr($url,'/admin/offices'):
		case stristr($url,'/admin/users'):
		case stristr($url,'/admin/roles'):
			$response = true;
			break;
	}
	return $response;
}
