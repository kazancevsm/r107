<?php
/* LIST CATEGORIES GENERAL cat_sub=0*/
// {$CAT_SHORT_DESC}
// {$CAT_DESC}

$LIST_CAT_GENERAL = "
	<tr>
	<td style='width:200px' rowspan=2 class='fcaption'><div style='background:#fff; overflow:hidden;'><a href=catalog.php?page=list&cat={$CAT_ID}>{$CAT_PIC}</a></div></td>
	<td style='width:auto' class='fcaption'><a href=catalog.php?page=list&cat={$CAT_ID}><b><h3>{$CAT_NAME}</h3></b></a></td>
	</tr><tr>
	<td class='fcaption'>{$CAT_SHORT_DESC}</td>
	</tr>
	";
	
$LIST_CAT_SUB = "
	<tr>
	<td style='width:200px' rowspan=2 class='fcaption'><div style='background:#fff; overflow:hidden;'><a href=catalog.php?page=list&cat={$CAT_ID}>{$CAT_PIC}</a></div></td>
	<td style='width:auto' class='fcaption'><a href=catalog.php?page=list&cat={$CAT_ID}><b><h3>{$CAT_NAME}</h3></b></a></td>
	</tr><tr>
	<td class='fcaption'>{$CAT_SHORT_DESC}</td>
	</tr>
	";

$LIST_NOMENCLATURE = "
	<tr>
	<td class='r_header1' width=100px>
	<div style=' background:#fff; overflow:hidden;'><a href='".e_PLUGIN."catalog/catalog.php?page=det&id={$NOM_ID}'>{$NOM_PIC}</a></div>
	</td>
	<td class='r_header1' width=500px><a href='".e_PLUGIN."catalog/catalog.php?page=det&id={$NOM_ID}'><font size=2><b>{$NOM_NAME}</b></font></a><br>
	
	$NOM_SHORT_DESC...<a href='".e_PLUGIN."catalog/catalog.php?page=det&id=$NOM_ID'><br>Подробное описание >>></a>
	</td>
	<td class='r_header1' width=140px><b>$NOM_PRICE</b></td>
	</tr>
	";

$DETAIL_NOMENCLATURE = "
<div width=100%>
	<div width=100%><b><h3>{$NOM_NAME}</h3></b>&nbsp;&nbsp;&nbsp;<b>{$NOM_PRICE}</b></div>
	<br><hr width=100% size=1/>
	<div style='width:200px;float:left;'> 
	<a href='#' onClick=\"document.getElementById('r_window_block').style.display='block'; return false;\" >{$NOM_PIC_PRE}</a>
	</div>
	<div><br>{$NOM_DESC}<br></div>
</div>
<div id='r_window_block' class='r_window_block'>
	<div class='r_window_dialog'>
		<div class='r_window_caption'>".LAN_IMG_PIC."</div>
		<div class='r_window_close'><a href='#' onClick=\"document.getElementById('r_window_block').style.display='none'; return false;\" >".LAN_BUT_CLOSE."</a></div>
		<div class='r_window_img'>
			<div style='vertical-align:middle; margin:0 auto; '>{$NOM_PIC}</div>
		</div>
	 </div>  
</div>
";


?>
