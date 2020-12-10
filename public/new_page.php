<?php require_once("../includes/database_functions.php"); ?>
<?php connect_to_database(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php find_selected_page(); ?>

<?php include("../includes/layouts/header.php"); ?>

<?php 
	if(!isset($current_subject)){
		// request with no subject query string
		$_SESSION["message"] = "Error creating page. Select a subject to create page under it.";
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
			$id = (int) $current_subject["id"];

			$query  = "INSERT INTO pages ";
			$query .="( menu_name, position, visible, subject_id, content ) ";
			$query .= "VALUES ( '{$menu_name}', {$position}, {$visible}, {$id}, '{$content}' )";

			$result = mysqli_query($connection, $query);

			if($result){
				//successful
				$_SESSION["message"] = "Successfully Created Page";
				redirect_to("manage_content.php?subject=".urlencode($current_subject["id"]));
			}
			else{
				//unsuccessfull
				$_SESSION["message"] = "Page Creation failed. Check query";
				redirect_to("manage_content.php?subject=".urldecode($current_subject["id"]));
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
		<h2>Create Page</h2>
		<form action="new_page.php?subject=<?php echo urlencode($current_subject["id"]);?>" method="post">
			<p>Menu Name:
				<input type="text", name="menu_name" value=""/>
			</p>
			<p>Position:
				<select name="position">
					<?php 
						$pages_for_this_sub = find_all_pages_for_subject($current_subject["id"]);
						$page_count = mysqli_num_rows($pages_for_this_sub);
						for($i=1; $i<=$page_count+1; $i++){
							echo "<option value=" . $i . "\"";
							if($i>$page_count){
								echo " selected";
							}
							echo ">" . $i . "</option>";
						}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="1" checked>Yes
				&nbsp;
				<input type="radio" name="visible" value="0">No
			</p>
			<p>Content:<br/>
				<textarea name="content" rows="12" cols="100">
				</textarea>
			</p>
			<input type="submit" name="submit" value="Create Page">
		</form>
		<br/>
		<a href="manage_content.php">Cancel</a>
	</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>
<?php close_database_connection(); ?>