<?php
	
	session_start();

	function __create_user_info($name, $pass) {
		$data = md5($pass, "65416");
		file_put_contents("assets/logins/user_".$name, $data);
	}

	function __validate_user_info($name, $pass) {
		global $_SESSION;

		$_SESSION["userIdx"] = "";
		$data = @file_get_contents("assets/logins/user_".$name);
		if(md5($pass, "65416") == $data){
			$_SESSION["userIdx"] = $name;
			return true;
		} 
		return false;
	}

?>