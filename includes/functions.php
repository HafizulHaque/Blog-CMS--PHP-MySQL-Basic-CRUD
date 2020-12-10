<?php 
	
	function redirect_to($address){
		header("Location: {$address}");
		exit;
	}

	function find_selected_page(){
		global $current_subject;
		global $current_page;

		if(isset($_GET["subject"])){
			$current_subject = find_subject_by_id($_GET["subject"]);
			$current_page = null;
		}
		else if(isset($_GET["page"])){
			$current_subject = null;
			$current_page = find_page_by_id($_GET["page"]);
		}
		else{
			$current_subject = null;
			$current_page = null;
		}
	}

	//arg 1 is current_subject associative array
	//arg 2 is current_page associative array
	function make_navigation($current_subject, $current_page){

		$subject_set = find_all_subjects();
		$output = "<ul class=\"subjects\">";
		while($subject = mysqli_fetch_assoc($subject_set)){
		$output .= "<li ";
			if($current_subject && $subject["id"]==$current_subject["id"]){
				$output .= "class=\"selected\"";	
			}
			$output .= ">";
			$output .= "<a href=\"manage_content.php?subject=";
			$output .= urldecode($subject['id']);
			$output .= "\">";
			$output .= htmlentities($subject["menu_name"]);
			$output .= "</a>";
			$page_set = find_all_pages_for_subject($subject["id"]);
			$output .= "<ul class=\"pages\">";
			while($page = mysqli_fetch_assoc($page_set)){ 
			$output .= "<li ";
				if($current_page && $page["id"]==$current_page["id"]){
					$output .= "class=\"selected\"";
				}
				$output .= ">";
				$output .= "<a href=\"manage_content.php?page=";
				$output .= urldecode($page['id']);
				$output .= "\">";
				$output .= htmlentities($page["menu_name"]);
				$output .= "</a></li>";
			}
			mysqli_free_result($page_set);
			$output .= "</ul></li>";
		}
		mysqli_free_result($subject_set);
		$output .= "</ul>";

		return $output;
	}


	
	function form_errors($errors = array()){
		$output = "";

		if(!empty($errors)){
			$output = "<div class = \"error\">";
			$output .= "Please fix the following errors: <br/>";
			$output .= "<ul>";
			foreach($errors as $key => $value){
				$output .= "<li> {$value} </li>";
			}
			$output .= "</ul>";
			$output .= "<br/><br/></div>";
		}
		return $output;
	}


?>