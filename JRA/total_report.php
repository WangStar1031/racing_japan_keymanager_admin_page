<?php
	$events = glob(__DIR__ . "/logs/stewards/*.json");
	$cur_year = date("Y");
	$cur_month = date("n");
	if(isset($_POST["year"])) $cur_year = $_POST["year"];
	if(isset($_POST["month"])) $cur_month = $_POST["month"];
?>
<style type="text/css">
	a{text-decoration: none; color: green;}
	a:hover{color: red;}
	a{height: 24px; line-height: 24px;}
</style>
<h2>JRA Stewards Reports</h2>
<form method=post id="frmList" name="frmList">
<select name="year" id="year" onchange="javascript: frmList.submit();">
	<?php for($i=2017; $i<=date("Y"); $i++){?>
	<option value="<?=$i?>"<?php if($cur_year == $i) echo ' selected';?>><?=$i?></option>
	<?php }?>
</select>
/
<select name="month" id="month" onchange="javascript: frmList.submit();">
	<?php for($i=1; $i<=12; $i++){?>
	<option value="<?=$i?>"<?php if($cur_month == $i) echo ' selected';?>><?=$i?></option>
	<?php }?>
</select>
</form>
<?php
	foreach ($events as $event_data) {
		$json_date = str_replace( __DIR__ . "/logs/stewards/", "", $event_data);
		$event_date = substr( $json_date, 0, 10);//substr($json_date,0,4).'-'.substr($json_date,4,2).'-'.substr($json_date,6,2);
		if($cur_year != date("Y", strtotime($event_date))) continue;
		if($cur_month != date("n", strtotime($event_date))) continue;
		echo '<a href="'."logs/stewards/" . $event_date .'.json" target="_blank">Report ('.date("F jS, Y", strtotime($event_date)).')</a><br>';
	}
?>