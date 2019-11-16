<?php

session_start();
if (!isset($_SESSION['userid'])) Header ("Location:login.php") ;

?>

<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Asset Reports</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Datatables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
</head>

<?php

$queryData = "";
$tableData = "";

require_once "phpinc/dbconnect.php";
require_once "phpinc/reportsUtil.php";

// Variables to store user form data
$manufacturer = "";
$category = "";
$model = "";
$location = "";
$user = "";
$network = "";
$surplus = "";
$expired = "";

// Query the DB for each non hidden filter type and add them as an array to each variable
// Sql statement to be prepared
$sql = "

	SELECT Name
	FROM P_MANUFACTURERS
	WHERE ManufacturerID NOT IN(
		SELECT ManufacturerID
		FROM P_HIDE_MANUFACTURER_RULES
		)

";

$query = $con->prepare($sql);
$query->execute();
$tempArr = $query->fetchAll();
$manOptions = array('- -');

// Loop through the queried array and set up the options array
foreach ($tempArr as $i)
{
	array_push($manOptions, $i[0]);
}

$sql = "

	SELECT Name
	FROM P_CATEGORIES
	WHERE CategoryID NOT IN(
		SELECT CategoryID
		FROM P_HIDE_CATEGORY_RULES
		)

";

$query = $con->prepare($sql);
$query->execute();
$tempArr = $query->fetchAll();
$categoryOptions = array("- -");

// Loop through the queried array and set up the options array
foreach ($tempArr as $i)
{
	array_push($categoryOptions, $i[0]);
}

$sql = "

	SELECT Name
	FROM P_MODELS
	WHERE ModelID NOT IN(
		SELECT ModelID
		FROM P_HIDE_MODEL_RULES
		)

";

$query = $con->prepare($sql);
$query->execute();
$tempArr = $query->fetchAll();
$modelOptions = array("- -");

// Loop through the queried array and set up the options array
foreach ($tempArr as $i)
{
	array_push($modelOptions, $i[0]);
}

$sql = "

	SELECT Name
	FROM P_LOCATIONS
	WHERE LocationID NOT IN(
		SELECT LocationID
		FROM P_HIDE_LOCATION_RULES
		)

";

$query = $con->prepare($sql);
$query->execute();
$tempArr = $query->fetchAll();
$locationOptions = array("- -");

// Loop through the queried array and set up the options array
foreach ($tempArr as $i)
{
	array_push($locationOptions, $i[0]);
}

$sql = "

	SELECT Name
	FROM P_USERS
	WHERE UserID NOT IN(
		SELECT UserID
		FROM P_HIDE_USER_RULES
		)

";

$query = $con->prepare($sql);
$query->execute();
$tempArr = $query->fetchAll();
$userOptions = array("- -");

// Loop through the queried array and set up the options array
foreach ($tempArr as $i)
{
	array_push($userOptions, $i[0]);
}

$sql = "

	SELECT NetworkName
	FROM P_ASSETS

";

$query = $con->prepare($sql);
$query->execute();
$tempArr = $query->fetchAll();
$networkOptions = array("- -");

// Loop through the queried array and set up the options array
foreach($tempArr as $i)
{
	array_push($networkOptions, $i[0]);
}

/*
 * FILTER FORM HANDLING
*/

$filterTitle = "Current Filters - ";

// Variables for each of the output select elements
$categoryOutput = '';
$manufacturerOutput = '';
$modelOutput = '';
$locationOutput = '';
$userOutput = '';
$networkOutput = '';

// Check if we need to process form data. (ie. filters have been requested)
if (isset($_GET['manufacturer']))
{

	// Get the form data
	$manufacturer = $_GET['manufacturer'];
	$category = $_GET['category'];
	$model = $_GET['model'];
	$location = $_GET['location'];
	$user = $_GET['user'];
	$network = $_GET['network'];
	$surplus = False;
	$expired = False;

	if (isset($_GET['surplus']))
	{
		$surplus = True;
	}

	if (isset($_GET['expiredWarranty']))
	{
		$expired = True;
	}

	// Create ReportsForm object
		$reportsForm = new ReportsForm($con, $manufacturer, $category, $model, $location, $user, $network, $surplus, $expired);
		$reportsForm->queryDB();

	//Get raw and table data from reports form
		$queryData = $reportsForm->getRaw();
		printCSV($queryData, "report.csv");
		$tableData = $reportsForm->getTableData();

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

	if($network != "- -")
	{
		$filterTitle .= "Network: " . $network . ", ";
	}

	if(isset($_GET['surplus']))
	{
		$surplus = $_GET['surplus'];
		$filterTitle .= "(Includes Surplus), ";
	}

	if(isset($_GET['expiredWarranty']))
	{
		$expired = $_GET['expiredWarranty'];
		$filterTitle .= "(Expired Warranty), ";
	}

	// Remove the last comma if there is one
	if ($filterTitle != "Current Filters - ")
	{
		$filterTitle = substr($filterTitle, 0, -2);
	}

	// Add the no filters statement if there are no filters
	else
	{
		$filterTitle .= 'None';
	}

}

// Check if the multi filter form was submitted
else if (isset($_GET['modalSubmit']))
{
	// Get user's input
	$multiFilter = $_GET['multiString'];
	$filter = $_GET['filterType'];

	// Check if a filter type was given
	if ($filter != "none")
	{
		// Split the string into an array separated by each space
		$filterArr = explode(" ", $multiFilter);

		// Query the DB with filter array and type
		$queryData = filterMulti($con, $filterArr, $filter);

		// Format the data to be in table form
		$reportsForm = new ReportsForm($con);

		// Check if query data is empty
		if (sizeof($queryData) != 0)
		{
			$tableData = $reportsForm->getTableData($queryData);
		}

		// Print the CSV
		printCSV($queryData, "report.csv");
	}
}

// This runs if this is the page's first time running
else
{

	$reportsForm = new ReportsForm($con);
	$reportsForm->queryDB();
	$filterTitle .= 'None';

	$queryData = $reportsForm->getRaw();
	printCSV($queryData, "report.csv");
	$tableData = $reportsForm->getTableData();
}

/*
 * SELECT ELEMENT OPTIONS FORMATTING
*/

// Formats select element options based on previous form data
// Manufacturer
for ($i = 0; $i < count($manOptions); $i++)
{

	// Check if the current value is the selected value
	if ($manOptions[$i] == $manufacturer)
	{
		$manufacturerOutput .= '<option name="manufacturer" selected>' . $manOptions[$i] . '</option>';
	}

	else
	{
		$manufacturerOutput .= '<option name="manufacturer">' . $manOptions[$i] . '</option>';
	}

}

// Model
for ($i = 0; $i < count($modelOptions); $i++)
{

	// Check if the current value is the selected value
	if ($modelOptions[$i] == $model)
	{
		$modelOutput .= '<option name="model" selected>' . $modelOptions[$i] . '</option>';
	}

	else
	{
		$modelOutput .= '<option name="model">' . $modelOptions[$i] . '</option>';
	}

}

// Category
for ($i = 0; $i < count($categoryOptions); $i++)
{

	// Check if the current value is the selected value
	if ($categoryOptions[$i] == $category)
	{
		$categoryOutput .= '<option name="category" selected>' . $categoryOptions[$i] . '</option>';
	}

	else
	{
		$categoryOutput .= '<option name="category">' . $categoryOptions[$i] . '</option>';
	}

}

// Location
for ($i = 0; $i < count($locationOptions); $i++)
{
	// Check if the current value is the selected value
	if ($locationOptions[$i] == $location)
	{
		$locationOutput .= '<option name="location" selected>' . $locationOptions[$i] . '</option>';
	}

	else
	{
		$locationOutput .= '<option name="location">' . $locationOptions[$i] . '</option>';
	}

}

// User
for ($i = 0; $i < count($userOptions); $i++)
{

	// Check if the current value is the selected value
	if ($userOptions[$i] == $user)
	{
		$userOutput .= '<option name="user" selected>' . $userOptions[$i] . '</option>';
	}

	else
	{
		$userOutput .= '<option name="user">' . $userOptions[$i] . '</option>';
	}

}

// Network Name
for($i = 0; $i < count($networkOptions); $i++)
{
	// Check if the current value is the selected value
	if($networkOptions[$i] == $network)
	{
		$networkOutput .= '<option name="network" selected>' . $networkOptions[$i] . '</option>';
	}

	else
	{
		$networkOutput .= '<option name="network">' . $networkOptions[$i] . '</option>';
	}
}

/*
 * QUICK SUMMARIES
*/

// Total Asset Count
$sql = 'SELECT count(*) as c FROM P_ASSETS WHERE IsSurplus = 0';
$query = $con->prepare($sql);
$query->execute();
$count = $query->fetch(PDO::FETCH_OBJ);
$totalCount = $count->c;

// Count by category

// Output string
$categoryCountOutput = "";

// Get the list of categories
$categories = getCategories($con);

// Get the list of manufacturers
$manufacturers = getManufacturers($con);

// Loop through each category
foreach($categories as $cat)
{
	// Check if there are any models with the given category
	if(countCategory($con, $cat) != 0)
	{
		// Add the category title to output string
		$categoryCountOutput .= '<h4><span class="quickClick quickCat">' . $cat . '</span>' . "s: " . countCategory($con, $cat) . '</h4>';

		// Loop through each manufacturer
		foreach($manufacturers as $man)
		{
			// Check if there are any current assets for this manufacturer-category combo
			if(countCatMan($con, $cat, $man) != 0)
			{
				// Add the manufacturer name along with the count of manufacturer-category assets
				// to output string
				$categoryCountOutput .= "<p>" . '<span class="quickClick quickMan">' . $man . '</span>' . " : " . countCatMan($con, $cat, $man) . '<br>';

				// Get the models for this manufacturer-category combo
				$models = getModels($con, $cat, $man);

				// Loop through each model and add the count to the output string
				foreach($models as $mod)
				{
					$categoryCountOutput .= '<span class="quickClick quickMod">' . $mod . '</span>' . ' : ' . countModels($con, $mod) . ', ';
				}

				// Add closing p
				$categoryCountOutput .= '</p>';

				// Line break
				$categoryCountOutput .= '<br>';
			}

		}

		// Add total out of warranty assets for the category
		$categoryCountOutput .= '<p>Total ' . '<span class="quickClick quickMod">' . $cat . '</span>' . 's' . ' out of warranty: ' . countCategoriesOW($con, $category) . '</p>';
	}
}

?>
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
					<li class="selected">
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

			<!-- Modal For Filtering multiple Items -->
			<div class="modal reports">
				<div class="modal-content multiFilter">
					<span class="close">&times;</span>
					<h2><span id="modalHeader"></span></h2>
					<form name="multi" action="reports.php" method="get">
						<label for="multiString">Enter multiple filters by typing each filter with a space in between:</label>
						<input type="text" name="multiString"></input>
						<button type="submit" name="modalSubmit" value="modalSubmit">Filter</button>

						<!-- Hidden Input for JS to tell the server which filter type
							the user used when submitting multiple filters -->
						<input type="text" name="filterType" id="filterType" value="none" hidden></input>
					</form>
				</div>
			</div>


			<div class="body" id="body">
				<div>
					<div id="pdf">
						<h2>
							Reports
						</h2>
						<br />
						<div class="centered">
							<p id="filterList"><span><?php echo $filterTitle; ?></span></p>
						</div>
						<br />
						<div id="reportTable">
							<table class="dataTable display" style="width: 100%">
								<thead>
									<tr>
										<th>Serial #</th>
										<th>Network Name</th>
										<th>Category</th>
										<th>Manufacturer</th>
										<th>Model #</th>
										<th>Location</th>
										<th>Days Since Checked</th>
										<th>User</th>
										<th>Surplus</th>
										<th>Expired Warranty</th>
									</tr>
								</thead>
								<tbody>
									<?php echo $tableData; ?>
								</tbody>
							</table>
						</div>
					</div>

					<!-- DataTable controll -->
					<script type="text/javascript">
						$(document).ready(function(){
						   $('.dataTable').DataTable({
								 responsive:true,
								 columnDefs: [
									 {
										 targets: "_all",
										 className: 'dt-body-center'
									 }
								 ]
							 });
						 });
					</script>

							<br />
							<br />
						<form id="filterForm" name="filterForm" action="reports.php" method="get">
							<div class="reportFilters">
								<h3><span>Select Filters</span></h3>

								<!-- Select by category -->
								<button for="category" id="category" type="button" class="filterLabel">Category -</button>
								<select id="categorySelect" name="category">
									<?php echo $categoryOutput; ?>
								</select>

								<!-- Select by Manufacturer -->
								<button for="manufacturer" id="manufacturer" type="button" class="filterLabel">Manufacturer -</button>
								<select id="manufacturerSelect" name="manufacturer">
									<?php echo $manufacturerOutput; ?>
								</select>

								<!-- Select by Model -->
								<button for="model" id="model" type="button" class="filterLabel">Model -</button>
								<select id="modelSelect" name="model">
									<?php echo $modelOutput; ?>
								</select>
								<br>
								<br>
								<!-- Select by location -->
								<button for="location" id="location" type="button" class="filterLabel">Location -</button>
								<select name="location">
									<?php echo $locationOutput; ?>
								</select>

								<!-- Select by user -->
								<button for="user" id="user" type="button" class="filterLabel">User -</button>
								<select name="user">
									<?php echo $userOutput; ?>
								</select>
								<br /> <br />

								<!-- Select by network -->
								<button for="network" id="network" type="button" class="filterLabel">Network -</button>
								<select name="network">
									<?php echo $networkOutput; ?>
								</select>
								<br /> <br />

								<!-- Check box to include surplus items in query -->
								<label for="surplus">Include Surplus - </label>
								<input type="checkbox" name="surplus" value="checked" <?php echo $surplus; ?>>

								<!-- Check box to filter by expired warranty -->
								<label for="expiredWarranty">Expired Warranty - </label>
								<input type="checkbox" name="expiredWarranty" value="checked" <?php echo $expired; ?>>
								<br /> <br />

								<!-- Button to submit form -->
								<button class="buttonReal" id="filter" type="submit" name="submitBtn">Filter</button>

								<!-- Reset filters button -->
								<button class="buttonReal" type="button" name="resetBtn">Reset Filters</button>

								<!-- Button to export to CSV file -->
								<button class="buttonReal" type="button" name="exportCSV">Export CSV</button>

							</div>
						</form>

						<div class="centered">
							<!-- Quick Summaries -->
							<h3><span>Quick Summaries</span></h3>

							<!-- Total Assets -->
							<p>Total Assets: <?php echo $totalCount; ?></p>
							<br>

							<!-- Numerical Breakdown -->
							<?php echo $categoryCountOutput; ?>
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Local JS -->
	<script src="javascript/reports.js"></script>
</body>
</html>
