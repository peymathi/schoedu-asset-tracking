<?php
session_start();
if (!isset($_SESSION['userid'])) Header ("Location:login.php") ; 
	require_once "phpinc/dbconnect.php";

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
	<title>Rental Page</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="javascript/rental.js"></script>

	<!-- Datatables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

	<!-- Export Buttons -->
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
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

					$( document ).ready(function() {
						var t = $('h2').offset().top + 20;
						$('.menu_toggle_container').offset({top:t});

						$('.page').on('scroll', function(){
							t = $('.body div h2').offset().top + 20;
							$('.menu_toggle_container').offset({top:t, right: '40px'});
						})
					});

				</script>
			</div>

			<!-- The Modal -->
			<div class="modal">

			  <!-- Modal content -->
			  <div class="modal-content">
			    <span class="close">&times;</span>
				<table class="dataTable display" style="width: 100%">
					<thead>
						<tr>
							<th>Check In</th>
							<th>Name</th>
							<th>Device Serial</th>
							<th>Rental Date</th>
							<th>Return Date</th>
							<th>Status</th>
							<th>Form</th>

						</tr>
					</thead>
					<tbody>
						<?php

						$stmt = $con->prepare("select distinct FormID from P_RENTAL_FORMS order by FormID desc");
						$stmt->execute();
						$formID = $stmt->fetch(PDO::FETCH_ASSOC);
						$formID = $formID['FormID'] + 1;

						$date = strtotime(date("Y-m-d"));

						$stmt = $con->prepare("select * from P_RENTAL_FORMS where fileName != ''");
						$stmt->execute();
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							if($row['inDate'] != '0000-00-00' && ($row['Status'] == 'Out' && ($date > strtotime($row['inDate']))))
							{
								$sql = $con->prepare("update P_RENTAL_FORMS set Status = ? where FormID = ?");
	              				$sql->execute(array('Late', $row["FormID"]));
              				}
							
							$sql = $con->prepare("select SerialNumber from P_ASSETS where AssetID = ?");
							$sql->execute(array($row["AssetID"]));
							$serial = $sql->fetch(PDO::FETCH_ASSOC);

							$color = "";
							$disable = "";

							if($row['Status'] == 'Late')
							{
								$color = " style='background-color: #fddada'";
							}
							else if($row['Status'] == 'Out')
							{
								$color = " style='background-color: #dafddb'";
							}
							else
							{
								$disable = " disabled";
							}

							print "<tr>";
							
							print "<td".$color."><button onclick='checkIn(this)'".$disable."><i class='fa fa-check'></i></button></td>";
							print "<td".$color.">".$row["Name"]."</td>";
							print "<td".$color.">".$serial["SerialNumber"]."</td>";
							print "<td".$color.">".$row["outDate"]."</td>";
							print "<td".$color.">".$row["inDate"]."</td>";
							print "<td".$color.">".$row["Status"]."</td>";

							print "<td".$color."><a target='_blank' href='Uploads/".$row["fileName"]."'>View Form: ".$row['FormID']."</a></td>";

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
								          { orderable: false, targets: [0] }
								        ],
        								dom: 'Bfrtip',
									    buttons: [
								            'copyHtml5',
								            'excelHtml5',
								            'csvHtml5',
								            'pdfHtml5'
								        ]
        							});
						    });
				</script>
			  </div>

			</div>

			
			<div class="body" id="body">
				<div>
					<h2 style="padding-right: 22px">
						Asset Rental <span id="currentForm"><?php print $formID ?></span><span id='formLabel'>Form: &nbsp</span>
					</h2>

					<div id="rental_div">
						<br>
						<br>

						<h4 id="message" style="margin-top: 0;"></h4>
						<form id="rentalForm" onsubmit="return false" class="rental_form" method="post" enctype="multipart/form-data">
							<label for="name">Name:</label>
							<input list="names" type="text" id="name" onkeyup="showNames(this.value)">
							<datalist id="names"></datalist>

							<br>

							<label style="padding: 6px 0" for="phone">Phone:</label>
							<input list="phoneNums" type="text" id="phone" onkeyup="showPhones(this.value)">
							<datalist id="phoneNums"></datalist>

							<br>

							<label style="padding: 6px 0" for="email">Email:</label>
							<input list="emails" type="text" id="email" onkeyup="showEmail(this.value)">
							<datalist id="emails"></datalist>

							<br>

							<label for="purpose">Purpose:</label>
							<select name="purpose">
								<option>Faculty Use for Class</option>
								<option>Faculty Use for Meeting</option>
								<option>Staff Use for Work at Home</option>
								<option>Staff Use for Meeting</option>
								<option>Other</option>
							</select>

							<br>
							<br>
							<br>

							<label>Equipment:</label>
							<br>

							<select style="width:10.6em" onmouseenter="getCategory(this.value,this.name);" onchange="showOptions('brand', this.name.substr(-1));" name="category1">
								<option hidden>Category</option>
								<?php if(isset($_GET['c'])){print '<option selected>'.$_GET['c'].'</option>';} ?>

							</select>

							<select onclick="showOptions('model', this.name.substr(-1))" onchange="showOptions('model')" name="brand1">
								<option hidden>Brand</option>
								<?php if(isset($_GET['ma'])){print '<option selected>'.$_GET['ma'].'</option>';} ?>
							</select>
								
							<select onclick="showOptions('', this.name.substr(-1));" name="model1">
								<option hidden>Model</option>
								<?php if(isset($_GET['mo'])){print '<option selected>'.$_GET['mo'].'</option>';} ?>
							</select>

							<label>&nbsp&nbspSerial:</label>
							<input list="list_serial1" onkeyup="showOptions(this.value, this.name.substr(-1))" type="text" name="serial1" id="serial1" value=<?php if(isset($_GET['s'])){print $_GET['s'];} ?>>

							<datalist id="list_serial1"></datalist>

							<br>
							<br>

							<button onclick="addDeviceBtn(this)" id='addDevice'>Add Device</button>

							<br>
							<br>
							<br>

							<label>Rental Date:</label>
							<input id="outDate" type="date" name="loanDate">
							<br>
							<label style="padding-top: 6px">Return Date:</label>
							<input id="inDate" type="date" name="returnDate">

							<div id='termsDiv'>
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
							</div>

							<br>
							<br>
							<br>

							<button id="rental_submit" onclick="printFunction()" type="button">Rent</button>

							<input id="rental_scan" style="margin-left: 6px" type="button" value="Upload" onclick="$('#file').trigger('click');">

							<input type="file" name="file" id="file" onchange="upload()">

							<button id="view_rentalsBtn" onclick="" type="button">View Rentals</button>

						</form>


						
					</div>
					
						
				</div>
			</div>
		</div>
	</div>
</body>
</html>