<?php require_once("../includes/database_functions.php"); ?>
<?php connect_to_database(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php") ?>
<?php find_selected_page(); ?>
<?php include("../includes/layouts/header.php"); ?>

	
<div id="main">

	<div id="navigation">
		<?php echo make_navigation($current_subject, $current_page); ?>
	</div>

	<div id="page">
		<?php echo show_msg(); ?>
		<?php echo form_errors(find_errors()); ?>
		<h2>Create Subject</h2>
		<form action="create_subject.php" method="post">
			<p>Menu Name:
				<input type="text", name="menu_name" value=""/>
			</p>
			<p>Position:
				<select name="position">
					<?php 
					 	$subject_set = find_all_subjects();
						$subject_count = mysqli_num_rows($subject_set);
						for($i = 1; $i <= ($subject_count+1); $i++){
							echo "<option value=\"{$i}\">{$i}</option>";
						}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="1"/>Yes
				&nbsp;
				<input type="radio" name="visible" value="0"/>No
			</p>
			<input type="submit" name="submit" value="Create Subject">
		</form>
		<br/>
		<a href="manage_content.php">Cancel</a>
	</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>
<?php close_database_connection(); ?>