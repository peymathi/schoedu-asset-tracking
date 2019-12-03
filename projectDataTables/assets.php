<?php

session_start();
if (!isset($_SESSION['userid'])) Header ("Location:login.php") ;

?>

<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.7">
	<title>Assets</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="javascript/modal.js"></script>
	<script type="text/javascript" src="javascript/assets.js"></script>
	<script type="text/javascript" src="javascript/checkout.js"></script>

	<!-- Datatables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
</head>
<body>
	<div class="border">
		<div id="bg">
			background
		</div>
		<div class="page">
			<div class="sidebar" id="sidebar">
				<a href="index.php" id="logo"><img src="images/educationlogo.png" alt="logo"></a>
				<ul>
					<li>
						<a href="index.php">Home</a>
					</li>
					<li class="selected">
						<a href="assets.php">Manage Assets</a>
					</li>
					<li>
						<a href="reports.php">Reports</a>
					</li>
					<li>
						<a href="rental.php">Rental<br>Form</a>
					</li>
					<li>
						<a href="settings.php">Settings</a>
					</li>
					<li>
						<a href="logout.php">Logout</a>
					</li>

				</ul>
			</div>


			<!-- MENU ICON -->
			<div class="menu_toggle_container" onclick="menuToggle(this)">
				<div class="bar1"></div>
				<div class="bar2"></div>
				<div class="bar3"></div>

				<script>
					function menuToggle(x) {x.classList.toggle("change");document.getElementById("sidebar").classList.toggle("show_menu");document.getElementById("body").classList.toggle("show_menu");}
				</script>
			</div>


			<!-- The Modal -->
			<div class="modal">

			  <!-- Modal content -->
			  <div class="modal-content">
			    <span class="close">&times;</span>
					<h3><span>Edit Equipment</span></h3>

					<?php
						$doQty = false;
						$doSurplus = true;
						$extraClass = "editAsset";
						include("phpinc/equipmentFragment.php");
					?>

					<button id="editButton">Edit</button>
			  </div>

			</div>



			<div class="body" id="body">
				<div>
					<h2>
						Manage Assets
					</h2>
					<div>
						<h3><span>Add Equipment</span></h3>

						<?php
							$doQty = true;
							$doSurplus = false;
							$extraClass = "newAsset";
							include("phpinc/equipmentFragment.php");
						?>

						<button id="addButton">Add</button>

					</div>
					<br>
					<br>
					<div>
						<h3><span>Manage Devices</span></h3>



						<table class="dataTable display" style="width: 100%">
							<thead>
								<tr>
									<th style="width: 5em">Options</th>
									<th>Serial #</th>
									<th>Category</th>
									<th>Manufacturer</th>
									<th>Model #</th>
									<th>Location</th>
									<th>User</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
