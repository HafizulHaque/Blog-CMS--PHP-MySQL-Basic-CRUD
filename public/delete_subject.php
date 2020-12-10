<?php require_once("../includes/database_functions.php"); ?>
<?php connect_to_database(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php") ?>


<?php 
	$current_subject = find_subject_by_id($_GET["subject"]);

	if(!$current_subject){
		redirect_to("manage_content.php");
	}

	$page_set = find_all_pages_for_subject($current_subject["id"]);

	if(mysqli_num_rows($page_set)>0){
		$_SESSION["message"] = "Can't delete a subject with pages";
		redirect_to("manage_content.php?subject=". $current_subject['id']);
	}

	$id = $current_subject["id"];
	$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);

	if($result && mysqli_affected_rows($connection)==1){
		//success
		$_SESSION["message"] = "subject deleted successfully";
		redirect_to("manage_content.php");	
	}
	else{
		//failed
		$_SESSION["message"] = "Subject deletion failed";
		redirect_to("manage_content.php?subject={$id}");
	}

?>


<?php close_database_connection(); ?>