<!DOCTYPE html>
<html>

<head>
  <!-- Basic Page Info -->
  <meta charset="utf-8" />
  <title><?= isset($pageTitle) ? $pageTitle : 'Library Desk'; ?></title>

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
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/styles/core.css') ?>" />
  <link
    rel="stylesheet"
    type="text/css"
    href="<?= base_url('assets/vendors/styles/icon-font.min.css') ?>" />
  <link
    rel="stylesheet"
    type="text/css"
    href="<?= base_url('assets/src/plugins/datatables/css/dataTables.bootstrap4.min.css') ?>" />
  <link
    rel="stylesheet"
    type="text/css"
    href="<?= base_url('assets/src/plugins/datatables/css/responsive.bootstrap4.min.css') ?>" />
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/styles/style.css') ?>" />
  <style>
     #member-card {
      display: flex;
      justify-content: center;
      /* Center horizontally */
      align-items: center;
      /* Center vertically */
    }

    /* Card Container */
    .card-member {
      width: 600px;
      height: 350px;
      background-image: url('/assets/vendors/images/bg-card.png');
      /* Replace with your image path */
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
    .card-member .header-card {
      position: absolute;
      top: 20px;
      left: 150px;
      font-size: 30px;
      color: #ffffff;
    }

    .card-member .sub-header {
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
      top: 175px;
      left: 220px;
    }

    .card-member .info div {
      margin-bottom: 5px;
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


    /* The switch - the box around the slider */
    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 23px;
      float: left;
    }

    /* Hide default HTML checkbox */
    .switch input {
      display: none;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 15px;
      width: 15px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input.default:checked+.slider {
      background-color: #444;
    }

    input.primary:checked+.slider {
      background-color: #2196F3;
    }

    input:focus+.slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
   
    /* @media print {
    @page {
        size: 90mm 55mm;
        margin: 0;
    }

.card-member {
    width: 90mm;
    height: 55mm;
    background-image: url('/assets/vendors/images/bg-card.png');
    background-size: cover;
    background-position: center;
    position: relative;
    color: #ffffff;
    font-weight: bold;
    padding: 1em;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    overflow: hidden;
    font-size: 0.9em; 
}

.card-member .header-card {
    position: absolute;
    top: 0.5em; 
    left: 4em;
    font-size: 1.5em; 
    color: #ffffff;
}

.card-member .sub-header {
    position: absolute;
    top: 7em;
    left: 10.5em;
    font-size: 0.8em;
    font-weight: bold;
}

.card-member .photo {
    position: absolute;
    top: 5.2em; 
    left: 2em;
    width: 20.5mm;
    height: 20.5mm; 
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


.card-member .info {
    position: absolute;
    top: 7.3em;
    left: 8.5em;
}

.card-member .info div {
    margin-bottom: 0.5em; 
    font-size: 0.5em; 
    color: #0c3a76;
}


.card-member .id-section {
    position: absolute;
    bottom: 1em;
    left: 0.5em;
    font-size: 0.8em;
    color: #ffffff;
}
} */


    
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
  <script src="<?= base_url('assets/vendors/scripts/core.js') ?>"></script>
  <script src="<?= base_url('') ?>assets/vendors/scripts/script.min.js"></script>
  <script src="<?= base_url('assets/vendors/scripts/process.js') ?>"></script>
  <script src="<?= base_url('assets/vendors/scripts/layout-settings.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/apexcharts/apexcharts.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/dataTables.responsive.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/responsive.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('assets/vendors/scripts/dashboard3.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/dataTables.buttons.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/buttons.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/buttons.print.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/buttons.html5.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/buttons.flash.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/pdfmake.min.js') ?>"></script>
  <script src="<?= base_url('assets/src/plugins/datatables/js/vfs_fonts.js') ?>"></script>
  <script src="<?= base_url('assets/vendors/scripts/datatable-setting.js') ?>"></script>
</body>

</html>
<!DOCTYPE html>
<html>
