var i = 1;//device counter

$(document).ready(function(){
	// Get the modal
	var modal = document.getElementsByClassName("modal")[0];

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	$('#view_rentalsBtn').click(function(){modal.style.display = "block";})

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
	    modal.style.display = "none";
	  }
	}

});

//add device button
function addDeviceBtn(x){
	i++;
	$("#addDevice").prev().prev().before('<br><br>'+
		'<select style="width:10.6em" onmouseenter="getCategory(this.value,this.name);" onchange="showOptions(\'brand\', this.name.substr(-1))" name="category'+i+'">\
			<option hidden>Category</option>\
		</select>'+
		'<select onclick="showOptions(\'model\', this.name.substr(-1))" name="brand'+i+'">\
			<option hidden>Brand</option>\
		</select>'+
		'<select onclick="showOptions(\'\', this.name.substr(-1))" name="model'+i+'">\
			<option hidden>Model</option>\
		</select>\
		<label>&nbsp&nbspSerial:</label>'+
		'<input list="serial'+i+'" onkeyup="showOptions(this.value, this.name.substr(-1))" type="text" name="serial'+i+'">\
		')

	$('#serial1').after('<datalist id="serial'+i+'"></datalist>');
}


//show options for Brand, Model, Serial fields
function showOptions(mode, cur)
{
	var str = document.getElementsByName('category'+cur)[0].value;
	var brand = document.getElementsByName('brand'+cur)[0].value;
	var model = document.getElementsByName('model'+cur)[0].value;
	
	$.ajax({
	    url: 'phpinc/rentalUtilsPDO.php',
	    type: 'GET',
	    data:{
	    	c: str,
	    	m: mode,
	    	b: brand,
	    	mod: model
	    },
	    success: function(response) {
	    	if(mode == "brand")
        	{
        		document.getElementsByName('brand'+cur)[0].innerHTML=response;
        	}
        	else if(mode == "model")
        	{
        		document.getElementsByName('model'+cur)[0].innerHTML=response;
        	}
        	else
        	{
        		document.getElementById('serial'+cur).innerHTML=response;
        	}
	    }
	});

}

//show options for Category select
function getCategory(val,x)
{
	if(val == 'Category')
	{
		$.ajax({
		    url: 'phpinc/rentalUtil.php',
		    type: 'GET',
		    success: function(response) {
		    	document.getElementsByName(x)[0].innerHTML = response;
		    }
		});
	}
}

//show auto fill for Name
function showNames(str)
{
	$.ajax({
	    url: 'phpinc/rentalGetNames.php',
	    type: 'GET',
	    data:{q: str},
	    success: function(response) {
	    	$("#names").html(response);
	    }
	});
}

//show auto fill for Phone
function showPhones(str)
{
	var name = $('#name').val();

	$.ajax({
	    url: 'phpinc/rentalGetPhones.php',
	    type: 'GET',
	    data:{q: str, n: name},
	    success: function(response) {
	    	$("#phoneNums").html(response);
	    }
	});
}

//show auto fill for Email
function showEmail(str)
{
	var name = $('#name').val();

	$.ajax({
	    url: 'phpinc/rentalGetEmail.php',
	    type: 'GET',
	    data:{q: str, n: name},
	    success: function(response) {
	    	$("#emails").html(response);
	    }
	});
}

//form upload
function upload(x){
	var form = prompt("Enter Form Number: ");

	while(form == "")
	{
		form = prompt("Please enter a valid Form Number: ");
	}

	$.ajax({
		    url: 'phpinc/rentalVerifyUpload.php?',
		    type: 'GET',
		    data:{
		    	f: form,
		    },
		    success: function(response) {
		    	if(response == '0'){alert('Form: '+ form +' does not exist');}
		    	else
		    	{
		    		$('#rentalForm').attr('action', 'phpinc/formUpload.php?f='+form);
					$('#rentalForm').attr('onsubmit', '');
					$('#rentalForm').submit();
					$('#rentalForm').attr('onsubmit', 'return false');
		    	}
		    }
		});

}

function printFunction() {
	if($('#serial1').val() == "")
	{
		alert("Please enter atleast 1 device");
	}
	if($('#name').val() == "")
	{
		alert("Please enter a name");
	}
	else if($('#outDate').val() == "")
	{
		alert("Please enter a Rental Date");
	}
	else
	{
		var dOut = new Date($('#outDate').val());;
		var dIn;
		if($('#inDate').val() == "")
		{
			dIn = new Date('9999-12-31');
		}
		else
		{
			dIn = new Date($('#inDate').val());
		}

		if(dOut > dIn)
		{
			alert('Out Date must be before In Date');
		}
		else
		{
			if(confirm("Are you sure you want to complete this rental?"))
			{
				window.print();

				var name = $('#name').val();
				var items = i;
				var formID = $('#currentForm').html();
				var serials = "";
				var outDate = $('#outDate').val();
				var inDate = $('#inDate').val();

				for(var c = 0; c<i; c++)
				{
					if(c > 0){serials+="+";}
					serials += $("input[name='serial"+(c+1)+"'").val();
				}

				$.ajax({
				    url: 'phpinc/rentalRent.php?',
				    type: 'GET',
				    data:{
				    	n: name,
				    	i: items,
				    	f: formID,
				    	s: serials,
				    	o: outDate,
				    	in: inDate
				    },
				    success: function(response) {
				    	setTimeout(function(){location.reload();}, 100);
				    }
				});


			}
		}
	}
}

function checkIn(x)
{
	var formID = $(x).parent().next().text();

	$.ajax({
	    url: 'phpinc/rentalCheckIn.php',
	    type: 'GET',
	    data:{f: formID},
	    success: function(response) {
	    	setTimeout(function() { location.reload(); }, 100);
	    }
	});
}