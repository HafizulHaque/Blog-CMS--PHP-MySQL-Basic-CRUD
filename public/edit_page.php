<?php require_once("../includes/database_functions.php"); ?>
<?php connect_to_database(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php find_selected_page(); ?>

<?php include("../includes/layouts/header.php"); ?>

<?php 
	if(!isset($current_page)){
		// request with no subject query string
		$_SESSION["message"] = "Error Editing page. Select a page update it.";
		redirect_to("manage_content.php");
	}
	if(isset($_POST["submit"])){
		// POST request with subjcect query string

		//validation
		$required_fields = ["menu_name", "position", "visible", "content"];
		validate_persences($required_fields);
		$required_fields_with_max_len = ["menu_name"=>20, "content"=>100];
		validate_max_lengths($required_fields_with_max_len);

		if(!empty($errors)){
			//validation failed
			$_SESSION["errors"] = $errors;
		}
		else{
			// processing
			$menu_name = _mysql_prep($_POST["menu_name"]); 
			$position = (int)$_POST["position"];
			$visible = (int) $_POST["visible"];
			$content = _mysql_prep($_POST["content"]);
			$id = (int) $current_page["subject_id"];
			$current_page_id = $current_page["id"];

			$query  = "UPDATE pages SET ";
			$query .= "position={$position}, ";
			$query .= "visible={$visible}, ";
			$query .= "subject_id={$id}, ";
			$query .= "content='{$content}', ";
			$query .= "menu_name='{$menu_name}' ";
			$query .= "WHERE id={$current_page_id} ";
			$query .= "LIMIT 1 ";

			$result = mysqli_query($connection, $query);

			if($result&& mysqli_affected_rows($connection)>=0){
				//successful
				$_SESSION["message"] = "Successfully updated Page";
				redirect_to("manage_content.php?page=".urlencode($current_page["id"]));
			}
			else{
				//unsuccessfull
				$_SESSION["message"] = "Page update failed. Check query";
				redirect_to("manage_content.php?page=".urldecode($current_page["id"]));
			}
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
		<h2>Edit Page:<?php echo $current_page["menu_name"]; ?></h2>
		<form action="edit_page.php?page=<?php echo urlencode($current_page["id"]);?>" method="post">
			<p>Menu Name:
				<input type="text", name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]); ?>"/>
			</p>
			<p>Position:
				<select name="position">
					<?php 
						$pages_for_this_sub = find_all_pages_for_subject($current_page["subject_id"]);
						$page_count = mysqli_num_rows($pages_for_this_sub);
						for($i=1; $i<=$page_count; $i++){
							echo "<option value=" . $i . "\"";
							if($i==$current_page["position"]){
								echo " selected";
							}
							echo ">" . $i . "</option>";
						}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="1" <?php if($current_page["visible"]==1) echo " checked"; ?> >Yes
				&nbsp;
				<input type="radio" name="visible" value="0" <?php if($current_page["visible"]==0) echo " checked"; ?> >No
			</p>
			<p>Content:<br/>
				<textarea name="content" rows="12" cols="100">
					<?php echo $current_page["content"]; ?>
				</textarea>
			</p>
			<input type="submit" name="submit" value="Update">
		</form>
		<br/>
		<a href="manage_content.php">Cancel</a>&nbsp;&nbsp;
		<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]);?>" onclick="return confirm('are you sure about this?');">Delete Page</a>
	</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>
<?php close_database_connection(); ?>