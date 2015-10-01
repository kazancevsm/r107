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
//	var cat = $cat;
	
	p=document.getElementById("sort").value;
	if (p==sort1){
		document.location.href = "vtrade.php?page=categories&cat=0&sort=1";
	}
	if (p==sort2){
		document.location.href = "vtrade.php?page=categories&cat=0&sort=2";
	}
	if (p==sort3){
		document.location.href = "vtrade.php?page=categories&cat=0&sort=3";
	}
	if (p==sort4){
		document.location.href = "vtrade.php?page=categories&cat=0&sort=4";
	}
}