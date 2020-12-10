<?php require_once("../includes/database_functions.php"); ?>
<?php connect_to_database(); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php") ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); ?>
	
<div id="main">
	<div id="navigation">
		<br/>
		<a href="admin.php">&laquo; Main Menu</a>
		<?php echo make_navigation($current_subject, $current_page); ?>
		<br/>
		<a href = "new_subject.php">+ Add New Subject</a>
	</div>

	<div id="page">
		<?php 
			echo show_msg();
		 ?>
		<?php if(isset($current_subject)){ ?>

			<h2>Manage Subject:<?php echo htmlentities($current_subject["menu_name"]); ?></h2>
			Menu Name: <?php echo htmlentities($current_subject["menu_name"]); ?><br/>
			Position: <?php echo $current_subject["position"]; ?><br/>
			Visible : <?php echo $current_subject["visible"]==1? "Yes": "No"; ?><br/><br/><br/>
			<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]);?>">Edit subject </a>
			<br/><br/><hr/><br/><h3>Pages in this Subject:</h3>
			<ul>
			<?php 
				$pages_of_current_subject = find_all_pages_for_subject($current_subject["id"]);
				while($page = mysqli_fetch_assoc($pages_of_current_subject)){
			?>
				<li><a href="manage_content.php?page=<?php echo $page["id"]; ?>"><?php echo $page["menu_name"];?></a></li>
			<?php
				}
			?>
			</ul><br/><br/>
			+<a href="new_page.php?subject=<?php echo urlencode($current_subject["id"]);?>">Add a new page to this Subject</a>


		<?php } else if(isset($current_page)){ ?> 

			<h2>Manage Page:<?php echo htmlentities($current_page["menu_name"]); ?></h2>
			Menu Name: <?php echo htmlentities($current_page["menu_name"]); ?><br/>
			Position: <?php echo $current_page["position"]; ?><br/>
			Visible : <?php echo $current_page["visible"]==1? "Yes": "No"; ?><br/><br/><br/>
			<div class="view-content">
				<?php echo htmlentities($current_page["content"]); ?>
			</div><br/><br/>
			<a href="edit_page.php?page=<?php echo $current_page["id"]; ?>">Edit Page</a>

		<?php } else{ ?>
			<h2>Manage Content</h2>
			Please select a subject or page.
		<?php } ?>
		
	</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>
<?php close_database_connection(); ?>