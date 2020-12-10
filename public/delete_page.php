<?php require_once("../includes/database_functions.php"); ?>
<?php connect_to_database(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php") ?>


<?php 

	if(!isset($_GET["page"])){
		$_SESSION["message"] = "Error deleting page.";
		redirect_to("manage_content.php");
	}

	$id = (int) $_GET["page"];
	$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection, $query);

	if($result && mysqli_affected_rows($connection)==1){
		//success
		$_SESSION["message"] = "Page deleted successfully";
		redirect_to("manage_content.php");	
	}
	else{
		//failed
		$_SESSION["message"] = "Page deletion failed";
		redirect_to("manage_content.php?page={$id}");
	}

?>


<?php close_database_connection(); ?>