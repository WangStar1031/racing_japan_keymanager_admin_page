<?php

$_action = "";
if( isset($_POST['action'])) $_action = $_POST['action'];
require_once __DIR__ . "/userManager.php";

switch ($_action) {
	case 'verifyToken':
		$_token = "";
		if( isset($_POST['token'])) $_token = $_POST['token'];
		if( $_token != ""){
			$userInfo = getUserInfoFromCode($_token);
			if( $userInfo != false){
				echo $userInfo->eMail;
			}
		}
		break;
	case 'renew':
		$_email = "";
		if( isset($_POST['email'])) $_email = $_POST['email'];
		$_preToken = "";
		if( isset($_POST['preToken'])) $_preToken = $_POST['preToken'];
		$ret = reNewToken($_email, $_preToken);
		// if( $ret != false) echo json_encode($ret);
		break;
	case 'update':
	// email: email, token: token, isSubmitCat: isSubmitCat, limit:limit_input.val(), limitation: limitation
		$_email = "";
		if( isset($_POST['email'])) $_email = $_POST['email'];
		$_token = "";
		if( isset($_POST['token'])) $_token = $_POST['token'];
		$_isSubmitCat = "";
		if( isset($_POST['isSubmitCat'])) $_isSubmitCat = $_POST['isSubmitCat'];
		$_limit = "";
		if( isset($_POST['limit'])) $_limit = $_POST['limit'];
		$_limitation = "";
		if( isset($_POST['limitation'])) $_limitation = $_POST['limitation'];
		if( updateUserProductInfo($_email, $_token, $_isSubmitCat, $_limit, $_limitation) == true){
		// if( changeLimit_count($_email, $_limit_count, $_isChecked) == true){
			echo "YES";
		}
		break;
	case 'payment':
		$_curPass = "";
		if( isset($_POST['payPassword'])) $_curPass = $_POST['payPassword'];
		if( verifyAdminPassword($_curPass) == true){
			$_stripeKey = "";
			if( isset($_POST['stripeKey'])) $_stripeKey = $_POST['stripeKey'];
			$_stripeSecret = "";
			if( isset($_POST['stripeSecret'])) $_stripeSecret = $_POST['stripeSecret'];
			if( changeStripeSettings($_stripeKey, $_stripeSecret) == true){
				echo "YES";
			}
		}
		break;
	case 'changePass':
		$_curPass = "";
		if( isset($_POST['curPass'])) $_curPass = $_POST['curPass'];
		$_newPass = "";
		if( isset($_POST['newPass'])) $_newPass = $_POST['newPass'];
		if( changeAdminPassword($_curPass, $_newPass) == true){
			echo "YES";
		} else{
			echo "NO";
		}
		break;
	case 'remove':
		$_email = "";
		if( isset($_POST['email'])) $_email = $_POST['email'];
		$_preToken = "";
		if( isset($_POST['preToken'])) $_preToken = $_POST['preToken'];
		removeToken( $_email, $_preToken);
		break;
	case 'create':
		$_firstName = "";
		if( isset($_POST['firstName'])) $_firstName = $_POST['firstName'];
		$_lastName = "";
		if( isset($_POST['lastName'])) $_lastName = $_POST['lastName'];
		$_eMail = "";
		if( isset($_POST['eMail'])) $_eMail = $_POST['eMail'];
		$_pass = $_eMail;
		if( $_eMail != ""){
			if( registerUser( $_firstName, $_lastName, $_eMail, $_pass) === true){
				echo "YES";
			}
		}
		break;
	case 'refresh':
		$_curDate = date("Y-m-d");
		break;
}
?>