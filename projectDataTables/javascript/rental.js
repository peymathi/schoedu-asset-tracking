var i = 1;//device counter

//add device button
function addDeviceBtn(){
	i++;
	$("#addDevice").prev().prev().before('<br><br>'+
		'<select style="width:10.6em" onmouseenter="getCategory(this.value,this.name);" onchange="checkState('+i+');showOptions(\'brand\', this.name.substr(-1))" name="category'+i+'">\
			<option hidden>Category</option>\
		</select>'+
		'<select onclick="showOptions(\'model\', this.name.substr(-1))" disabled name="brand'+i+'">\
			<option hidden>Brand</option>\
		</select>'+
		'<select onclick="showOptions(\'\', this.name.substr(-1))" disabled name="model'+i+'">\
			<option hidden>Model</option>\
		</select>\
		<label>&nbsp&nbspSerial:</label>'+
		'<input list="serial'+i+'" onkeyup="showOptions(this.value, this.name.substr(-1))" disabled type="text" name="serial'+i+'">\
		')

	$('#serial1').after('<datalist id="serial'+i+'"></datalist>');
}

/*//control disabled fields
function checkState(x){
	if($('select[name="category'+x+'"]').val() != "Category")
	{
		$('select[name="brand'+x+'"]').prop('disabled', false);
		$('select[name="model'+x+'"]').prop('disabled', false);
		$('input[name="serial'+x+'"]').prop('disabled', false);	
	
	}

}*/


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
	var s = prompt("Enter serial: ");
	$('#rentalForm').attr('action', 'phpinc/formUpload.php?s='+s);
	$('#rentalForm').submit();

}