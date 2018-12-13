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
	
	echo '<table>';

	foreach ($real_json as $odds_data) {
		echo '
				<tr>
					<td>'.$odds_data->meeting.' <font color=green>R '.$odds_data->event_number.' => '.$odds_data->race_time.'</font></td>
					<td style="border: solid 1px gray; padding: 3px;">'.date("H:i:s", $odds_data->time + 9 * 3600).'</td>
					<td style="color: blue; padding-left: 10px;">'.(isset($odds_data->type)?$odds_data->type:"").'</td>
					<td style="padding-left:10px; text-align:right">'.$odds_data->value.'</td>
				</tr>
				';
	}

	echo '</table>';

?>