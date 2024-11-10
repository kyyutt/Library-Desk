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
		href="/assets/vendors/images/logo2.png" />
	<link
		rel="icon"
		type="image/png"
		sizes="32x32"
		href="/assets/vendors/images/logo2.png" />
	<link
		rel="icon"
		type="image/png"
		sizes="16x16"
		href="/assets/vendors/images/logo2.png" />

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
	<style>
		#member-card {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
}
		/* Card Container */
		.card-member {
      width: 600px;
      height: 350px;
      background-image: url('/assets/vendors/images/bg-card.png'); /* Replace with your image path */
      background-size: cover;
      background-position: center;
      position: relative;
      color: #ffffff;
      font-weight: bold;
      padding: 20px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    /* Top Section */
    .card-member .header-card{
      position: absolute;
      top: 20px;
      left: 150px;
      font-size: 30px;
      color: #ffffff;
    }

    .card-member .sub-header{
      position: absolute;
      top: 133px;
      left: 220px;
      font-size: 18px;
      font-weight: bolder;
    }

    /* Photo Section */
    .card-member .photo {
      position: absolute;
      top: 124px;
      left: 52px;
      width: 136px;
      height: 136px;
      background-color: #0044cc;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .card-member .photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Member Information */
    .card-member .info {
      position: absolute;
      top: 180px;
      left: 220px;
    }

    .card-member .info div {
      margin-bottom: 10px;
      font-size: 14px;
      color: #0c3a76;
    }

    /* ID Section */
    .card-member .id-section {
      position: absolute;
      bottom: 20px;
      left: 20px;
      font-size: 18px;
      color: #ffffff;
    }
	</style>
</head>

<body>
	<!-- <div class="pre-loader">
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
	</div> -->

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