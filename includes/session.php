<?php 
	session_start();

	function show_msg(){
		$res = "";
		if(isset($_SESSION["message"])){
			$res .= "<div class=\"message\">";
			$res .= htmlentities($_SESSION["message"]);
			$res .= "</div>";
		}
		$_SESSION["message"] = null;
		return $res;
	}

	function find_errors(){
		$err = null;
		if(isset($_SESSION["errors"])){
			$err = $_SESSION["errors"];
		}
		$_SESSION["errors"] = null;
		return $err;
	}
	
?>