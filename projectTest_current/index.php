<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Home</title>
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
			<div class="body">
				<div>
					<h2>IUPUI Asset Management System<img id="menu_icon" title="Show Menu" alt="show menu icon" src="images/hamburgerIcon.svg"></h2>
					<div>
						<h3><span>Devices to be Checked</span></h3>

						<table class="scrolling_table sortable">
							<thead>
								<tr>
									<th style="width: 5em">Select</th>
									<th>Serial #</th>
									<th>Category</th>
									<th>Manufacturer</th>
									<th>Model #</th>
									<th>Location</th>
									<th>Days Since Checked</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="width: 5em"><input type="checkbox" name="select"></td>
									<td>173509367</td>
									<td>Desktop</td>
									<td>Dell</td>
									<td>74544SR</td>
									<td>SL 247</td>
									<td>38</td>
								</tr>
								<tr>
									<td style="width: 5em"><input type="checkbox" name="select"></td>
									<td>846421682</td>
									<td>Printer</td>
									<td>HP</td>
									<td>23542LJ</td>
									<td>IT 078</td>
									<td>17</td>
								</tr>
								<tr>
									<td style="width: 5em"><input type="checkbox" name="select"></td>
									<td>376523899</td>
									<td>Tablet</td>
									<td>Apple</td>
									<td>32554I0</td>
									<td>J. Smith</td>
									<td>23</td>
								</tr>
								<tr>
									<td style="width: 5em"><input type="checkbox" name="select"></td>
									<td>173509367</td>
									<td>Desktop</td>
									<td>Dell</td>
									<td>74544SR</td>
									<td>SL 247</td>
									<td>5</td>
								</tr>
								<tr>
									<td style="width: 5em"><input type="checkbox" name="select"></td>
									<td>846421682</td>
									<td>Printer</td>
									<td>HP</td>
									<td>23542LJ</td>
									<td>IT 078</td>
									<td>46</td>
								</tr>
								<tr>
									<td style="width: 5em"><input type="checkbox" name="select"></td>
									<td>376523899</td>
									<td>Tablet</td>
									<td>Apple</td>
									<td>32554I0</td>
									<td>J. Smith</td>
									<td>11</td>
								</tr>
							</tbody>
						</table>
						<button style="float:left">Verify</button>
						<div id="minDaysField">
							Minimum Days Since Checked:
							<input type="number" name="minDays" value="60" min="0" max="999">
						</div>
					</div>
					<br>
					<br>
					<div>
						<h3><span>Search for Device</span></h3>
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
