function verifyFunction(x)
{
	var d = new Date($.now());
	var datetime = d.getFullYear()+"-"+(d.getMonth() + 1)+"-"+d.getDate()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();
	var serial = $(x).parent().next().text();

	if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    }
	else
    {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	xmlhttp.open("GET","phpinc/verify.php?d="+datetime+"&s="+serial,true);
	xmlhttp.send();

	setTimeout(function() { location.reload(); }, 100);
}