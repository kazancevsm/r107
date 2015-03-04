<?php
/*
+-------------------------------------------------------------------------------+
|	© е107 Клуб, 2010-2012. Все права защищены.									|
|	Сайт: http://www.e107club.ru												|
|	Файл: Подключение jQuery библиотеки											|
|	Версия: 1.0																	|
|	Кодировка: utf-8															|
|	Дата: 10.04.2012 05:05:05													|
|	Автор: © Кадников Александр	[Predator]										|
|-------------------------------------------------------------------------------|
|	© 2010-2012 е107 Club. All Rights Reserved.									|
|	Site: http://www.e107club.ru												|
|	File: Connecting jQuery library												|
|	Version: 1.0																|
|	Charset: utf-8																|
|	Date: 10.04.2012 05:05:05													|
|	Author: © Alexander Kadnikov [Predator]										|
+-------------------------------------------------------------------------------+
*/

require_once("../class.php");

   if (!getperms("P")) {
      header("location:".e_HTTP."index.php");
      exit;
   }

   require_once(e_ADMIN."auth.php");
   
   global $pref;
   
	if (isset($_POST['save_settings'])) {
		$pref['jq_core'] = intval($_POST['jq_core']);
				
	save_prefs();
 
 $ns->tablerender('', '<div style="text-align:center; font-weight: bold;">'.ADLAN_160.'</div>');
}

  $text .= "
	<div class='r_header3'>
	    <div style='text-align:center'>
	<form method='post' action='".e_SELF."?".e_QUERY."' enctype='multipart/form-data'>
    <table style='width:100%;' class='r_border' cellspacing='0' cellpadding='0'>
	
	<tr>
		<td style='vertical-align: top; width:50%'>
			".ADLAN_159."
		</td>
		<td>
			<input type='checkbox' name='jq_core' class='tbox' value='1' ".($pref['jq_core'] == '1' ?" checked='checked'" :'')." />
		</td>
    </tr>
	<tr>
		<td colspan='2'>&nbsp;</td>
    </tr>
	
	<tr style='vertical-align:top'>
      <td colspan='3' style='text-align:center'>
       <input type='submit' name='save_settings' value='".ADLAN_158."' class='button' />
      </td>
    </tr>
    </table>
	</form>
    </div>
	</div><br />";

   $ns->tablerender(ADLAN_157, $text);

   require_once(e_ADMIN."footer.php");
   
?>