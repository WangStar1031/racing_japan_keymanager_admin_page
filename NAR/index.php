<?php
	require_once('../assets/apis/common.inc.php');
?>
<script type="text/javascript" src="app/jquery-2.1.4.min.js"></script>
<p class="result" style="font-size: 24px;"></p>
<script type="text/javascript">
	function validate_number(str){
		str_num = parseInt(str);
		if(isNaN(str_num)) str_num = "Rest ...";
		//if((str_num * 1 < 1000) || (str_num * 1 > 1000000)) str_num = "Rest ...";
		return str_num;
	}
	setInterval(function(){
		jQuery.post("api_keiba_notice.php?c=15", {}, function(data){
			result = JSON.parse(data);
			ret_html = "";
			for(i=0; i<result.length; i++){
				ret_html += '<span style="font-weight: bold;">'+result[i].meeting_name+' </span><i style="text-decoration: underline; color: gray;"> Track ID: '+result[i].track_id+' </i><br><font color="gray" style="font-weight: bold;">R '+result[i].event_number+' ( '+result[i].time+' ) : </font> <font color="green" style="display: ;">'+result[i].odds_type+' '+validate_number(result[i].odds)+'</font><br>';				
			}
			jQuery(".result").html(ret_html);
		});
	}, 1000);
</script>