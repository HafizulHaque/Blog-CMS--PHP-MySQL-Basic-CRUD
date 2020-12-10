<?php require_once("../includes/database_functions.php"); ?>
<?php connect_to_database(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php find_selected_page(); ?>
<?php include("../includes/layouts/header.php"); ?>

<?php 
	if(!$current_subject){
		redirect_to("manage_content.php");
	}

	if(isset($_POST["submit"])){
		//validation
		$required_fields = ["menu_name", "position", "visible"];
		validate_persences($required_fields);
		$required_fields_with_max_len = ["menu_name"=>20];
		validate_max_lengths($required_fields_with_max_len);

		if(empty($errors)){
			// validation passed

			$menu_name = _mysql_prep($_POST["menu_name"]); 
			$position = (int)$_POST["position"];
			$visible = (int) $_POST["visible"];
			$subject_id = $current_subject["id"];

			$query  = "UPDATE subjects SET ";
			$query .= "position={$position}, ";
			$query .= "visible={$visible}, ";
			$query .= "menu_name='{$menu_name}' ";
			$query .= "WHERE id>={$subject_id} ";
			$query .= "LIMIT 1 ";

			$result = mysqli_query($connection, $query);

			if($result&&mysqli_affected_rows($connection)>=0){
				//successful
				$_SESSION["message"] = "Successfully updated Subject";
				redirect_to("manage_content.php");
			}
			else{
				//unsuccessfull
				$_SESSION["message"] = "Subject update failed";
				redirect_to("manage_content.php");
			}
			
		}
		else{
			//validation failed
			$_SESSION["errors"] = $errors;
		}
	}
?>
	
<div id="main">

	<div id="navigation">
		<?php echo make_navigation($current_subject, $current_page); ?>
	</div>

	<div id="page">
		<?php echo show_msg(); ?>
		<?php echo form_errors(find_errors()); ?>
		<h2>Edit Subject: <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
		<form action="edit_subject.php?subject=<?php echo htmlentities($current_subject["id"]);?>" method="post">
			<p>Menu Name:
				<input type="text", name="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]); ?>"/>
			</p>
			<p>Position:
				<select name="position">
					<?php 
					 	$subject_set = find_all_subjects();
						$subject_count = mysqli_num_rows($subject_set);
						for($i = 1; $i <= ($subject_count+1); $i++){
							echo "<option value=\"{$i}\" ";
							if($current_subject["position"]==$i){
								echo "selected";
							}
							echo ">{$i}</option>";
						}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="1" <?php if($current_subject["visible"]==1) echo " checked"?>/>Yes
				&nbsp;
				<input type="radio" name="visible" value="0" <?php if($current_subject["visible"]==0) echo " checked"?>/>No
			</p>
			<input type="submit" name="submit" value="Edit Subject">
		</form>
		<br/>
		<a href="manage_content.php">Cancel</a>&nbsp;&nbsp;
		<a href="delete_subject.php?subject=<?php echo htmlentities($current_subject["id"]); ?>" onclick="return confirm('are you sure about this?');">Delete subject</a>
	</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>
<?php close_database_connection(); ?>