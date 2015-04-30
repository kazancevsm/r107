function seltag() {
	var p;
	var sort1;
	var sort2;
	var sort3;
	var sort4;
	sort1='ORDER BY `nom_price1` ASC';
	sort2='ORDER BY `nom_price1` DESC';
	sort3='ORDER BY `nom_name` ASC';
	sort4='ORDER BY `nom_name` DESC';
   
	p=document.getElementById("sort").value;
	if (p==sort1){
		p=1;
		document.location = "part"+p+".php";
	}
	if (p==sort2){
		p=2;
		document.location = "part"+p+".php";
	}
	if (p==sort3){
		p=3;
		document.location = "part"+p+".php";
	}
	if (p==sort4){
		p=4;
		document.location = "part"+p+".php";
	}
}