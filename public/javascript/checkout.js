function rentFunction(x){
	var serial = $(x).parent().next().text();
	var cat = $(x).parent().next().next().text();
	var manu = $(x).parent().next().next().next().text();
	var model = $(x).parent().next().next().next().next().text();


	window.location.href = 'rental.php?s='+serial+'&c='+cat+'&ma='+manu+'&mo='+model;


}