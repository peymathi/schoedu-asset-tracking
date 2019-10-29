<?php
session_start();
if (!isset($_SESSION['userid'])) Header ("Location:login.php") ; 
	require_once "phpinc/dbconnect.php";

?>


<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Rental Page</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="javascript/rental.js"></script>
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
					<li class="selected">
						<a href="rental.php">Rental<br>Form</a>
					</li>
					<li>
						<a href="settings.php">Settings</a>
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
						Rental Form
					</h2>

					<div id="rental_div">
						<br>
						<br>
						<form onsubmit="return false" class="rental_form" method="get">
							<label for="name">Name:</label>
							<input type="text" id="name">
							<br>

							<label style="padding: 6px 0" for="email">Email:</label>
							<input type="text" id="email">
							<br>

							<label for="purpose">Purpose:</label>
							<select name="purpose">
								<option>Faculty Use for Class</option>
								<option>Faculty Use for Meeting</option>
								<option>Staff Use for Work at Home</option>
								<option>Staff Use for Meeting</option>
							</select>

							<br>
							<br>
							<br>

							<label>Equipment:</label>
							<br>

							<select onchange="checkState(1);showOptions('brand');" name="category1">
								<option hidden>Category</option>
								<?php print GetCategory(); ?>
							</select>

							<select onclick="showOptions('model')" onchange="showOptions('model')" disabled name="brand1">
								<option hidden>Brand</option>
							</select>
								
							<select onclick="showOptions('');" disabled name="model1">
								<option hidden>Model</option>
							</select>

							<label>&nbsp&nbspSerial:</label>
							<input list="serial" onkeyup="showOptions(this.value)" disabled type="text" name="serial1">

							<datalist id="serial"></datalist>

							<br>
							<br>

							<button onclick="addDeviceBtn()" id='addDevice'>Add Device</button>

							<br>
							<br>
							<br>

							<label>Rental Date:</label>
							<input type="date" name="loanDate">
							<br>
							<label style="padding-top: 6px">Return Date:</label>
							<input type="date" name="returnDate">

							<p id='rentalTerms'>
								I understand that the following conditions will apply to all equipment:
								<br>a. It will only be used by me for school related activity;
								<br>b. I assume liability for damage or theft and will be responsible for the repair or replacement costs
								of each item (I will consult my personal homeowners or auto insurance coverage policies);
								<br>c. I will not store any confidential or sensitive information as defined by the IU Security Office
								policy on the equipment, http://protect.iu.edu/cybersecurity/data ;
								<br>d. I will report the loss or theft of the equipment immediately to Education Technology Services;
								<br>e. I will exercise reasonable care in its transport and use;
								<br>f. I will return the equipment on the agreed Return Date/Time indicated above OR immediately
								prior to terminating employment with IU School of Education at IUPUI OR upon the request of
								Education Technology Services.
								<br>
								<br>
								<br>
								Rentee Signature: ____________________________________________

								Date: ____/____/____


								<br>
								<br>
								APPROVAL: _________________________________________________
								Date: ____/____/____
							</p>


							<br>
							<br>
							<br>

							<button id="rental_submit" onclick="printFunction()" type="submit">Print</button>

							<button id="rental_scan" style="margin-left: 6px" type="submit">Scan</button>



							<script>
							function printFunction() {
							  window.print();
							}
							</script>
						</form>


						
					</div>
					
						
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?php

function GetCategory()
{
	$res = "";
	global $con;
	$sql = $con->prepare("select Name from P_CATEGORIES order by Name");
	$sql->execute();
	$result = $sql->fetchAll();

	foreach ($result as $row)
	{ 
		$res = $res.'<option value = "'.$row['Name'].'">'.$row['Name'].'</option>';

	}

	return $res;
}

?>
