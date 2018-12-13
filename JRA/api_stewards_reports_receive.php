<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$date = '';
if( isset($_POST['date'])) $date = $_POST['date'];
if( isset($_GET['date'])) $date = $_GET['date'];
$contents = '';
if( isset($_POST['contents'])) $contents = $_POST['contents'];
if( isset($_GET['contents'])) $contents = $_GET['contents'];
if( $date != '' && $contents != ''){
	$contents = urldecode($contents);
	$contents = str_replace( ")\",\"events\"", ")\",\n\"events\"", $contents);
	$contents = str_replace( ",{\"meeting_name\"", ",\n{\"meeting_name\"", $contents);
	$contents = str_replace( "{\"race_number\"", "\n{\"race_number\"", $contents);
	file_put_contents('logs/stewards/' . $date . '.json', $contents);
	echo 'logs/stewards/' . $date . '.json';
}
?>