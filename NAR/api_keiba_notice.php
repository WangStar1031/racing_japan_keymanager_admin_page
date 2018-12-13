<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('implicit_flush', 1);
ob_implicit_flush(true);
set_time_limit(0);

$c = 0;
if(isset($_GET['c'])) $c = $_GET['c'];

function __process_odds_array($odds_datas) 
{
	$real_odds = [];
	foreach ($odds_datas as $odds_item) {
		$real_odds[] = $odds_item;
	}
	return $real_odds;
}

function __get_current_race($ret, $track_id) {	
	$curTime = GetCurrentJapanTimeStamp();
	$pre_time = $curTime + 1200;
	$post_time = $curTime - 60;

	for($i=0; $i<count($ret); $i++){
		//if($ret[$i]->meeting_id == 0) continue;
		for($j=0; $j<count($ret[$i]->races); $j++){
			$race_id = __regen_race_id_from_href( $ret[$i]->races[$j]->href );
			if($track_id != substr($race_id, -2)) break;
			$time = $ret[$i]->races[$j]->time;
			//if(($track_id == "03") || ($track_id == "3")) continue;
			if(($time <= date("H:i", $pre_time)) && ($time >= date("H:i", $post_time))){
				$race_obj = new \stdClass;
				$race_obj->meeting_id = $ret[$i]->meeting_id;
				$race_obj->meeting_name = $ret[$i]->track_name;
				$race_obj->event_number = $ret[$i]->races[$j]->id;
				$race_obj->time = $time;
				$race_obj->race_id = $race_id;
				$race_obj->track_id = $track_id;

				return $race_obj;
			}			
		}
	}

	return false;
}

function __get_current_races($ret) {	
	$curTime = GetCurrentJapanTimeStamp();
	$pre_time = $curTime + 1200;
	$post_time = $curTime - 60;

	$races = [];

	for($i=0; $i<count($ret); $i++){
		//if($ret[$i]->meeting_id == 0) continue;
		for($j=0; $j<count($ret[$i]->races); $j++){
			$race_id = __regen_race_id_from_href( $ret[$i]->races[$j]->href );
			$track_id = substr($race_id, -2);
			$time = $ret[$i]->races[$j]->time;
			//if(($track_id == "03") || ($track_id == "3")) continue;
			if(($time <= date("H:i", $pre_time)) && ($time >= date("H:i", $post_time))){
				$race_obj = new \stdClass;
				$race_obj->meeting_id = $ret[$i]->meeting_id;
				$race_obj->meeting_name = $ret[$i]->track_name;
				$race_obj->event_number = $ret[$i]->races[$j]->id;
				$race_obj->time = $time;
				$race_obj->race_id = $race_id;
				$race_obj->track_id = $track_id;

				$races[] = $race_obj;
			}			
		}
	}

	return $races;
}

if($c == 15){	// Grab Live Video Odds Data
	require "library/keiba_00.php";
	
	$arr_meeting = array("帯広ば" => "Obihiro", "門別" => "", "札幌" => "", "盛岡" => "", "水沢" => "Mizusawa", "浦和" => "Urawa", "船橋" => "Funabashi", "大井" => "Oi", "川崎" => "Kawasaki", "金沢" => "Kanazawa", "笠松" => "Kasamatsu", "名古屋" => "Nagoya", "中京" => "Chukyo", "園田" => "Sonoda", "姫路" => "", "高知" => "Kochi", "佐賀" => "Saga");

	$ret = __get_race_datas();
	$result = [];

	$races = __get_current_races($ret);

	foreach ($races as $race_obj) {
		if($race_obj->track_id == "03") $race_obj->track_id = "3";
		$odds = @file_get_contents("odds_sum_".$race_obj->track_id);		
		if($odds){
			$odds_infos = json_decode($odds);
			$odds_time = filemtime("odds_sum_".$race_obj->track_id);
			if(time() > $odds_time + 20) continue;
			foreach ($odds_infos as $odds_info) {
				$race_obj2 = new \stdClass;
				$race_obj2->meeting_id = $race_obj->meeting_id;
				$race_obj2->meeting_name = $arr_meeting[$race_obj->meeting_name];
				$race_obj2->event_number = $race_obj->event_number;
				$race_obj2->time = $race_obj->time;
				$race_obj2->race_id = $race_obj->race_id;
				$race_obj2->track_id = $race_obj->track_id;
				$odds = $odds_info->odds;
				$race_obj2->odds_type = $odds_info->oddsType;
				$race_obj2->odds = ($odds?$odds:"Rest");
				$race_obj2->rec_time = date("Y-m-d H:i:s", $odds_time + 3600 * 9);
				$race_obj2->now_time = date("Y-m-d H:i:s", time() + 3600 * 9);
				$result[] = $race_obj2;		
			}					
		}
	}

	echo json_encode($result);
} else if($c == 16){	// Save Live Video Odds Data

	require "library/keiba_00.php";

	$track_id = 0;
	$odds = "";
	$odds_type = 0;
	if(isset($_GET['track_id'])) $track_id = $_GET['track_id'];
	if(isset($_GET['odds'])) $odds = $_GET['odds'];
	if(isset($_GET['odds_type'])) $odds_type = $_GET['odds_type'];
	if($track_id == 0) exit();

	$odds = str_replace("\r", "", $odds);
	$odds = str_replace("\n", "", $odds);
	$oddsType = "";

	$arr_odds = [];
	
	if($track_id == 32){
		if($odds_type == 1) $oddsType = "TRI";
		else if($odds_type == 2) $oddsType = "TRO";		
		$odds_info = new \stdClass;
		$odds_info->oddsType = $oddsType;
		$odds_info->odds = $odds;
		$arr_odds[] = $odds_info;
	} else if($track_id == 24){ // Nagoya
		if($odds_type == 1) $oddsType = "TRI";
		else $oddsType = "TRO";		
		$odds_info = new \stdClass;
		$odds_info->oddsType = $oddsType;
		$odds_info->odds = $odds;
		$arr_odds[] = $odds_info;
	} else if($track_id == 19){ // Funabashi
		$oddsType = "EXA";
		$odds_info = new \stdClass;
		$odds_info->oddsType = $oddsType;
		$odds = str_replace(" ", "", $odds);
		$odds_info->odds = $odds;
		$arr_odds[] = $odds_info;
	} else if($track_id == 18) { // Urawa -> 18
		$odds_datas = explode(" ", trim($odds));
		$odds_datas = __process_odds_array($odds_datas);

		if(count($odds_datas) == 2){
			if($odds_type == 2){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "EXA";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;
			} else if($odds_type == 3){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "TRO";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "TRI";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;
			} else if($odds_type == 4){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "PLC";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;
			}
		} else if($odds_type == 5){
			$odds_info = new \stdClass;
			$odds_info->oddsType = "QNL";
			$odds_info->odds = $odds_datas[0];
			$arr_odds[] = $odds_info;
		} else  if($odds_type == 1){
			if(count($odds_datas) == 3){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "Bracket EXA";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "Bracket QNL";
				$odds_info->odds = $odds_datas[2];
				$arr_odds[] = $odds_info;
			}				
		}
	} else if($track_id == 20) { // Oi -> 20
		$odds_datas = explode(" ", trim($odds));
		$odds_datas = __process_odds_array($odds_datas);

		if(count($odds_datas) == 2){
			$odds_info = new \stdClass;
			$odds_info->oddsType = "WIN";
			$odds_info->odds = $odds_datas[0];
			$arr_odds[] = $odds_info;
			$odds_info = new \stdClass;
			$odds_info->oddsType = "EXA";
			$odds_info->odds = $odds_datas[1];
			$arr_odds[] = $odds_info;
		}
	} else if($track_id == 3) { // Obihiro
		$odds_datas = explode(" ", trim($odds));
		$odds_datas = __process_odds_array($odds_datas);

		if($odds_type == 1){
			if(count($odds_datas) >= 2){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "TRI";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;	
			}			
		} else if($odds_type == 2){
			$odds_info = new \stdClass;
			$odds_info->oddsType = "EXA";
			$odds_info->odds = $odds_datas[0];
			$arr_odds[] = $odds_info;
		} else if($odds_type == 3){
			$odds_info = new \stdClass;
			$odds_info->oddsType = "QNL";
			$odds_info->odds = $odds_datas[0];
			$arr_odds[] = $odds_info;
		} else if($odds_type == 4){
			if(count($odds_datas) >= 3){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "PLC";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "Bracket";
				$odds_info->odds = $odds_datas[2];
				$arr_odds[] = $odds_info;
			}
		} else if($odds_type == 5){
			if(count($odds_datas) >= 2){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "TRO";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;	
			}
		} else if($odds_type == 6){
			if(count($odds_datas) >= 2){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "QNP";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;	
			}	
		}
	} else if($track_id == 21) { // Kawasaki
		$odds_datas = explode(" ", trim($odds));
		$odds_datas = __process_odds_array($odds_datas);

		if($odds_type == 1){
			if(count($odds_datas) == 3){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "Bracket QNL";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "Bracket EXA";
				$odds_info->odds = $odds_datas[2];
				$arr_odds[] = $odds_info;	
			}			
		} else if($odds_type == 2){
			if(count($odds_datas) == 2){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "TRO";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "TRI";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;
			}
		} else if($odds_type == 3){
			if(count($odds_datas) == 2){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "EXA";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;
			}
		} else if($odds_type == 4){
			if(count($odds_datas) == 2){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "WIN";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
				$odds_info = new \stdClass;
				$odds_info->oddsType = "PLC";
				$odds_info->odds = $odds_datas[1];
				$arr_odds[] = $odds_info;
			}
		} else if($odds_type == 5){
			if(count($odds_datas) <= 2){
				$odds_info = new \stdClass;
				$odds_info->oddsType = "QNL";
				$odds_info->odds = $odds_datas[0];
				$arr_odds[] = $odds_info;
			}
		}
	} else if($track_id == 27) {	// Sonoda
		$odds = str_replace("?", "7", $odds);
		$odds = str_replace("B", "8", $odds);
		$odds_datas = explode(" ", trim($odds));
		$odds_datas = __process_odds_array($odds_datas);

		if(count($odds_datas) == 5){
			$odds_info = new \stdClass;
			$odds_info->oddsType = "QNL";
			$odds_info->odds = $odds_datas[0];
			$arr_odds[] = $odds_info;
			$odds_info = new \stdClass;
			$odds_info->oddsType = "QNP";
			$odds_info->odds = $odds_datas[1];
			$arr_odds[] = $odds_info;
			$odds_info = new \stdClass;
			$odds_info->oddsType = "EXA";
			$odds_info->odds = $odds_datas[2];
			$arr_odds[] = $odds_info;
			$odds_info = new \stdClass;
			$odds_info->oddsType = "TRO";
			$odds_info->odds = $odds_datas[3];
			$arr_odds[] = $odds_info;
			$odds_info = new \stdClass;
			$odds_info->oddsType = "TRI";
			$odds_info->odds = $odds_datas[4];
			$arr_odds[] = $odds_info;
		}
	} else if($track_id == 22) {	// Kanazawa
		$odds = str_replace("?", "7", $odds);
		$odds = str_replace("B", "8", $odds);
		$odds_datas = explode(" ", trim($odds));
		$odds_datas = __process_odds_array($odds_datas);

		if(count($odds_datas) == 5){
			$odds_info = new \stdClass;
			$odds_info->oddsType = "QNL";
			$odds_info->odds = $odds_datas[0];
			$arr_odds[] = $odds_info;
			$odds_info = new \stdClass;
			$odds_info->oddsType = "QNP";
			$odds_info->odds = $odds_datas[1];
			$arr_odds[] = $odds_info;
			$odds_info = new \stdClass;
			$odds_info->oddsType = "EXA";
			$odds_info->odds = $odds_datas[2];
			$arr_odds[] = $odds_info;
			$odds_info = new \stdClass;
			$odds_info->oddsType = "TRO";
			$odds_info->odds = $odds_datas[3];
			$arr_odds[] = $odds_info;
			$odds_info = new \stdClass;
			$odds_info->oddsType = "TRI";
			$odds_info->odds = $odds_datas[4];
			$arr_odds[] = $odds_info;
		}
	}
	
	file_put_contents("odds_sum_".$track_id, json_encode($arr_odds));

	$ret = __get_race_datas();	
	$race_obj = __get_current_race($ret, $track_id);
	$curTime = GetCurrentJapanTimeStamp();
	if($race_obj){
		$race_obj->log_time = date("Y-m-d H:i:s", $curTime);
		$race_obj->odds = $arr_odds;
		file_put_contents(date("Ymd", $curTime)."_odds_sum_".$track_id.".log", json_encode($race_obj).",", FILE_APPEND | LOCK_EX);
	}
	$race_obj = new \stdClass;
	$race_obj->log_time = date("Y-m-d H:i:s", $curTime);
	$race_obj->odds = $arr_odds;
	file_put_contents(date("Ymd", $curTime)."_odds_sum_back_".$track_id.".log", json_encode($race_obj).",", FILE_APPEND | LOCK_EX);
} else if($c == 17){	// Save Live Video Position Data
	$track_id = 0;
	$pos = "";
	if(isset($_GET['track_id'])) $track_id = $_GET['track_id'];
	if(isset($_GET['pos'])) $pos = $_GET['pos'];
	if($track_id == 0) exit();
	file_put_contents("pos_data_".$track_id, $pos);
} else if($c == 18){	// Save Live Video Position Data
	$track_id = 0;
	if(isset($_GET['track_id'])) $track_id = $_GET['track_id'];
	if($track_id == 0) exit();
	echo @file_get_contents("pos_data_".$track_id);
}


?>