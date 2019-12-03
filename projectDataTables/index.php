<?php

session_start();

require_once "phpinc/dbconnect.php";

if (!isset($_SESSION['userid'])) Header ("Location:login.php") ;

$row = "";

$stmt = $con->prepare("select checkdays from P_ADMINS where adminid = ?");
$stmt->execute(array($_SESSION['userid']));
$row = $stmt->fetch(PDO::FETCH_OBJ);
$checkdays = $row->checkdays;
$curdate = date("Y-m-d h:m:s") ." -" .$checkdays ." days";
$time = strtotime($curdate);
$datemax = date("Y-m-d h:m:s", $time);

$acurdate = date("Y-m-d h:m:s");
$time1 = strtotime($acurdate);

?>

<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=0.8">
	<title>Home</title>

	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="javascript/verify.js"></script>

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
			<!-- SIDEBAR -->
			<div class="sidebar" id="sidebar">
				<a href="index.php" id="logo"><img src="images/educationlogo.png" alt="logo"></a>
				<ul>
					<li class="selected">
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

			<!-- CONTENT -->
			<div class="body" id="body">
				<div>
					<h2>
						IUPUI Asset Management System
					</h2>

					<div>
						<h3><span>Devices to be Checked</span></h3>

						<table class="dataTable display" style="width: 100%">
							<thead>
								<tr>
									<th style="width: 5em">Verify</th>
									<th>Serial #</th>
									<th>Category</th>
									<th>Manufacturer</th>
									<th>Model #</th>
									<th>Location</th>
									<th>Days Since<br>Checked</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$stmt = $con->prepare("select * from PV_ASSET_REPORTS where datelastchecked <= ? and issurplus = 0 group by SerialNumber");
								$stmt->execute(array($datemax));
								while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$datelast = $row["DateLastChecked"];
									$lasttime = strtotime($datelast);
									$timedif = $time1 - $lasttime;
									$dayssince = round($timedif / 86400);
									print "<tr>";

									print "<td><button onclick='verifyFunction(this)'><i class='fa fa-check'></i></button></td>";
									print "<td>".$row["SerialNumber"]."</td><td>".$row["CategoryName"]."</td><td>".$row["ManufacturerName"]."</td><td>".$row["ModelName"]."</td><td>".$row["LocationName"]."</td><td>".$dayssince."</td>";
									print "</tr>";
								}
								?>
							</tbody>
						</table>

						<!-- DataTable controll -->
						<script type="text/javascript">
							$(document).ready(function(){
						    		$('.dataTable').DataTable({
											responsive:true,
						    			columnDefs: [
							          { orderable: false, targets: [0] },
							          { responsivePriority: 1, targets: 0 },
							          { responsivePriority: 2, targets: 1 },
							          { responsivePriority: 3, targets: 6 },
							          { responsivePriority: 4, targets: 5 },
							          { responsivePriority: 5, targets: 4 },
							          { responsivePriority: 6, targets: 3 },
							          { responsivePriority: 7, targets: 2 }
							        ],
        							order: [[ 6, 'desc']]});
						    });
						</script>


					</div>
					<br>
					<br>
					<div>
						<h3><span>Quick Summary of Active Assets</span></h3>
						<div class="summary">
						<?php
							$stmt = $con->prepare("select * from P_CATEGORIES");
							$stmt->execute();
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								$label = $row["Name"];
								$catid = $row["CategoryID"];
								$stmt2 = $con->prepare("select count(*) as c from P_ASSETS inner join P_MODELS on P_ASSETS.modelid = P_MODELS.modelid where categoryid = ? and issurplus = 0");
								$stmt2->execute(array($catid));
								$row2 = $stmt2->fetch(PDO::FETCH_OBJ);
								$count = $row2->c;
								print $label .": " .$count;
								print "</br>";
							}
						?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</body>
</html>
