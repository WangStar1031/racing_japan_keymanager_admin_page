<?php

	require_once("assets/apis/common.lib.php");

	if(isset($_GET["name"]) && isset($_GET["pass"]) && ($_GET["name"]) && ($_GET["pass"]))
		__create_user_info($_GET["name"], $_GET["pass"]);
?>