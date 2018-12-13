<?php
    require_once('../assets/apis/common.inc.php');
?>
<script type="text/javascript" src="app/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="app/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/broken-axis.js"></script>
<?php
	require_once("library/common_lib.php");

	$track_id = 0;
	$curTime = GetCurrentJapanTimeStamp();
	$date = date("Ymd", $curTime);
	if(isset($_GET['track_id'])) $track_id = $_GET['track_id'];
	if(isset($_GET['date'])) $date = $_GET['date'];

    $real_json = __generate_json_from_race($date, $track_id);
    $real_json = __preprocessing_json($real_json);
    //exit();
    $odds_data = [];
    $meeting_name = "";
    if(count($real_json)) $meeting_name = $real_json[0]->meeting;
    foreach ($real_json as $real_odds) {
        $oddsType = $real_odds->type;
        $oddsValue = $real_odds->value;
        $oddsTime = $real_odds->time + 9 * 3600;
        if(!isset($odds_data[$oddsType])) $odds_data[$oddsType] = [];
        $odds_data[$oddsType][$oddsTime] = $oddsValue;
    }
?>
<div id="chart-div"></div>
<script type="text/javascript">
Highcharts.chart('chart-div', {
    title: {
        text: 'NAR Live Chart ( <?=$meeting_name?> )'
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: 'Pool Data'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
	
	xAxis: [
 		{
 			type: "datetime",
			labels: {
 				format: "{value:%H:%M:%S}" 
			} 
		} 
	],

    series: [
    <?php
    	foreach($odds_data as $key => $value){
    ?>
    	{
        	name: '<?=$key?>',
            gapSize: 420,
        	data: [
        	<?php
                $initial_time = 0;
                $initial_value = 0;
      			foreach($value as $time => $time_val){
                    
                    if($initial_time != 0) {
                        if($time - $initial_time < 420) {
                            if($initial_value > $time_val) $time_val = $initial_value;
                            if($time_val > $initial_value * 3 && $initial_value > 10000) $time_val = $initial_value;
                        }
                    }
                    
                    $initial_time = $time;
                    $initial_value = $time_val;
      				echo '[ Date.UTC('.date('Y', $time).', '.(date('n', $time) - 1).', '.date('j, H, i, s', $time).'),'.$time_val.'],';
      			}
      		?>
        	]
    	},
    <?php
    	}
    ?>
    ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>