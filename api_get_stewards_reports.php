<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$_token = "";
if( isset($_POST['access_token'])) $_token = $_POST['access_token'];

$_date = "";
if( isset($_POST['date'])) $_date = $_POST['date'];
	require_once __DIR__ . "/JRA/userManager.php";
	if( $_date == ""){
		echo "No Date";
		exit();
	}
	if( $_token != ""){
		getApiRespond($_token, $_date);
	} else{
		echo "No Key";
		exit();
	}
	// $user = getUserInfoFromCode($_token);
	// if( $user !== false){
	// 	echo getApiRespond($user, $_token);
	// } else{
	// 	echo "Invalid key";
	// }
?>