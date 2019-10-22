<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Home</title>

	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>
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
								<tr>
									<td style="width: 5em"><button><i class="fa fa-check"></i></button></td>
									<td>173509367</td>
									<td>Desktop</td>
									<td>Dell</td>
									<td>74544SR</td>
									<td>SL 247</td>
									<td>38</td>
								</tr>
								<tr>
									<td style="width: 5em"><button><i class="fa fa-check"></i></button></td>
									<td>846421682</td>
									<td>Printer</td>
									<td>HP</td>
									<td>23542LJ</td>
									<td>IT 078</td>
									<td>17</td>
								</tr>
								<tr>
									<td style="width: 5em"><button><i class="fa fa-check"></i></button></td>
									<td>376523899</td>
									<td>Tablet</td>
									<td>Apple</td>
									<td>32554I0</td>
									<td>J. Smith</td>
									<td>23</td>
								</tr>
								<tr>
									<td style="width: 5em"><button><i class="fa fa-check"></i></button></td>
									<td>173509367</td>
									<td>Desktop</td>
									<td>Dell</td>
									<td>74544SR</td>
									<td>SL 247</td>
									<td>5</td>
								</tr>
								<tr>
									<td style="width: 5em"><button><i class="fa fa-check"></i></button></td>
									<td>846421682</td>
									<td>Printer</td>
									<td>HP</td>
									<td>23542LJ</td>
									<td>IT 078</td>
									<td>46</td>
								</tr>
								<tr>
									<td style="width: 5em"><button><i class="fa fa-check"></i></button></td>
									<td>376523899</td>
									<td>Tablet</td>
									<td>Apple</td>
									<td>32554I0</td>
									<td>J. Smith</td>
									<td>11</td>
								</tr>
							</tbody>
						</table>

						<!-- DataTable controll -->
						<script type="text/javascript">
							$(document).ready(function(){
						    	$('.dataTable').DataTable({responsive:true});} );
						</script>


					</div>
					<br>
					<br>
					<div>
						<h3><span>Quick Summary</span></h3>
						<div class="summary">
							Desktops: 100 &nbsp&nbsp
							Laptops: 100 &nbsp&nbsp
							Tablets: 100
						</div>
						<div class="summary">
							Cameras: 100 &nbsp&nbsp
							Printers: 100 &nbsp&nbsp
							Video Conferencing: 100
						</div>
						
					</div>

				</div>
			</div>
		</div>
	</div>
</body>
</html>