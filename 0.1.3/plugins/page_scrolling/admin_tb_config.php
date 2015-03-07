<?php
/*
+ ------------------------------------------------------------------------------+
|	© е107 Клуб 2010-2011. Все права защищены.									|
|	Сайт: http://www.e107club.ru												|
|	Почта: plugin@e107club.ru													|
|	Плагин: Прокрутка страницы													|
|	Версия: 1.2																	|
|	Дата: 07.07.2011 05:05:05													|
|	Автор: © Кадников Александр	[Predator]										|
+-------------------------------------------------------------------------------+
*/

require_once("../../class2.php");
include_once(e_PLUGIN."page_scrolling/languages/".e_LANGUAGE.".php");

   if (!getperms("P")) {
      header("location:".e_HTTP."index.php");
      exit;
   }

   require_once(e_ADMIN."auth.php");
   
   global $pref, $ns, $tp;
   
	if (isset($_POST['save_settings'])) {
		$pref['tb_colorground'] = $tp->toDB($_POST['tb_colorground']);
		if( $_POST['tb_size'] < 20 || $_POST['tb_size'] > 128) { $_POST['tb_size'] = 32; }
		$pref['tb_size'] = $tp->toDB($_POST['tb_size']);
		if( $_POST['tb_radius'] < 0 || $_POST['tb_radius'] > 30) { $_POST['tb_radius'] = 6; }
		$pref['tb_radius'] = $tp->toDB($_POST['tb_radius']);
		if( $_POST['tb_right'] < 0 || $_POST['tb_right'] > 1000) { $_POST['tb_right'] = 15; }
		$pref['tb_right'] = $tp->toDB($_POST['tb_right']);
		if (count($_FILES) > 0)
		{
			while (list($key, $value) = each($_FILES['tb_icon']['name']))
			{
				if (!empty($value))
				{
					$filename = $value;
					$add = e_PLUGIN.'page_scrolling/icons/'. $filename;
					$extn = strtolower(substr($_FILES['tb_icon']['name'][$key], -3, 3));
					$size = getimagesize($_FILES['tb_icon']['tmp_name'][$key]);
					if ($extn == 'png' || $extn == 'gif' || $extn == 'jpg')
					{
						if($size[0] <= 128 && $size[1] <= 128){
						move_uploaded_file($_FILES['tb_icon']['tmp_name'][$key], $add);
						chmod($add, 0755);
						}
						else{
							$ns->tablerender('', '<div style="text-align:center; font-weight: bold;">'.LAN_TB_CONF_15." "."<span style='font-size: 10pt; color:#3a599d'>".$_FILES['tb_icon']['name'][$key]."</span>"." ".LAN_TB_CONF_17."<br />".LAN_TB_CONF_19.'</div>');
						}
					}
					else
					{
						$ns->tablerender('', '<div style="text-align:center; font-weight: bold;">'.LAN_TB_CONF_15." "."<span style='font-size: 10pt; color:#3a599d'>".$_FILES['tb_icon']['name'][$key]."</span>"." ".LAN_TB_CONF_16."<br />".LAN_TB_CONF_18.'</div>');
					}
				}
			}
		}

		$pref['tb_icons'] = $tp->toDB($_POST['tb_icons']);
		$pref['tb_js'] = intval($_POST['tb_js']);
		
		
	save_prefs();
 
 $ns->tablerender('', '<div style="text-align:center; font-weight: bold;">'.LAN_TB_CONF_03.'</div>');
}

$tb_size = '<select style="padding:2px; width: 90px" class="tbox" name="tb_size">';
for($i=20;$i<=128;$i++){
 $tb_size .= '<option value="'.$i.'" '.($pref['tb_size']==$i?'selected':'').'>'.$i.'px</option>';
}
$tb_size .= '</select>';

$tb_radius = '<select style="padding:2px; width: 90px" class="tbox" name="tb_radius">';
for($i=0;$i<=30;$i++){
 $tb_radius .= '<option value="'.$i.'" '.($pref['tb_radius']==$i?'selected':'').'>'.$i.'px</option>';
}
$tb_radius .= '</select>';

$tb_right = '<select style="padding:2px; width: 90px" class="tbox" name="tb_right">';
for($i=0;$i<=1000;$i++){
 $tb_right .= '<option value="'.$i.'" '.($pref['tb_right']==$i?'selected':'').'>'.$i.'px</option>';
}
$tb_right .= '</select>';

$tb_dir = e_PLUGIN.'page_scrolling/icons';
        $tb_icons = array();
        if ($dh = opendir($tb_dir))
        {
            $dynalogo_plugin = true;
            while (($file = readdir($dh)) !== false)
            {
                $filecheck = strtolower($file);
                if (strpos($filecheck, '.png') > 0 || strpos($filecheck, '.gif') > 0 || strpos($filecheck, '.jpg') > 0)
                {
                    $tb_icons[] = $file;
                }
            }
            sort($tb_icons);
        }
        closedir($dh);
        $tb_sel = "<select name='tb_icons' class='tbox'>";
        $tb_sel .= "<option value='' >".LAN_TB_CONF_14."</option>";
        foreach($tb_icons as $row)
        {
            $tb_sel .= "<option value='".$row."' ".($row == $tp->toFORM($pref['tb_icons'])?"selected='selected'":"") . ">" .$row."</option>";
        }
        $tb_sel .= "</select>";

  $text .= "
	<div class='forumheader' style='text-align: center; font-weight: bold; font-size: 12px;'>".LAN_TB_CONF_02."</div><br />
	<div class='forumheader3'>
	    <div style='text-align:center'>
   <form enctype='multipart/form-data' method='post' action='".e_SELF."?".e_QUERY."'>
    <table style='width:100%;' class='fborder' cellspacing='0' cellpadding='0'>

	<tr>
		<td style='vertical-align: top'>
			".LAN_TB_CONF_04."
		</td>
		<td>
			<input type='text' name='tb_colorground' value='".$pref['tb_colorground']."' maxlength='6' class='tbox' /> ".LAN_TB_CONF_10."
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td style='vertical-align: top'>
			".LAN_TB_CONF_05."
		</td>
		<td>
			".$tb_size."
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td style='vertical-align: top'>
			".LAN_TB_CONF_06."
		</td>
		<td>
			".$tb_radius."
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td style='vertical-align: top'>
			".LAN_TB_CONF_07."
		</td>
		<td>
			".$tb_right."
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td style='vertical-align: top'>
			".LAN_TB_CONF_09."
		</td>
		<td>
			<input type='checkbox' name='tb_js' class='tbox' value='1' ".($pref['tb_js'] == '1' ?" checked='checked'" :'')." />
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td style='vertical-align: top'>
			".LAN_TB_CONF_12."
		</td>
		<td>
			".$tb_sel."
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td style='vertical-align: top'>
			".LAN_TB_CONF_13."
		</td>
		<td>
			<input class='tbox' type='file' name='tb_icon[]' size='50%' />"."\n"."
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	
	<tr style='vertical-align:top'>
      <td colspan='2' style='text-align:center'>
       <input type='submit' name='save_settings' value='".LAN_TB_CONF_11."' class='button' />
      </td>
    </tr>
    </table>
   </form>
        </div>
		</div><br />";

   $text .= "<div class='forumheader' style='text-align: center;'>".LAN_TB_COPYRIGHT."</div><br />
   ";

   $ns->tablerender(LAN_TB_CONF_01, $text);

   require_once(e_ADMIN."footer.php");
?>