var i = 1;//device counter

//add device button
function addDeviceBtn(){
	i++;
	$("#addDevice").prev().prev().before('<br><br>'+
		'<select onchange="checkState('+i+')" name="category'+i+'">\
			<option hidden>Category</option>\
			<?php print GetCategory(); ?>\
		</select>'+
		'<select onchange="checkState('+i+')" disabled name="brand'+i+'">\
			<option hidden>Brand</option>\
			<option>Dell</option>\
			<option>Apple</option>\
		</select>'+
		'<select onchange="checkState('+i+')" disabled name="model'+i+'">\
			<option hidden>Model</option>\
			<option>123</option>\
			<option>456</option>\
		</select>\
		<label>&nbsp&nbspSerial:</label>'+
		'<input disabled type="text" name="serial'+i+'">\
		')
}

//control disabled fields
function checkState(x){
	if($('select[name="category'+x+'"]').val() != "Category")
	{
		$('select[name="brand'+x+'"]').prop('disabled', false);
		$('select[name="model'+x+'"]').prop('disabled', false);
		$('input[name="serial'+x+'"]').prop('disabled', false);	
	
	}

}



function showOptions(mode)
{
	var str = document.getElementsByName('category1')[0].value;
	var brand = document.getElementsByName('brand1')[0].value;
	var model = document.getElementsByName('model1')[0].value;
	if (str=="")
    {
      obj.innerHTML="";
      return;
    } 
	if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    }
	else
    {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	xmlhttp.onreadystatechange=function()
    {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        	if(mode == "brand")
        	{
        		document.getElementsByName('brand1')[0].innerHTML=xmlhttp.responseText;
        	}
        	else if(mode == "model")
        	{
        		document.getElementsByName('model1')[0].innerHTML=xmlhttp.responseText;
        	}
        	else
        	{
        		document.getElementById('serial').innerHTML=xmlhttp.responseText;
        	}
          
        }
    }
	xmlhttp.open("GET","phpinc/rentalUtilsPDO.php?c="+str+"&m="+mode+"&b="+brand+"&mod="+model,true);
	xmlhttp.send();
}

