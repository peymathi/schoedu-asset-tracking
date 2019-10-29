<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Assets</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="javascript/modal.js"></script>

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
			    <p>Some text in the Modal..</p>
			  </div>

			</div>



			<div class="body" id="body">
				<div>
					<h2>
						Manage Assets
					</h2>
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

						&nbsp&nbsp Warranty:<input type="number" name="warranty" min="0">&nbspyears

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



						<table class="dataTable display" style="width: 100%">
							<thead>
								<tr>
									<th style="width: 5em">Edit</th>
									<th>Serial #</th>
									<th>Category</th>
									<th>Manufacturer</th>
									<th>Model #</th>
									<th>Location</th>
									<th>User</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="" style="width: 5em"><button class="editBtn"><i class="fa fa-edit"></i></button></td>
									<td>173509367</td>
									<td>Desktop</td>
									<td>Dell</td>
									<td>74544SR</td>
									<td>SL 247</td>
									<td>John Doe</td>
								</tr>
								<tr>
									<td style="width: 5em"><button class="editBtn"><i class="fa fa-edit"></i></button></td>
									<td>846421682</td>
									<td>Printer</td>
									<td>HP</td>
									<td>23542LJ</td>
									<td>IT 078</td>
									<td>John Doe</td>
								</tr>
								<tr>
									<td style="width: 5em"><button class="editBtn"><i class="fa fa-edit"></i></button></td>
									<td>376523899</td>
									<td>Tablet</td>
									<td>Apple</td>
									<td>32554I0</td>
									<td>J. Smith</td>
									<td>John Doe</td>
								</tr>
								<tr>
									<td style="width: 5em"><button class="editBtn"><i class="fa fa-edit"></i></button></td>
									<td>173509367</td>
									<td>Desktop</td>
									<td>Dell</td>
									<td>74544SR</td>
									<td>SL 247</td>
									<td>John Doe</td>
								</tr>
								<tr>
									<td style="width: 5em"><button class="editBtn"><i class="fa fa-edit"></i></button></td>
									<td>846421682</td>
									<td>Printer</td>
									<td>HP</td>
									<td>23542LJ</td>
									<td>IT 078</td>
									<td>John Doe</td>
								</tr>
								<tr>
									<td style="width: 5em"><button class="editBtn"><i class="fa fa-edit"></i></button></td>
									<td>376523899</td>
									<td>Tablet</td>
									<td>Apple</td>
									<td>32554I0</td>
									<td>J. Smith</td>
									<td>John Doe</td>
								</tr>
							</tbody>
						</table>


						<!-- DataTable control -->
						<script type="text/javascript">
							$(document).ready(function(){
								$('.dataTable').DataTable({
									responsive: true,
									serverSide: true,
    								ajax: 'phpinc/getAssetDataJson.php',
									rowCallback: function( row, data ) {
										console.log(data[0]);
										//$("td:eq(0)", row).css("width: 5em");
										$("td:eq(0)", row).html('<button class="editBtn"><i class="fa fa-edit"></i></button>');
									},
									columnDefs: [ { orderable: false, targets: [0] } ],
									order: [[ 1, 'asc' ]]
								});
							});
						</script>




					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
