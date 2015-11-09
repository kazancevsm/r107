<?
//description of variables
$page = $_GET['page'];

class alphaPages{ 
// Задаём алфавит 
    var $ALPHA = '<b> А Б В Г Д Е Ж З И К Л М Н О П Р С Т У Ф Х Ц Ч Щ Ш Э Ю Я <b>'; 
// Инициализация объекта. Установка начальных условий списка 
function alphaPages(){ 
    $this->sql = "SELECT * FROM ".MPREFIX."ab_gnl"; 
} 

//==========function input all notice==============//
function getList(){ 
$query = mysql_query($this->sql); 
$color = 1;
$text .="<table valign=top align=left><tr><td class='fcaption' width='30%'><b>".AB_LIST_NAME."</td>
	<td class='fcaption' width='15%'><b>".AB_LIST_MAG."</td>
	<td class='fcaption' width='10%'><b>".AB_LIST_CITY."</b></td>
	<td class='fcaption' width='10%'><b>".AB_LIST_ADDR."</td>
		</tr>";  
while($r = mysql_fetch_assoc($query)){ 
	if ($r['gnl_check_admin']==AB_SEL_YES){
	if($color == 1){
	$text .= "<tr>
		<td class='forumheader3'><a href=?id=".$r['gnl_id'].">".$r['gnl_name']."</a></td>
		<td class='forumheader3'><a href=?id=".$r['gnl_id'].">".$r['gnl_mag']."</a></td>
		<td class='forumheader3'>".$r['gnl_city']."</td>
		<td class='forumheader3'>".$r['gnl_address']."</td>
		</tr>"; 
	}
	if($color == 2){
	$text .= "<tr>
		<td class='forumheader2'><a href=?id=".$r['gnl_id'].">".$r['gnl_name']."</a></td>
		<td class='forumheader2'><a href=?id=".$r['gnl_id'].">".$r['gnl_mag']."</a></td>
		<td class='forumheader2'>".$r['gnl_city']."</td>
		<td class='forumheader2'>".$r['gnl_address']."</td>
		</tr>";
	$color =0;
	}
$color++;
	}
} 
$text .="</table>";
return $text;
}
//==========function input profile organization==============//
function profile(){ 
	$this->sql .= " WHERE gnl_id=".$_GET['id'];
	$query = mysql_query($this->sql); 
	$color =1 ;
	$ret ="<table style='width:100%' valign=top><tr >";
	while($r = mysql_fetch_assoc($query)){ 
	  if ($r['gnl_check_admin']==AB_SEL_YES){
		$ret .= "<td rowspan=5 widht=20% class='forumheader2'>".$r['gnl_img']."</td></tr>
		<tr><td class='forumheader2' width='30%'><img src='".e_PLUGIN."abook/ab_pictures/".$r['gnl_logo']."' alt='".$r['gnl_name']."'></td>
		<td class='forumheader2' valign=top>
		".AB_LIST_NAME.":  <b>".$r['gnl_name']."</b>
		<br>".AB_LIST_MAG.": <b>".$r['gnl_mag']."</b>
		<br>".AB_LIST_ADDR.": <b>".$r['gnl_address'].", ".$r['gnl_city']."</b>
		<br>".AB_LIST_SITE.": <b>".$r['gnl_site']."</b>
		<br>".AB_LIST_MAIL.": <b>".$r['gnl_mail']."</b>
		<br>".AB_LIST_ICQ.": <b>".$r['gnl_icq']."</b>
		<br></td></tr>"; 
	  }
$ret .="</table>";
	}
 		
$this1->sql = "SELECT * FROM ".MPREFIX."ab_gnl";   
$this1->sql .= " WHERE gnl_id=".$_GET['id'];

    $query1 = mysql_query($this1->sql);
  $ret .="<table style='width:100%' valign=top><tr>
	<td class='fcaption' width='50%'>".AB_LIST_DEV."</td>
	<td class='fcaption' width='50%'>".AB_LIST_DESC."</td>
	</tr>"; 
	while($r = mysql_fetch_assoc($query1)){   
	  $ret .= "<tr><td class='forumheader2'>".$r['gnl_devision']."</td>
		    <td class='forumheader2'>".$r['gnl_desc']."</td></tr>"; 
	   }
$ret .="</table>";
return $ret;
}

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
    $maxpage = ceil(mysql_num_rows($query)/40); 
    for($i=0;$i<$maxpage;$i++){ 
      $ret.='<a href="?letter='.$_GET['letter'].'&page='.$i.'">' .($i+1). '</a> |'; 
    } 
    return $ret; 
  }   
######### Набор фильтрующих список методов ############## 
  // Метод фильтрует список по букве    
  function setLetter(){ 
    $this->sql .= " WHERE gnl_name like '".$_GET['letter']."%'"; 
  } 
  // Метод ставит ограничения по странице   
  function setPage(){ 
    $this->setOrder(); 
    if(empty($_GET['page'])) $page=0; 
    else $page = $_GET['page']; 
    $this->sql .= " LIMIT ".($page*40).",".(40); 
  } 
  // метод задаёт порядок сортировки 
  function setOrder(){ 
    $this->sql .= " ORDER BY gnl_name"; 
  }   
#########################################################   

// the end of class 
}
?>