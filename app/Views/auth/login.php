<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />
	<title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

	<!-- Site favicon -->
	<link
		rel="apple-touch-icon"
		sizes="180x180"
		href="assets/vendors/images/apple-touch-icon.png" />
	<link
		rel="icon"
		type="image/png"
		sizes="32x32"
		href="assets/vendors/images/logo2.png" />
	<link
		rel="icon"
		type="image/png"
		sizes="16x16"
		href="assets/vendors/images/logo2.png" />

	<!-- Mobile Specific Metas -->
	<meta
		name="viewport"
		content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link
		href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="assets/vendors/styles/core.css" />
	<link
		rel="stylesheet"
		type="text/css"
		href="assets/vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/vendors/styles/style.css" />

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script
		async
		src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
	<script
		async
		src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
		crossorigin="anonymous"></script>
</head>

<body class="login-page">
	<div class="login-header box-shadow">
		<div
			class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.html">
					<img src="assets/vendors/images/logo.png" alt="" />
				</a>
			</div>
		</div>
	</div>
	<div
		class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="assets/vendors/images/login-page-img.png" alt="" />
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Login To LibraryDesk</h2>
						</div>
						<form action="/auth/login" method="post">
							<div class="input-group custom">
								<input
									type="text"
									class="form-control form-control-lg"
									placeholder="Username" name="username"/>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input
									type="password"
									class="form-control form-control-lg"
									placeholder="**********" name="password"/>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<!-- <div class="row pb-30">
								<div class="col-6">
									<div class="custom-control custom-checkbox">
										<input
											type="checkbox"
											class="custom-control-input"
											id="customCheck1" />
										<label class="custom-control-label" for="customCheck1">Remember</label>
									</div>
								</div>
								<div class="col-6">
									<div class="forgot-password">
										<a href="forgot-password.html">Forgot Password</a>
									</div>
								</div>
							</div> -->
							<button type="submit"
								class="btn btn-primary btn-lg btn-block">Sign In</button>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- js -->
	<script src="assets/vendors/scripts/core.js"></script>
	<script src="assets/vendors/scripts/script.min.js"></script>
	<script src="assets/vendors/scripts/process.js"></script>
	<script src="assets/vendors/scripts/layout-settings.js"></script>
	<!-- Google Tag Manager (noscript) -->

</body>

</html>