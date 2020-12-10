<?php require_once("../includes/database_functions.php"); ?>
<?php connect_to_database(); ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php 
	if(isset($_POST["submit"])){
		//process form data
		$menu_name = _mysql_prep($_POST["menu_name"]); 
		$position = (int)$_POST["position"];
		$visible = (int) $_POST["visible"];

		//validation
		$required_fields = ["menu_name", "position", "visible"];
		validate_persences($required_fields);
		$required_fields_with_max_len = ["menu_name"=>20];
		validate_max_lengths($required_fields_with_max_len);

		if(!empty($errors)){
			//validation failed
			$_SESSION["errors"] = $errors;
			redirect_to("new_subject.php");
		}

		$query  = "INSERT INTO subjects ";
		$query .="( menu_name, position, visible ) ";
		$query .= "VALUES ( '{$menu_name}', {$position}, {$visible} )";

		$result = mysqli_query($connection, $query);

		if($result){
			//successful
			$_SESSION["message"] = "Successfully Created Subject";
			redirect_to("manage_content.php");
		}
		else{
			//unsuccessfull
			$_SESSION["message"] = "Subject Creation failed";
			redirect_to("new_subject.php");
		}
	}
	else{
		//probably a GET request
		redirect_to("new_subject.php");
	}
?>

<?php close_database_connection(); ?>