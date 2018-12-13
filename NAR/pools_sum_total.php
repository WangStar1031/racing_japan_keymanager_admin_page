<?php
	require_once('../assets/apis/common.inc.php');

	require_once("library/common_lib.php");

	$tracks = array(
		18 => "Urawa",
		19 => "Funabashi",
		20 => "Oi",
		21 => "Kawasaki",
		22 => "Kanazawa",
		24 => "Nagoya",
		27 => "Sonoda",
		32 => "Saga",
		3 => "Obihiro",
	);

	$curTime = GetCurrentJapanTimeStamp();
	$cur_date = date("Y-m-d", $curTime);
	$date_diff = 10;

	if(isset($_GET['endDate'])) {
		$cur_date = date("Y-m-d", strtotime($_GET['endDate']));
		$start_date = date("Y-m-d", strtotime($_GET['startDate']));
		$date_diff = (strtotime($cur_date) - strtotime($start_date)) / 86400;
		$date_diff++;
	}

	function calc_class($n) {
		global $date_diff;

		$class_name = "";
		if($n < $date_diff - 4) $class_name = "min_3";
		if($n < $date_diff - 5) {
			if($class_name) $class_name .= " ";
			$class_name .= "min_4";	
		} 
		if($n < $date_diff - 7) {
			if($class_name) $class_name .= " ";
			$class_name .= "min_6";	
		} 
		if($n < $date_diff - 9) {
			if($class_name) $class_name .= " ";
			$class_name .= "min_7";	
		}
		if($n < $date_diff - 10) {
			if($class_name) $class_name .= " ";
			$class_name .= "min_9";	
		}

		return $class_name;
	}

	$kind = "html";
	if(isset($_GET["kind"])) $kind = $_GET["kind"];
	if($kind == "html") $post_url = "_html";
	else if($kind == "json") $post_url = "_json";
	else if($kind == "chart") $post_url = "";	
?>

<script type="text/javascript" src="app/jquery.min.js"></script>
<script type="text/javascript" src="app/moment.min.js"></script>
<script type="text/javascript" src="app/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="app/daterangepicker.css" />
<div id="reportrange" style="position: fixed; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width:200px;">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
</div>
<div style="width: 100%; height: 35px;"></div>
<script type="text/javascript">
var re_load = false;
$(function() {

    var start = moment("<?=$cur_date?>").subtract("<?=$date_diff-1?>", 'days');
    var end = moment("<?=$cur_date?>");

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        if(re_load) window.location.href = "pools_sum_total.php?startDate=" + start.format('YYYY-MM-DD') + '&endDate=' + end.format('YYYY-MM-DD');
        re_load = true;
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});
</script>
<style>
	table#tbl_data, #tbl_data td{border-collapse: collapse; border: solid 1px gray;}
	#tbl_data td{ padding: 5px; }
	#tbl_data a{text-decoration: none; font-size: 20px;}
	#tbl_data a:hover{color: red;}
	@media (max-width: 992px) {
		.min_9 {
			display: none;
		}
	}
	@media (max-width: 720px) {
		.min_7 {
			display: none;
		}
	}
	@media (max-width: 640px) {
		.min_6 {
			display: none;
		}
	}
	@media (max-width: 480px) {
		.min_4 {
			display: none;
		}
	}
	@media (max-width: 360px) {
		.min_3 {
			display: none;
		}
	}
	#tbl_data img{height: 25px;}
	#tbl_data img.small{height: 20px;}
</style>
<?php

	echo '<table id="tbl_data"><tr style="background-color: green; color: white; text-align: center;"><td>Tracks</td>';
	for($i=0; $i < $date_diff; $i++){
		$class_name = calc_class($i);
		$present_date = date("M jS", strtotime($cur_date) - ($date_diff - 1 - $i) * 86400);		
		echo '<td class="'.$class_name.'" style="min-width: 35px;">'.$present_date.'</td>';
	}
	echo '</tr>';
	foreach ($tracks as $track_id => $track_name) {
		echo '<tr><td style="background-color: #ccccff; text-align: center;">'.$track_name.'</td>';
		for($i=0; $i < $date_diff; $i++){
			$class_name = calc_class($i);
			$present_date_val = date("Ymd", strtotime($cur_date) - ($date_diff - 1 - $i) * 86400);
			if(file_exists($present_date_val."_odds_sum_".$track_id.".log") || file_exists("logs/backup/".$present_date_val."_odds_sum_".$track_id.".log"))
				echo '<td class="'.$class_name.'" style="text-align: center; min-width:110px;">
			<a href="pools_sum_history_json.php?track_id='.$track_id.'&date='.$present_date_val.'" target="_blank"><img class="small" src="../assets/images/icons/json.png" title="JSON Data"></a>
			<a href="pools_sum_history_html.php?track_id='.$track_id.'&date='.$present_date_val.'" target="_blank"><img class="small" src="../assets/images/icons/html5.png" title="HTML5 Data"></a> <br />
			<a href="pools_sum_history.php?track_id='.$track_id.'&date='.$present_date_val.'" target="_blank"><img src="../assets/images/icons/chart.png" title="Chart Data"></a>
			<a href="index.php" target="_blank"><img src="../assets/images/icons/live.png" title="LIVE Data"></a>
					</td>';
			else
				echo '<td class="'.$class_name.'"></td>';
		}
		echo '</tr>';
	}
	echo '</table>';
?>