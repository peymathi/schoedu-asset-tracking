<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Project Test 3</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="javascript/sorttable.js"></script>
</head>
<body>
	<div class="border">
		<div id="bg">
			background
		</div>
		<div class="page">
			<div class="sidebar">
				<a href="index.html" id="logo"><img src="images/educationlogo.png" alt="logo"></a>
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
				</ul>
			</div>
			<div class="body">
				<div>
					<h2>Manage Assets<img id="menu_icon" title="Show Menu" alt="show menu icon" src="images/hamburgerIcon.svg"></h2>
					<div>
						<h3><span>Add Equipment</span></h3>

						<select name="category">
							<option hidden>Category</option>
							<option>Desktop</option>
							<option>Tablet</option>
						</select>

						<select name="brand">
							<option hidden>Brand</option>
							<option>Dell</option>
							<option>Apple</option>
						</select>
							
						<select name="model">
							<option hidden>Model</option>
							<option>123</option>
							<option>456</option>
						</select>

						<select name="user">
							<option hidden>User</option>
							<option>Dr. A</option>
							<option>Prof. B</option>
						</select>

						<select name="location">
							<option hidden>Location</option>
							<option>SL 247</option>
							<option>Sl 251</option>
						</select>

						<br>
						<br>

						Purchased:<input type="date" name="purchaseDate">

						&nbsp&nbsp Warrenty:<input type="number" name="warrenty" min="0">&nbspyears

						&nbsp&nbsp Qty: <input type="number" name="qty" min='1' max='99'>

						<br>
						<br>

						Network ID:<input type="text" name="networkID">

						Serial#:<input type="text" name="serial">

						Notes:<input type="text" name="notes">

						<br>

						<button>Add</button>

					</div>
					<br>
					<br>
					<div>
						<h3><span>Manage Devices</span></h3>
						<form>
							<select id="searchFilter">
								<option>All</option>
								<option>Serial</option>
								<option>Location</option>
								<option>Category</option>
							</select>
						    <input type="text" placeholder="Search.." name="search">
							<button type="submit"><i class="fa fa-search"></i></button>
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>