<?php
	require_once('../assets/apis/common.inc.php');
	require_once("library/common_lib.php");

	$track_id = 0;
	$curTime = GetCurrentJapanTimeStamp();
	$date = date("Ymd", $curTime);
	if(isset($_GET['track_id'])) $track_id = $_GET['track_id'];
	if(isset($_GET['date'])) $date = $_GET['date'];

	$real_json = __generate_json_from_race($date, $track_id);
	$real_json = __preprocessing_json($real_json);
	
	echo json_encode($real_json);
?>