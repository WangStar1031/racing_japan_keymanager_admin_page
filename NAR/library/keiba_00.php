<?php

	include('common_lib.php');

	$__root_url_00 = "http://www2.keiba.go.jp";
	$__proc_url_00 = "http://www2.keiba.go.jp/KeibaWeb/TodayRaceInfo/TodayRaceInfoTop";

	function __regen_race_id_from_href($href_val){
		$now_time = GetCurrentJapanTime();
		$str = date("Ymd", strtotime($now_time));
		$str .= sprintf("%02d", __get_last_values($href_val, "k_babaCode="));
		return $str;
	}

	function __get_race_datas($proc_date="") {
		$now_time = GetCurrentJapanTime();
		$file_name = date("Ymd", strtotime($now_time))."_keiba_00.json";

		if(($proc_date != "") && ($proc_date != date("Ymd", strtotime($now_time)))){
			$results = array();

			$file_name = "logs/backup/".$proc_date."_keiba_00.json";
			if(file_exists($file_name))
				return json_decode(@file_get_contents($file_name));

			return $results;
		}
		
		if(file_exists($file_name) && (filemtime($file_name) + 100 > time())){
			$results = json_decode(@file_get_contents($file_name));
		} else {		
			$arr_meetings = __get_nar_meeting_ids_00();

			$results = array();
			$tracks = __get_odds_track();
			for($i=0; $i<count($tracks); $i++){
				$track_obj = $tracks[$i];
				$track_info = __get_track_info($track_obj->track_href);
				$track_info->race_id = $track_obj->race_id;
				$track_info->track_name = $track_obj->track_name;
				$track_info->meeting_id = __get_nar_meeting_id($arr_meetings, $track_info->race_id);
				$track_info->meeting_name = __get_nar_meeting_name_00($track_info->race_id);
				array_push($results, $track_info);
			}

			file_put_contents($file_name, json_encode( $results ));
		}

		return $results;
	}

	function __get_odds_track() {
		global $__root_url_00, $__proc_url_00;

		$ret = array();
		$__result = __call_safe_url($__proc_url_00);
		$ret_html = str_get_html($__result);
		if($ret_html){
	  		$arr_tracks = $ret_html->find('.courseInfo .course td');
	  		if(count($arr_tracks) < 3) return $ret;
	  		$info_track = $arr_tracks[2];
			$track_html = str_get_html($info_track->innertext);
			$tracks_array = $track_html->find('a.courseName');
			foreach ($tracks_array as $track_item) {
				$track_obj = new \stdClass;
				$track_obj->track_name = $track_item->innertext;
				$track_obj->race_id = __get_last_values($track_item->href, "=");
				$track_obj->track_href = $__root_url_00.$track_item->href;
				array_push($ret, $track_obj);
			}
		}
		return $ret;
	}

	function __get_track_info($__race_href) {
		global $__root_url_00;

		$race_obj = new \stdClass;
		$ret = array();
		$__result = __call_safe_url($__race_href);
		$ret_html = str_get_html($__result);
		if($ret_html){
	  		$arr_races = $ret_html->find('.raceTable tr.data');
			foreach($arr_races as $info_race) {
				$race_html = str_get_html($info_race->innertext);
				$race_datas = $race_html->find('td');
				if(count($race_datas) < 9) continue;
				$track_obj = new \stdClass;
				$track_obj->id = trim(str_replace("R", "", $race_datas[0]->innertext));
				$track_obj->race_id = $track_obj->id;
				$race_name_html = str_get_html( $race_datas[4]->innertext );
				$track_obj->name = trim($race_name_html->find('a', 0)->innertext);
				if(substr($race_name_html->find('a', 0)->href, 0, 2) == "..")
					$track_obj->href = "http://www2.keiba.go.jp/KeibaWeb".substr($race_name_html->find('a', 0)->href,2);
				else
					$track_obj->href = $__root_url_00.$race_name_html->find('a', 0)->href;
				if(__get_values($race_datas[1]->innertext, '<span class="timechange">', '</span>'))
					$track_obj->time = trim(__get_values($race_datas[1]->innertext, '<span class="timechange">', '</span>'));
				else
					$track_obj->time = trim($race_datas[1]->innertext);
				/*if(trim($race_datas[2]->innertext) != '<span class="timechange"></span>') {
					$track_obj->time = str_get_html(trim($race_datas[2]->innertext))->innertext;
				}*/
				$track_obj->count = trim($race_datas[8]->innertext);
				if($track_obj->count) array_push($ret, $track_obj);
			}
		}
		$race_obj->races = $ret;
		return $race_obj;
	}

?>