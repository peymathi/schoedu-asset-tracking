<?php

session_start();
if (!isset($_SESSION['userid'])) Header ("Location:login.php") ;

if(!isset($_SESSION['timeout']))  Header ("Location:logout.php") ;
else 
	if ($_SESSION['timeout'] + 1 * 3600 < time()){
		Header ("Location:logout.php") ;
	}

	else {
		$_SESSION['timeout'] = time();
	}


?>

<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.8">
	<title>Settings</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="javascript/sorttable.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
					<li>
						<a href="assets.php">Manage Assets</a>
					</li>
					<li>
						<a href="reports.php">Reports</a>
					</li>
					<li>
						<a href="rental.php">Rental<br>Form</a>
					</li>
					<li class="selected">
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


			<div class="body" id="body">
				<div>
					<h2>
						Settings
					</h2>
					<br />
					<div>
						<h3><span>Select a Setting</span></h3>
						<br />
						<div class="settingsForms">

							<!-- Radio buttons to select the currently active form -->
							<label for="toggleRadio">Edit Records - </label>
							<input type="radio" name="formGroup" value="toggle" id="toggleRadio" checked>

							<label for="addRadio">Add a Record to Database - </label>
							<input type="radio" name="formGroup" value="add" id="addRadio">

							<label for="daysCheckedRadio">Other Settings - </label>
							<input type="radio" name="formGroup" value="daysChecked" id="daysCheckedRadio">

							<br />
							<br />
							<hr />
							<br />
							<h3><span id="currentSetting">Edit a Record</span></h3>
							<div>
								<!-- Toggle Model, User, or Location Form -->
								<div id="toggleRecordForm">
									<form name="toggleRecordForm">

										<!-- Select whether it is a model, user, or location -->
										<select name="toggleRecordSelection" id="toggleRecordSelection">
											<option selected>- -</option>
											<option>Category</option>
											<option>Manufacturer</option>
											<option>Model</option>
											<option>User</option>
											<option>Location</option>
										</select>

										<select name="toggleCategories" id="toggleCategories" hidden>
											<option>- -</option>
										</select>

										<select name="toggleManufacturers" id="toggleManufacturers" hidden>
											<option>- -</option>
										</select>

										<!-- Select menu for models -->
										<select name="toggleModels" id="toggleModels" hidden>
											<option>- -</option>
										</select>

										<!-- Select menu for users -->
										<select name="toggleUsers" id="toggleUsers" hidden>
											<option>- -</option>
										</select>

										<!-- Select menu for locations -->
										<select name="toggleLocations" id="toggleLocations" hidden>
											<option>- -</option>
										</select>

										<br><br>

										<button type="button" id="toggleSubmit" name="toggleSubmit">Toggle Record Visibility</button>

										<br><br>

										<input type="text" name="" value="" id="editNameBox">

										<button type="button" id="editSubmit" name="editSubmit">Edit Record Name</button>

										<br><br>

										<div id="editModel" style="margin: 0px" hidden>
											<select name="modelCategorySelect" id="modelCategorySelect">
												<option>- -</option>
											</select>

											<select name="modelManufacturerSelect" id="modelManufacturerSelect">
												<option>- -</option>
											</select>

											<button type="button" id="editModelSubmit" name="editModelSubmit">Edit Model Information</button>
										</div>

										<div id="editManufacturer" style="margin: 0px" hidden>
											<label for="editWarranty">Warranty:</label>
											<input type="number" class="minZero" id="editWarranty" name="editWarranty" value="" min="0">

											<button type="button" id="editManufacturerSubmit" name="editManufacturerSubmit">Edit Manufacturer Information</button>
										</div>

									</form>
								</div>

								<!-- Wrapper div to allow for hiding all the add forms -->
								<div id="addRecordForm" hidden>

									<!-- Radio buttons to select the currently active form -->
									<label for="categoryRadio">Add a Category - </label>
									<input type="radio" name="addFormsGroup" value="category" id="categoryRadio" checked>

									<label for="manufacturerRadio">Add a Manufacturer - </label>
									<input type="radio" name="addFormsGroup" value="manufacturer" id="manufacturerRadio">

									<label for="modelRadio">Add a Model - </label>
									<input type="radio" name="addFormsGroup" value="model" id="modelRadio">

									<label for="locationRadio">Add a Location - </label>
									<input type="radio" name="addFormsGroup" value="loation" id="locationRadio">

									<label for="userRadio">Add a User - </label>
									<input type="radio" name="addFormsGroup" value="user" id="userRadio">

									<br /><br />

									<!-- Add Manufacturer Form -->
									<div id="newCategoryForm">
										<form name="newCategoryForm">
											<label for="newCategory">New Category:</label>
											<input type="text" id="newCategory" name="newCategory">
											<button type="button" id="newCategorySubmit" name="newCategorySubmit">Add Category</button>
										</form>
									</div>

									<!-- Add Manufacturer Form -->
									<div id="newManufacturerForm" hidden>
										<form name="newManufacturerForm">
											<label for="newManufacturer">New Manufacturer:</label>
											<input type="text" id="newManufacturer" name="newManufacturer">

											<br><br>

											<label for="warranty">Warranty:</label>
											<input type="number" class="minZero" id="warranty" name="warranty" min="0" value="0">

											<br><br>

											<button type="button" id="newManufacturerSubmit" name="newManufacturerSubmit">Add Manufacturer</button>
										</form>
									</div>

									<!-- Add Model Form -->
									<div id="newModelForm" hidden>
										<form name="newModelForm" action="phpinc/processSettings.php" method="post">
											<label for="newModel">New Model:</label>
											<input type="text" id="newModel" name="newModel">

                      <br><br>

											<label for="categorySelect">Category</label>
											<select id="categorySelect" name="categorySelect">
												<option>- -</option>
											</select>

                      <br><br>

											<label for="manufacturerSelect">Manufacturer</label>
											<select id="manufacturerSelect" name="manufacturerSelect">
												<option>- -</option>
											</select>

                      <br><br>

											<button type="button" id="newModelSubmit" name="newModelSubmit">Add Model</button>
										</form>
									</div>

									<!-- Add Location Form -->
									<div id="newLocationForm" hidden>
										<form name="newLocationForm" action="settings.php" method="post">
											<label for="newLocation">New Location:</label>
											<input type="text" id="newLocation" name="newLocation">
											<button type="button" id="newLocationSubmit" name="newLocationSubmit">Add Location</button>
										</form>
									</div>

									<!-- Add User Form -->
									<div id="newUserForm" hidden>
										<form name="newUserForm">
											<label for="newUser">New User:</label>
											<input type="text" id="newUser" name="newUser">
											<button type="button" id="newUserSubmit" name="newUserSubmit">Add User</button>
										</form>
									</div>
								</div>

								<!-- Change Days Checked Form -->
								<div id="changeDaysCheckedForm" hidden>
									<form name="changeDaysCheckedForm">

										<!-- Display current days checked filter -->
										<h4>Current Days Checked Filter: <span id="currentDaysChecked">??</span> Days</h4>
										<label for="newDaysChecked">New Days Checked Filter:</label>
										<input type="number" class="minZero" id="newDaysChecked" name="newDaysChecked" min="0">

										<button type="button" id="newDaysCheckedSubmit" name="newDaysCheckedSubmit">Change Days Checked</button>
									</form>
									<br>
									<form name="hideSurplusForm">
										<h4>Surplus Visibility: <span id="currentSurplus">??</span></h4>
										<label for="newSurplus">Hide Surplus:</label>
										<input type="checkbox" id="newSurplus" name="newSurplus">
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="javascript/settings.js"></script>
</body>
</html>
