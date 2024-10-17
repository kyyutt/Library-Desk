<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />
	<title><?= isset($pageTitle) ? $pageTitle : 'New Page Title'; ?></title>

	<!-- Site favicon -->
	<link
		rel="apple-touch-icon"
		sizes="180x180"
		href="/assets/vendors/images/apple-touch-icon.png" />
	<link
		rel="icon"
		type="image/png"
		sizes="32x32"
		href="/assets/vendors/images/favicon-32x32.png" />
	<link
		rel="icon"
		type="image/png"
		sizes="16x16"
		href="/assets/vendors/images/favicon-16x16.png" />

	<!-- Mobile Specific Metas -->
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link
		href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/assets/vendors/styles/core.css" />
	<link
		rel="stylesheet"
		type="text/css"
		href="/assets/vendors/styles/icon-font.min.css" />
	<link
		rel="stylesheet"
		type="text/css"
		href="/assets/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
	<link
		rel="stylesheet"
		type="text/css"
		href="/assets/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
	<link rel="stylesheet" type="text/css" href="/assets/vendors/styles/style.css" />
</head>

<body>
	<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo">
				<img src="/assets/vendors/images/logo.png" alt="" />
			</div>
			<div class="loader-progress" id="progress_div">
				<div class="bar" id="bar1"></div>
			</div>
			<div class="percent" id="percent1">0%</div>
			<div class="loading-text">Loading...</div>
		</div>
	</div>

	<?= include('inc/header.php'); ?>
	<?= include('inc/right-sidebar.php'); ?>
	<?= include('inc/left-sidebar.php'); ?>

	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-10 xs-pd-20-10">
			<div class="min-height-200px">

				<?= $this->renderSection('content'); ?>
			</div>
			<div class="footer-wrap pd-20 mb-20 card-box">
				<p class="mb-0">&copy; 2024 Perpustakaan. All rights reserved.</p>
			</div>
		</div>
	</div>


	<!-- js -->
	<script src="/assets/vendors/scripts/core.js"></script>
	<script src="/assets/vendors/scripts/script.min.js"></script>
	<script src="/assets/vendors/scripts/process.js"></script>
	<script src="/assets/vendors/scripts/layout-settings.js"></script>
	<script src="/assets/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="/assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="/assets/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="/assets/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<!-- buttons for Export datatable -->
	<script src="/assets/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
	<script src="/assets/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
	<script src="/assets/src/plugins/datatables/js/buttons.print.min.js"></script>
	<script src="/assets/src/plugins/datatables/js/buttons.html5.min.js"></script>
	<script src="/assets/src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="/assets/src/plugins/datatables/js/pdfmake.min.js"></script>
	<script src="/assets/src/plugins/datatables/js/vfs_fonts.js"></script>
	<!-- Datatable Setting js -->
	<script src="/assets/vendors/scripts/datatable-setting.js"></script>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe
			src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS"
			height="0"
			width="0"
			style="display: none; visibility: hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
</body>

</html>