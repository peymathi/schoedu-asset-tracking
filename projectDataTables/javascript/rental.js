var i = 1;//device counter

//add device button
function addDeviceBtn(){
	i++;
	$("#addDevice").prev().prev().before('<br><br>'+
		'<select onmouseenter="getCategory(this.value,this.name);" onchange="checkState('+i+');showOptions(\'brand\', this.name.substr(-1))" name="category'+i+'">\
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

//control disabled fields
function checkState(x){
	if($('select[name="category'+x+'"]').val() != "Category")
	{
		$('select[name="brand'+x+'"]').prop('disabled', false);
		$('select[name="model'+x+'"]').prop('disabled', false);
		$('input[name="serial'+x+'"]').prop('disabled', false);	
	
	}

}



function showOptions(mode, cur)
{
	var str = document.getElementsByName('category'+cur)[0].value;
	var brand = document.getElementsByName('brand'+cur)[0].value;
	var model = document.getElementsByName('model'+cur)[0].value;
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
        		document.getElementsByName('brand'+cur)[0].innerHTML=xmlhttp.responseText;
        	}
        	else if(mode == "model")
        	{
        		document.getElementsByName('model'+cur)[0].innerHTML=xmlhttp.responseText;
        	}
        	else
        	{
        		document.getElementById('serial'+cur).innerHTML=xmlhttp.responseText;
        	}
          
        }
    }
	xmlhttp.open("GET","phpinc/rentalUtilsPDO.php?c="+str+"&m="+mode+"&b="+brand+"&mod="+model,true);
	xmlhttp.send();
}


function getCategory(val,x)
{
	if(val == 'Category')
	{
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
	        	document.getElementsByName(x)[0].innerHTML=xmlhttp.responseText;
	       }
	    }
		
		xmlhttp.open("GET","phpinc/rentalUtil.php?",true);
		xmlhttp.send();
	}

}

function showNames(str)
{
	var xmlhttp;

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
	    document.getElementById("names").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","phpinc/rentalGetNames.php?q="+str,true);
	xmlhttp.send();
}

