<?php

	$dir = dirname($_SERVER['SCRIPT_FILENAME']);

	$cur_time = date("H:i", time()-date("Z")+3600*9);
	if($cur_time != "22:00") exit();

	function check_dir($dir) { 

	   if (is_dir($dir)) { 
	     $objects = scandir($dir); 
	     foreach ($objects as $file) { 
	     	if ($file != "." && $file != ".." && $file != "logs") { 
          			if(is_numeric(substr($file, 0, 1))){
          				if(@file_get_contents("logs/backup/".$file)){
							file_put_contents("logs/backup/".$file.".".time(), @file_get_contents($file));
          				} else {
	          				file_put_contents("logs/backup/".$file, @file_get_contents($file));
	          			}
          				unlink($file);
				    }
				}
			}
	   } 
	 }

	 check_dir($dir);

?>