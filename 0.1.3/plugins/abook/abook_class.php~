<?
//description of variables
$conf_showrows = (int)$pref['ab_showrows'];
$num_page = (int)$_GET['num_page'];
$letter = $_GET['letter'];
$id = $_GET['id'];

// Задаём алфавит 
class alphaPages{ 
    var $ALPHA = 'А Б В Г Д Е Ж З И К Л М Н О П Р С Т У Ф Х Ц Ч Щ Ш Э Ю Я';
    
// Инициализация объекта. Установка начальных условий списка 
function alphaPages(){
   $conf_showrows = $pref["ab_showrows"];
   $this->sql = "SELECT * FROM ".MPREFIX."ab_gnl";
} 

//==========function input all notice==============//
function getList(){ 
$conf_showrows = $pref["ab_showrows"];
$query = mysql_query($this->sql);
$color = 1;
	$text ="<table valign=top align=left><tr><td class='fcaption' width='30%'><b>".AB_LIST_NAME."</td>"; 
	$text .="<td class='fcaption' width='15%'><b>".AB_LIST_MAG."</td>"; 
	$text .="<td class='fcaption' width='10%'><b>".AB_LIST_CITY."</b></td>"; 
	$text .="<td class='fcaption' width='10%'><b>".AB_LIST_ADDR."</td>"; 
	$text .="</tr>";  
	while($row = mysql_fetch_assoc($query)){
		$gnl_id = $row['gnl_id'];
		$gnl_name = $row['gnl_name'];
		$gnl_mag = $row['gnl_mag'];
		$gnl_city = $row['gnl_city'];
		$gnl_address = $row['gnl_address'];
		if ($row['gnl_check_admin']==AB_SEL_YES){
			if($color == 1) $theme_class = 'forumheader3';
			if($color == 2) $theme_class = 'forumheader2';
				$text .= "<tr>"; 
				$text .="<td class='$theme_class'><a href=?id=".$gnl_id.">".$gnl_name."</a></td>"; 
				$text .="<td class='$theme_class'><a href=?id=".$gnl_id.">".$gnl_mag."</a></td>"; 
				$text .="<td class='$theme_class'>".$gnl_city."</td>"; 
				$text .="<td class='$theme_class'>".$gnl_address."</td>"; 
				$text .="</tr>"; 
			}
			if($color == 2) $color = 0;
		$color++;
	}
$text .="</table>";
return $text;
}

//==========function input all notice==============//
function getRandomList(){ 
$conf_showrows = $pref["ab_showrows"];
$query = mysql_query($this->sql);
$color = 1;
	$text ="<table valign=top align=left><tr><td class='fcaption' width='30%'><b>".AB_LIST_NAME."</td>"; 
	$text .="<td class='fcaption' width='15%'><b>".AB_LIST_MAG."</td>"; 
	$text .="<td class='fcaption' width='10%'><b>".AB_LIST_CITY."</b></td>"; 
	$text .="<td class='fcaption' width='10%'><b>".AB_LIST_ADDR."</td>"; 
	$text .="</tr>";  
	while($row = mysql_fetch_assoc($query)){
		$gnl_id = $row['gnl_id'];
		$gnl_name = $row['gnl_name'];
		$gnl_mag = $row['gnl_mag'];
		$gnl_city = $row['gnl_city'];
		$gnl_address = $row['gnl_address'];
		if ($row['gnl_check_admin']==AB_SEL_YES){
			if($color == 1) $theme_class = 'forumheader3';
			if($color == 2) $theme_class = 'forumheader2';
				$text .= "<tr>"; 
				$text .="<td class='$theme_class'><a href=?id=".$gnl_id.">".$gnl_name."</a></td>"; 
				$text .="<td class='$theme_class'><a href=?id=".$gnl_id.">".$gnl_mag."</a></td>"; 
				$text .="<td class='$theme_class'>".$gnl_city."</td>"; 
				$text .="<td class='$theme_class'>".$gnl_address."</td>"; 
				$text .="</tr>"; 
			}
			if($color == 2) $color = 0;
		$color++;
	}
$text .="</table>";
return $text;
}
######### Набор фильтрующих список методов ############## 

// метод строит панель алфавитной навигации   
function makeAlphaNavBar(){
	$sql = "select DISTINCT(LEFT(UPPER(gnl_name),1)) as letter from ".MPREFIX."ab_gnl"; 
	$query = mysql_query($sql); 
		while($r = mysql_fetch_assoc($query)){ 
			$this->ALPHA = str_replace($r['letter'], '<a href="?letter='.$r['letter'].'">'.$r['letter'].'</a>' , $this->ALPHA); 
		} 
	return $this->ALPHA;
}

// метод строит панель постраничной навигации 
function makePageNavBar(){
	$query = mysql_query($this->sql);
	$total_items = ceil(mysql_num_rows($query));
	return $total_items; 
}

// Метод фильтрует список по букве
function setLetter(){
$letter = $_GET['letter'];
	$this->sql .= " WHERE gnl_name like '".$letter."%'";
} 

  // Метод ставит ограничения по странице   
function setPage(){
 
	$this->setOrder(); 
	if(!IsSet($num_page)) $num_page=0;
	$this->sql .= " LIMIT ".($num_page).",".(40);
	
}

// метод задаёт порядок сортировки 
function setOrder(){ 
    $this->sql .= " ORDER BY gnl_name"; 
}

//==========function input profile organization==============//
function profile(){ 
$this->sql .= " WHERE gnl_id=".$_GET['id'];
$query = mysql_query($this->sql); 
$color = 1;
$text ="<table style='width:100%' valign=top><tr >";
	while($row = mysql_fetch_assoc($query)){ 
	    if($row['gnl_check_admin']==AB_SEL_YES){
		$text .= "<td rowspan=5 widht=20% class='forumheader2'>".$row['gnl_img']."</td></tr>"; 
		$text .= "<tr><td class='forumheader2' width='30%'><img src='".e_PLUGIN."abook/ab_pictures/".$row['gnl_logo']."' alt='".$row['gnl_name']."'></td>"; 
		$text .= "<td class='forumheader2' valign=top>".AB_LIST_NAME.":"; 
		$text .= "<b>".$row['gnl_name']."</b>"; 
		$text .= "<br>".AB_LIST_MAG.": <b>".$row['gnl_mag']."</b>"; 
		$text .= "<br>".AB_LIST_ADDR.": <b>".$row['gnl_address'].", ".$row['gnl_city']."</b>"; 
		$text .= "<br>".AB_LIST_SITE.": <b>".$row['gnl_site']."</b>"; 
		$text .= "<br>".AB_LIST_MAIL.": <b>".$row['gnl_mail']."</b>"; 
		$text .= "<br>".AB_LIST_ICQ.": <b>".$row['gnl_icq']."</b>"; 
		$text .= "<br></td></tr>"; 
	    }
	}
$text .="</table>";

$this1->sql = "SELECT * FROM ".MPREFIX."ab_gnl";   
$this1->sql .= " WHERE gnl_id=".$_GET['id'];
	$query1 = mysql_query($this1->sql);
	$text .="<table style='width:100%' valign=top><tr>"; 
	$text .="<td class='fcaption' width='50%'>".AB_LIST_DEV."</td>"; 
	$text .="<td class='fcaption' width='50%'>".AB_LIST_DESC."</td>"; 
	$text .="</tr>"; 
	while($row = mysql_fetch_assoc($query1)){   
		$text .= "<tr><td class='forumheader2'>".$row['gnl_devision']."</td>";
		$text .= "<td class='forumheader2'>".$row['gnl_desc']."</td></tr>";
	}
	$text .="</table>";
return $text;
}

#########################################################   

// the end of class 
}
?>