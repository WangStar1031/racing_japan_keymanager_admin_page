<?php

	$data = @file_get_contents("http://keiba-lv-st.jp/api/TodayRaceInfo.php?target=now");
	$ret = json_decode( $data );
	echo json_encode( $ret );

?>