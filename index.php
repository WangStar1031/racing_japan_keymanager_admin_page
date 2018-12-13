<?php 
	
	require_once("<?=ASSETS_DIR?>/apis/common.lib.php");

	$_SESSION["userIdx"] = 0;

	if(isset($_POST["text"]) && isset($_POST["pass"])) {
		$name = $_POST["text"];
		$pass = $_POST["pass"];
		if(($name) && ($pass)) {
			if(__validate_user_info($name, $pass)) {
				header('Location: main.php');
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Racing Japan Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
    <link rel="icon" type="image/png" href="<?=ASSETS_DIR?>/logo.png" />
    <link rel="shortcut icon" href="<?=ASSETS_DIR?>/logo.png">
    <link rel="apple-touch-icon" sizes="76x76" href="apple-icon.png">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_DIR?>/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_DIR?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_DIR?>/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_DIR?>/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_DIR?>/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_DIR?>/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=ASSETS_DIR?>/css/main.css?<?=date("YmdHis")?>">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

				<form class="login100-form validate-form" method="post">
					<!--
					<span class="login100-form-title">
						User Login
					</span>
					-->
					<div class="wrap-input100 validate-input" data-validate = "Username is required">
						<input class="input100" type="text" name="text" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="<?=ASSETS_DIR?>/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=ASSETS_DIR?>/vendor/bootstrap/js/popper.js"></script>
	<script src="<?=ASSETS_DIR?>/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=ASSETS_DIR?>/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?=ASSETS_DIR?>/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="<?=ASSETS_DIR?>/js/main.js"></script>

</body>
</html>