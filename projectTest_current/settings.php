<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Project Test 3</title>
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
			<div class="sidebar">
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
				</ul>
			</div>
			<div class="body">
				<div>
					<h2>Settings</h2>
					<br />
					<div>
						<h3><span>Select a Setting</span></h3>
						<br />
						<div class="settingsForms">

							<!-- Radio buttons to select the currently active form -->
							<label for="toggleRadio">Toggle a Record From All Searches - </label>
							<input type="radio" name="formGroup" value="toggle" id="toggleRadio" checked>

							<label for="addRadio">Add a Record to Database - </label>
							<input type="radio" name="formGroup" value="add" id="addRadio">

							<label for="daysCheckedRadio">Change Days Since Checked - </label>
							<input type="radio" name="formGroup" value="daysChecked" id="daysCheckedRadio">

							<br />
							<br />
							<hr />
							<br />
							<h3><span id="currentSetting">Toggle a Record</span></h3>
							<div>
								<!-- Toggle Model, User, or Location Form -->
								<div id="toggleRecordForm">
									<form name="toggleRecordForm">

										<!-- Select whether it is a model, user, or location -->
										<select name="toggleRecordSelection" id="toggleRecordSelection">
											<option selected>- -</option>
											<option>Model</option>
											<option>User</option>
											<option>Location</option>
										</select>

										<!-- Select menu for models -->
										<select name="toggleModels" id="toggleModels" hidden>
											<option>Optiplex 5040 (shown)</option>
											<option>Optiplex 5050 (shown)</option>
											<option>Optiplex 7020 (shown)</option>
											<option>XPS 13 (shown)</option>
											<option>Latitude 7450 (shown)</option>
											<option>Latidude 7250 (shown)</option>
											<option>iMac (shown)</option>
											<option>MacAir (shown)</option>
											<option>MacPro (shown)</option>
											<option>MacBook (shown)</option>
										</select>

										<!-- Select menu for users -->
										<select name="toggleUsers" id="toggleUsers" hidden>
											<option>Dan Mullins (shown)</option>
											<option>Lori Yanef (shown)</option>
											<option>Allison Jessup (shown)</option>
										</select>

										<!-- Select menu for locations -->
										<select name="toggleLocations" id="toggleLocations" hidden>
											<option>SL 247 (shown)</option>
											<option>SL 251 (shown)</option>
											<option>IT 059 (shown)</option>
										</select>

										<button type="button" id="toggleSubmit" name="toggleSubmit">Toggle Record</button>

									</form>
								</div>

								<!-- Wrapper div to allow for hiding all the add forms -->
								<div id="addRecordForm" hidden>

									<!-- Radio buttons to select the currently active form -->
									<label for="manufacturerRadio">Add a Manufacturer - </label>
									<input type="radio" name="addFormsGroup" value="manufacturer" id="manufacturerRadio" checked>

									<label for="modelRadio">Add a Model - </label>
									<input type="radio" name="addFormsGroup" value="model" id="modelRadio">

									<label for="locationRadio">Add a Location - </label>
									<input type="radio" name="addFormsGroup" value="loation" id="locationRadio">

									<label for="userRadio">Add a User - </label>
									<input type="radio" name="addFormsGroup" value="user" id="userRadio">

									<br /><br />

									<!-- Add Manufacturer Form -->
									<div id="newManufacturerForm">
										<form name="newManufacturerForm" action="settings.php" method="post">
											<label for="newManufacturer">New Manufacturer:</label>
											<input type="text" name="newManufacturer">
											<button type="button" name="newManufacturerSubmit">Add Manufacturer</button>
										</form>
									</div>

									<!-- Add Model Form -->
									<div id="newModelForm" hidden>
										<form name="newModelForm" action="settings.php" method="post">
											<label for="newModel">New Model:</label>
											<input type="text" name="newModel">

											<label for="manufacturerSelect">Manufacturer</label>
											<select name="manufacturerSelect">
												<option>- -</option>
												<option>Apple</option>
												<option>Dell</option>
												<option>HP</option>
												<option>Canon</option>
												<option>Tandberg</option>
												<option>Logitech</option>
											</select>

											<button type="button" name="newModelSubmit">Add Model</button>
										</form>
									</div>

									<!-- Add Location Form -->
									<div id="newLocationForm" hidden>
										<form name="newLocationForm" action="settings.php" method="post">
											<label for="newLocation">New Location:</label>
											<input type="text" name="newLocation">
											<button type="button" name="newLocationSubmit">Add Location</button>
										</form>
									</div>

									<!-- Add User Form -->
									<div id="newUserForm" hidden>
										<form name="newUserForm" action="settings.php" method="post">
											<label for="newUser">New User:</label>
											<input type="text" name="newUser">
											<button type="button" name="newUserSubmit">Add User</button>
										</form>
									</div>
								</div>

								<!-- Change Days Checked Form -->
								<div id="changeDaysCheckedForm" hidden>
									<form name="changeDaysCheckedForm">

										<!-- Display current days checked filter -->
										<h4>Current Days Checked Filter: 30 Days</h4>
										<label for="newDaysChecked">New Days Checked Filter:</label>
										<input type="number" name="newDaysChecked">

										<button type="button" name="newDaysCheckedSubmit">Change Days Checked</button>
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
