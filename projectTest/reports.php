<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Project Test 3</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="javascript/sorttable.js"></script>
</head>
<?php

// Set up variable data
$manufacturer = "";
$category = "";
$model = "";
$location = "";
$user = "";
$surplus = "";
$expired = "";
$filterTitle = "All Assets (No Surplus)";

// Check if we need to process form data
if (isset($_GET['manufacturer']))
{
	$filterTitle = "Current Filters - ";

	// Get the form data
	$manufacturer = $_GET['manufacturer'];
	$category = $_GET['category'];
	$model = $_GET['model'];
	$location = $_GET['location'];
	$user = $_GET['user'];

	// Filter the data and add to filter title string
	if ($manufacturer != "- -")
	{
		$filterTitle .= "Manufacturer: " . $manufacturer . ", ";
	}

	if ($category != "- -")
	{
		$filterTitle .= "Category: " . $category . ", ";
	}

	if ($model != "- -")
	{
		$filterTitle .= "Model: " . $model . ", ";
	}

	if ($location != "- -")
	{
		$filterTitle .= "Location: " . $location . ", ";
	}

	if($user != "- -")
	{
		$filterTitle .= "User: " . $user . ", ";
	}

	if(isset($_GET['surplus']))
	{
		$filterTitle .= "(Includes Surplus), ";
	}

	if(isset($_GET['expiredWarranty']))
	{
		$filterTitle .= "(Expired Warranty), ";
	}

	// Remove the last comma if there is one
	if ($filterTitle != "")
	{
		$filterTitle = substr($filterTitle, 0, -2);
	}

	// Check to see if anything was selected at all
	else
	{
		$filterTitle = "All Assets (Excludes Surplus)";
	}
}

?>
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
						<a href="index.html">Home</a>
					</li>
					<li>
						<a href="assets.html">Manage Assets</a>
					</li>
					<li class="selected">
						<a href="reports.html">Reports</a>
					</li>
					<li>
						<a href="rental.html">Rental<br>Form</a>
					</li>
					<li>
						<a href="settings.html">Settings</a>
					</li>
				</ul>
			</div>
			<div class="body">
				<div>
					<h2>Reports</h2>
					<br />
					<div>
						<h3 id="filterTitle" class="centered"><?php print $filterTitle; ?></h3>
					</div>
					<br />
					<div id="reportTable">
						<table class="scrolling_table sortable">
							<thead>
								<tr>
									<th>Serial #</th>
									<th>Category</th>
									<th>Manufacturer</th>
									<th>Model #</th>
									<th>Location</th>
									<th>Days Since Checked</th>
									<th>User</th>
									<th>Surplus?</th>
									<th>Expired Warranty?</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>173509367</td>
									<td>Desktop</td>
									<td>Dell</td>
									<td>74544SR</td>
									<td>SL 247</td>
									<td>38</td>
									<td>Dan Mullins</td>
									<td>N</td>
									<td>N</td>
								</tr>
								<tr>
									<td>846421682</td>
									<td>Printer</td>
									<td>HP</td>
									<td>23542LJ</td>
									<td>IT 078</td>
									<td>17</td>
									<td>Dan Mullins</td>
									<td>N</td>
									<td>N</td>
								</tr>
								<tr>
									<td>376523899</td>
									<td>Tablet</td>
									<td>Apple</td>
									<td>32554I0</td>
									<td>J. Smith</td>
									<td>23</td>
									<td>Lori Yanef</td>
									<td>N</td>
									<td>N</td>
								</tr>
								<tr>
									<td>173509367</td>
									<td>Desktop</td>
									<td>Dell</td>
									<td>74544SR</td>
									<td>SL 247</td>
									<td>5</td>
									<td>Allison Jessup</td>
									<td>N</td>
									<td>N</td>
								</tr>
								<tr>
									<td>846421682</td>
									<td>Printer</td>
									<td>HP</td>
									<td>23542LJ</td>
									<td>IT 078</td>
									<td>46</td>
									<td>Dan Mullins</td>
									<td>N</td>
									<td>N</td>
								</tr>
								<tr>
									<td>376523899</td>
									<td>Tablet</td>
									<td>Apple</td>
									<td>32554I0</td>
									<td>J. Smith</td>
									<td>11</td>
									<td>Allison Jessup</td>
									<td>N</td>
									<td>N</td>
								</tr>
							</tbody>
						</table>
						<br />
						<br />
					</div>
					<form action="reports.php" method="get">
						<div class="reports_filter_container">
							<h3>Filter Options</h3>

							<!-- Select by category -->
							<label for="category">Category -</label>
							<select id="category" name="category">
								<option>- -</option>
								<option>Printer</option>
								<option>Desktop</option>
								<option>Video Conferencing</option>
								<option>Laptop</option>
								<option>Tablet</option>
							</select>
							<br />

							<!-- Select by Manufacturer -->
							<label for="manufacturer">Manufacturer -</label>
							<select id="manufacturer" name="manufacturer">
								<option>- -</option>
								<option>Apple</option>
								<option>Dell</option>
								<option>HP</option>
								<option>Canon</option>
								<option>Tandberg</option>
								<option>Logitech</option>
							</select>
							<br />

							<!-- Select by Model -->
							<label for="model">Model -</label>
							<select id="model" name="model">
									<option>- -</option>
									<option>Optiplex 5040</option>
									<option>Optiplex 5050</option>
									<option>Optiplex 7020</option>
									<option>XPS 13</option>
									<option>Latitude 7450</option>
									<option>Latidude 7250</option>
									<option>iMac</option>
									<option>MacAir</option>
									<option>MacPro</option>
									<option>MacBook</option>
							</select>
							<br />

							<!-- Select by location -->
							<label for="location">Location -</label>
							<select id="location" name="location">
								<option>- -</option>
								<option>SL 247</option>
								<option>SL 251</option>
								<option>IT 078</option>
							</select>
							<br />

							<!-- Select by user -->
							<label for="user">User -</label>
							<select name="user">
								<option>- -</option>
								<option>Dan Mullins</option>
								<option>Lori Yanef</option>
								<option>Allison Jessup</option>
							</select>
							<br />

							<!-- Check box to include surplus items in query -->
							<label for="surplus">Include Surplus -</label>
							<input id="surplus" type="checkbox" name="surplus" value="checked">
							<br />


							<!-- Check box to filter by expired warranty -->
							<label for="expiredWarranty">Expired Warranty -</label>
							<input id="expiredWarranty" type="checkbox" name="expiredWarranty" value="checked">
							<br />

							<!-- Button to submit form -->
							<button id="filter" type="submit" name="submit">Filter</button>

							<!-- Button to export to csv file -->
							<button type="button" name="export">Export</button>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script src="javascript/reports.js"></script>
</body>
</html>
