<?php 

	function connect_to_database(){
		global $connection;
		define("DB_HOST", "localhost");
		define("DB_USER", "widget_cms");
		define("DB_PASS", "shanto97");
		define("DB_NAME", "widget_corp");

		$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		if(mysqli_connect_errno()){
			// database connection error
			die("some error occured".mysqli_connect_error());
		}
	}

	function close_database_connection(){
		global $connection;
		if(isset($connection)){
			mysqli_close($connection);	
		}
	}

	function confirm_query($result_set){
		if(!$result_set){
			die("database query failed");
		}
	}

	function _mysql_prep($string){
		global $connection;
		$edcaped_string = trim($string);
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}


	function find_all_subjects(){
		global $connection;
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		// $query .= " WHERE visible=1 ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		return $subject_set;
	}

	function find_all_pages_for_subject($subject_id){
		global $connection;
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		// $query .= "WHERE visible=1 ";
		$query .= "WHERE subject_id={$subject_id} ";
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		return $page_set;
	}

	function find_subject_by_id($subject_id){
		global $connection;
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id={$safe_subject_id} ";
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		if($subject = mysqli_fetch_assoc($subject_set)){
			return $subject;
			// an assciative array
		}
		else{
			return null;
		}
	}

	function find_page_by_id($page_id){
		global $connection;
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id={$safe_page_id} ";
		$query .= "LIMIT 1";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		if($page = mysqli_fetch_assoc($page_set)){
			return $page;
			// an associative array
		}
		else{
			return null;
		}
	}

?>