<?php

	include('guzzle/autoload.php');
	include('simple_html_dom.php');

	function __get_values($__str_data, $__pre_pattern, $__post_pattern) {
	    $__pos = strpos($__str_data, $__pre_pattern);
	    if($__pos !== false){
	        $__str_data = substr($__str_data, $__pos + strlen($__pre_pattern));
	        $__pos = strpos($__str_data, $__post_pattern);
	        if($__pos !== false) {
	            return substr($__str_data, 0, $__pos);
	        } else 
	            return false;
	    } else
	    return false;
	}
	
	function __get_until_values($__str_data, $__post_pattern){
	    $__pos = strpos($__str_data, $__post_pattern);
	    if($__pos !== false)
	        return substr($__str_data, 0, $__pos);
	    return false;    
	}

	function __get_after_values($__str_data, $__post_pattern){
	    $__pos = strpos($__str_data, $__post_pattern);
	    if($__pos !== false)
	        return substr($__str_data, $__pos + strlen($__post_pattern));
	    return false;
	}

	function GetCurrentJapanTime()
	{
		return date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))-date("Z")+3600*9);
	}

	function GetCurrentJapanTimeStamp()
	{
		return strtotime( date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))-date("Z")+3600*9) );
	}

	function __call_safe_url_00($__url, $proxy = "") {
		$__url = str_replace("&amp;", "&", $__url);
		$body = "";
		try {
			$client = new GuzzleHttp\Client();
			if($proxy)
				$response = $client->request('GET', $__url, ['proxy' => "tcp://".$proxy]);
			else
				$response = $client->request('GET', $__url);
			$body = $response->getBody();
		} catch (GuzzleHttp\Exception\RequestException $e) {
			return "<html></html>";
		}
		return $body;
	}

	function __call_safe_url($__url, $proxy = "") {
		return __call_safe_url_00( $__url, $proxy );
	}

	function GetMeetingsFile($date = "")
	{
		$data = null;
		$now_time = GetCurrentJapanTime();

		if ($date == "") $date = date('Ymd', strtotime($now_time));
		if(file_exists($date.".meetings")) return @file_get_contents($date.".meetings");

		$url = "http://dw-staging-elb-1068016683.ap-southeast-2.elb".
			".amazonaws.com/api/meetings?filters[meeting_date]=$date&".
			"filters[countries][]=JPN";

		$data = @file_get_contents($url);
		file_put_contents($date.".meetings", $data);
		return $data;
	}

	function __get_nar_meeting_ids_00() {
	  $arr_meetings = array();
	  $meetings = GetMeetingsFile();

	  $now_time = GetCurrentJapanTime();
	  $date_str = date("Y-m-d", strtotime($now_time));

		$tracks = array(
			"Obihiro" => '03',
			"Morioka" => '10',
			"Mizusawa" => '11',
			"Urawa" => '18',
			"Funabashi" => '19',
			"Oi" => '20',
			"Kawasaki" => '21',
			"Kanazawa" => '22',
			"Kasamatsu" => '23',
			"Nagoya" => '24',
			"Sonoda" => '27',
			"Himeji" => '28',
			"Fukuyama" => '30',
			"Kochi" => '31',
			"Saga" => '32',
			"Arao" => '33',
			"Monbetsu" => '36',
		);
		
		$now_dtime = date("Ymd", strtotime(date("Y-m-d H:i:s"))-date("Z")+3600*9);
	  $arr_meetings['03'] = substr($now_dtime, 2);

	  $meetings_obj = json_decode($meetings, true);
	  $arr_data = $meetings_obj["data"]["meetings"];
	  foreach($arr_data as $meeting_detail){
	    if($meeting_detail["venue"]["host_market"] == "japan_nar"){
	    	$venue_name = $meeting_detail["venue"]["venue_name"];
	    	if(isset($tracks[$venue_name])){
	    		$venue_key = $tracks[$venue_name];
	    		$arr_meetings[$venue_key] = $meeting_detail["meeting_id"];
	    	}
	    }
	  }
	  return $arr_meetings;
	}

	function __get_last_values($__str_data, $__post_pattern){
	    $__pos = strrpos($__str_data, $__post_pattern);
	    if($__pos !== false)
	        return substr($__str_data, $__pos + strlen($__post_pattern));
	    return false;
	}

	function __get_nar_meeting_id($__arr_meetings, $__race_name) {
		if(strlen($__race_name) == 1) $__race_name = sprintf("%02d", $__race_name);
		if(isset($__arr_meetings[$__race_name]))
			return $__arr_meetings[$__race_name];
	  return "";
	}

	function __get_nar_meeting_name_00($__race_name) {
		$__race_name = sprintf("%02d", $__race_name);
		$__arr_meetings = array(
			'03' => "Obihiro",
			'10' => "Morioka",
			'11' => "Mizusawa",
			'18' => "Urawa",
			'19' => "Funabashi",
			'20' => "Oi",
			'21' => "Kawasaki",
			'22' => "Kanazawa",
			'23' => "Kasamatsu",
			'24' => "Nagoya",
			'27' => "Sonoda",
			'28' => "Himeji",
			'30' => "Fukuyama",
			'31' => "Kochi",
			'32' => "Saga",
			'33' => "Arao",
			'36' => "Monbetsu",
		);
		if(isset($__arr_meetings[$__race_name]))
			return $__arr_meetings[$__race_name];
	  return "";
	}

	function __remove_unicode($__str) {
		while(strpos($__str, "\\u") !== false){
			$__str_01 = __get_until_values($__str, "\\u");
			
			$__str_02 = substr($__str, strpos($__str, "\\u") + 12, strlen($__str) - strpos($__str, "\\u") - 12);
			
			$__str = $__str_01."1".$__str_02;
		}
		$__str = str_replace(" ", "", $__str);
		return $__str;
	}

	function __generate_json_from_race($date, $track_id) {
		$logs = "";
		if(file_exists("logs/backup/".$date."_odds_sum_".$track_id.".log"))
			$logs = @file_get_contents("logs/backup/".$date."_odds_sum_".$track_id.".log");
		else
			$logs = @file_get_contents($date."_odds_sum_".$track_id.".log");

		if($track_id == 22) { // Kanazawa Correction
			$logs = str_replace('oddsType":"QNP","odds":"11', 'oddsType":"QNP","odds":"4', $logs);
		}

		if($track_id == 24) {
			$pre_data = explode('"odds":"', $logs);
			for($i=1; $i<count($pre_data); $i++) {
				$pre_odds_val = __get_until_values($pre_data[$i], '"');
				$post_odds_val = __get_after_values($pre_data[$i], '"');
				$pre_odds_val = __remove_unicode($pre_odds_val).'"';
				$pre_data[$i] = $pre_odds_val.$post_odds_val;
			}
			$logs = implode('"odds":"', $pre_data);
		}

	    $arr_meeting = array("帯広ば" => "Obihiro", "門別" => "", "札幌" => "", "盛岡" => "", "水沢" => "Mizusawa", "浦和" => "Urawa", "船橋" => "Funabashi", "大井" => "Oi", "川崎" => "Kawasaki", "金沢" => "Kanazawa", "笠松" => "Kasamatsu", "名古屋" => "Nagoya", "中京" => "Chukyo", "園田" => "Sonoda", "姫路" => "", "高知" => "Kochi", "佐賀" => "Saga");

		$log_result = [];
		if($logs) $log_result = json_decode("[".$logs."{}]");
		
		$origin_type = "";
		$origin_event = "";

		$real_json = [];
		$new_odds_type = [];

		for($i=0; $i<count($log_result)-1; $i++){
			$race_obj = $log_result[$i];
			$odds = $race_obj->odds;
			foreach ($odds as $odds_value) {
				if(is_numeric($odds_value->odds))
				{
					$odd_type = (isset($odds_value->oddsType)?$odds_value->oddsType:"Default");
					if(isset($odds_value->oddsType) && (($track_id == 19) || ($track_id == 24) || ($track_id == 32)))
						if($origin_type != $odds_value->oddsType) {
							$origin_type = $odds_value->oddsType;
							continue;
						}

					if(isset($race_obj->event_number))
						if($origin_event != $race_obj->event_number) {
							$new_odds_type = [];
							$origin_event = $race_obj->event_number;
							continue;
						} else if(!in_array($odd_type, $new_odds_type)){
							$new_odds_type[] = $odd_type;
							continue;
						}

					$pool_data = new \stdClass;
					$pool_data->race_type = "NAR";
					$pool_data->meeting = $arr_meeting[$race_obj->meeting_name];
					$pool_data->event_number = $race_obj->event_number;
					$pool_data->race_time = $race_obj->time;				
					$pool_data->type = (isset($odds_value->oddsType)?$odds_value->oddsType:"");
					$pool_data->value = intval($odds_value->odds)."00";
					$pool_data->time = strtotime( $race_obj->log_time ) - 9 * 3600;

					$real_json[] = $pool_data;
				}
			}
		}

		usort($real_json, "cmp");

		return $real_json;
	}

	function cmp($a, $b)
	{
	    return $a->time > $b->time;
	}

	function __check_exist($obj, $arr) {
		foreach ($arr as $origin) {
			if(($origin->event_number == $obj->event_number) && ($origin->type == $obj->type))
			{
				return false;
			}
		}
		return true;
	}

	function __post_processing_json($arr_source, $check_obj) {
		$arr_process = [];
		for($i=0; $i<count($arr_source); $i++){
			$obj = $arr_source[$i];
			if(($check_obj->event_number == $obj->event_number) && ($check_obj->type == $obj->type)) {
				$arr_process[] = $obj;
			}
		}
		$process_pick = false;
		for($i=0; $i<count($arr_process)-1; $i++) {
			if(intval($arr_process[$i]->value) * 5 < intval($arr_process[$i + 1]->value) * 2) {
				if(intval($arr_process[$i]->value) > 100000)
					$arr_process[$i + 1]->value = $arr_process[$i]->value;
			} else if((intval($arr_process[$i]->value) * 2 < intval($arr_process[$i + 1]->value)) && (intval($arr_process[$i + 1]->value) - intval($arr_process[$i]->value) > 4000000)) {
				$arr_process[$i + 1]->value = $arr_process[$i]->value;
			} else if(intval($arr_process[$i]->value) > intval($arr_process[$i + 1]->value)) {
				$check_4_9 = false;
				if(substr($arr_process[$i]->value, 1) == substr($arr_process[$i + 1]->value, 1)) {
					if((substr($arr_process[$i]->value, 0, 1) == "9") && (substr($arr_process[$i + 1]->value, 0, 1) == "4"))
						$check_4_9 = true;
				}
				if($check_4_9) {
					$process_pick = true;
					$arr_process[$i]->value = $arr_process[$i + 1]->value;
				} else
					$arr_process[$i + 1]->value = $arr_process[$i]->value;
			}
		}
		while($process_pick) {
			$process_pick = false;
			for($i=0; $i<count($arr_process)-1; $i++) {
				if(intval($arr_process[$i]->value) > intval($arr_process[$i + 1]->value)) {
					$check_4_9 = false;
					if(substr($arr_process[$i]->value, 1) == substr($arr_process[$i + 1]->value, 1)) {
						if((substr($arr_process[$i]->value, 0, 1) == "9") && (substr($arr_process[$i + 1]->value, 0, 1) == "4"))
							$check_4_9 = true;
					}
					if($check_4_9) {
						$process_pick = true;
						$arr_process[$i]->value = $arr_process[$i + 1]->value;
					}
				} else {
					$check_4_9 = false;
					if(substr($arr_process[$i]->value, 1) == substr($arr_process[$i + 1]->value, 1)) {
						if((substr($arr_process[$i]->value, 0, 1) == "4") && (substr($arr_process[$i + 1]->value, 0, 1) == "9"))
							$check_4_9 = true;
					}
					if($check_4_9) {
						$process_pick = true;
						$arr_process[$i + 1]->value = $arr_process[$i]->value;
					}
				}
			}
		}
		return $arr_source;
	}

	function __preprocessing_json($arr_source) {
		$arr_check = [];
		foreach ($arr_source as $odds) {
			if(__check_exist($odds, $arr_check)) 
				$arr_check[] = $odds;
		}
		foreach ($arr_check as $check_obj) {
			$arr_source = __post_processing_json($arr_source, $check_obj);
		}

		return $arr_source;
	}

?>