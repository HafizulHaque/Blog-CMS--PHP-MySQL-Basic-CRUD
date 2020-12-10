<?php require_once("../includes/database_functions.php"); ?>
<?php connect_to_database(); ?>
<?php include("../includes/layouts/header.php"); ?>

<?php 
	$subject_id = null;
	$page_id = null;
	if(isset($_GET["subject"])){
		$subject_id = $_GET["subject"];
	}
	else if(isset($_GET["page"])){
		$page_id = $_GET["page"];
	}
?>
	
<div id="main">

	<div id="navigation">

	</div>

	<div id="page">
		<h2>Admin Area</h2>
		Welcome to the Admin Area
		<br/><br/>
		<ul>
			<li><a href="manage_content.php">Manage Website Content</a></li>
			<li><a href="#">Manage Admin Users</a></li>
			<li><a href="#">Logout</a></li>

		</ul>
		
	</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>
<?php close_database_connection(); ?>