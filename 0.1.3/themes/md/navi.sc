return build_tree();
// $img = "<img class ='menu_img' src='".e_IMAGE_ABS."icons/".$row['link_button']."' alt='' />";
function build_tree($start = 0)
{
	global $tp, $parm;
	if (!$parm) $parm = 1;
	
	$sql = new db;
	
	if ($sql -> db_Select("links", "*", "link_parent = $start AND link_category = $parm AND  link_class IN (".USERCLASS_LIST.") ORDER BY link_order ASC"))
	{
		$text .= "<ul>";
		
		while ($row = $sql->db_Fetch())
		{
			$sql2 = new db;
			$have_child = $sql2 -> db_Select("links", "*", "link_parent = $row[link_id]  AND link_category = $parm AND link_class IN (".USERCLASS_LIST.") ORDER BY link_order ASC");
			
			$text .= "<li".($have_child ? " class='sub'" : "")."><a href ='".$tp -> replaceConstants($row['link_url'],TRUE)."'>".$img.$row['link_name']."</a>";
			if ($have_child) $text .= build_tree($row[link_id]);
			$text .="</li>";
		}
		$text .= "</ul>";
	}
	return $text;
}
