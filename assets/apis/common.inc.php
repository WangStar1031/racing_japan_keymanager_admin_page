<?php

	session_start();

	if(!(isset($_SESSION['userIdx']) && ($_SESSION['userIdx']))) {
?>
<script type="text/javascript">top.location.href = "/";</script>
<?php
		exit();
	}
?>