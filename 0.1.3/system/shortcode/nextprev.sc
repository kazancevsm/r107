//<?
/*
+-------------------------------------------------------------------------------+
|	© е107 Клуб, 2010-2012. Все права защищены.									|
|	Сайт: http://www.e107club.ru												|
|	Почта: no-reply@e107club.ru													|
|	Файл: nextprev.sc															|
|	Версия: 3.2																	|
|	Кодировка: utf-8															|
|	Дата: 23.09.2012 05:05:05													|
|	Автор: © Кадников Александр	[Predator]										|
+-------------------------------------------------------------------------------+
|	© 2010-2012 е107 Club. All Rights Reserved.									|
|	Site: http://www.e107club.ru												|
|	Email: no-reply@e107club.ru													|
|	File: nextprev.sc															|
|	Version: 3.2																|
|	Charset: utf-8																|
|	Date: 23.09.2012 05:05:05													|
|	Author: © Alexander Kadnikov [Predator]										|
+-------------------------------------------------------------------------------+
*/

if (!function_exists('my_render_np')) {
	function my_render_np($perpage, $c, $current_start, $url){
        if($perpage * $c == $current_start) {
            $nppage = "<span class='this-page'>".($c+1)."</span> ";
        }
		else {
            $link = str_replace("[FROM]", ($perpage * $c), $url);
            $nppage = "<a href='{$link}'>".($c+1)."</a> ";
			}
            return $nppage;
		}
	}
 
global $pref;
 
include_lan(e_LANGUAGEDIR.e_LANGUAGE."/lan_np.php");
 
$parm_count = substr_count($parm, ",");
 
while($parm_count < 5){
        $parm .= ",";
        $parm_count++;
}
 
$p = explode(",", $parm, 6);
 
$total_items = intval($p[0]);
$perpage = intval($p[1]);
$current_start = intval($p[2]);
$url = trim($p[3]);
$caption = trim($p[4]);
$pagetitle = explode("|",trim($p[5]));
 
if($total_items < $perpage) {   return ""; }
 
$caption = (!$caption || $caption == "off") ? NP_3."&nbsp;" : $caption;
 
while(substr($url, -1) == "."){
        $url=substr($url, 0, -1);
}
 
$current_page = ($current_start/$perpage) + 1;
$total_pages = ceil($total_items/$perpage);
 
if($total_pages > 1){
        if(isset($pref['old_np']) && $pref['old_np']){
                // Привел нумерацию страниц в человеческий вид
                $nppage = '';
                if ($total_pages > 10) {
                        $current_page = ($current_start/$perpage)+1;
 
                        if ($current_page == 1) {
                                $nppage .= "<span class='AtStart'>◄</span>";
                        } else {
                                $link = str_replace("[FROM]", ($perpage * ($current_page - 2)), $url);
                                $nppage .= "<a href='{$link}' class='PrevLink'>◄</a>";
                        }
						
                        if ($current_page < 6){
                                if ($current_page < 4){
                                        for($c = 0; $c < 5; $c++) {
                                                $nppage .= my_render_np($perpage, $c, $current_start, $url);
                                        }
                                } else {
                                        for($c = 0; $c < $current_page + 2; $c++) {
                                                $nppage .= my_render_np($perpage, $c, $current_start, $url);
                                        }
                                }
                                $nppage .= "<span class='break'>...</span> ";
                        } else {
                                for($c = 0; $c < 2; $c++) {
                                        $nppage .= my_render_np($perpage, $c, $current_start, $url);
                                }
                        }
 
                        if (($current_page >= 6) && ($current_page <= ($total_pages - 4 - 1))){
                                $nppage .= "<span class='break'>...</span> ";
                                for($c = $current_page - 3; $c < $current_page + 2; $c++) {
                                        $nppage .= my_render_np($perpage, $c, $current_start, $url);
                                }
                                $nppage .= "<span class='break'>...</span> ";
                        }
 
                        if ($current_page > ($total_pages - 4 - 1)){
                                $nppage .= "<span class='break'>...</span> ";
                                if (($current_page >= ($total_pages - 1 - 1)) && ($current_page <= $total_pages)){
                                        for($c = ($total_pages - 4 - 1); $c < $total_pages; $c++) {
                                                $nppage .= my_render_np($perpage, $c, $current_start, $url);
                                        }
                                } else {
                                        for($c = ($current_page - 2 - 1); $c < $total_pages; $c++) {
                                                $nppage .= my_render_np($perpage, $c, $current_start, $url);
                                        }
                                }
                        } else {
                                for($c = ($total_pages - 1 - 1); $c < $total_pages; $c++) {
                                        $nppage .= my_render_np($perpage, $c, $current_start, $url);
                                }
                        }
                        if ($current_page == ($total_pages)) {
                                $nppage .= "<span class='AtEnd'>►</span>";
                        } else {
                                $link = str_replace("[FROM]", ($perpage * ($current_page)), $url);
                                $nppage .= "<a href='{$link}' class='NextLink'>►</a>";
                        }
                } 
				// Менее 10 страниц
				else {
                        if ($current_page == 1) {
                                $nppage .= "<span class='AtStart'>◄</span>";
                        } else {
                                $link = str_replace("[FROM]", ($perpage * ($current_page - 2)), $url);
                                $nppage .= "<a href='{$link}' class='PrevLink'>◄</a>";
                        }
						
						if($total_pages > 5) {
							if ($current_page == 1) {
									$nppage .= "<span class='AtStart'>◄◄</span>";
							} 
							else {
									$link = str_replace("[FROM]", '0', $url);
									$nppage .= "<a href='{$link}' class='PrevLink'>◄◄</a>";
							}
						}
 
                        for($c = 0; $c < $total_pages; $c++) {
                                $nppage .= my_render_np($perpage, $c, $current_start, $url);
                        }
						
						if($total_pages > 5) {
							if ($current_page == ($total_pages)) {
									$nppage .= "<span class='AtEnd'>►►</span>";
							} else {
									$link = str_replace("[FROM]", ($perpage * ($total_pages-1)), $url);
									$nppage .= "<a href='{$link}' class='NextLink'>►►</a>";
							}
						}
						
                        if ($current_page == ($total_pages)) {
                                $nppage .= "<span class='AtEnd'>►</span>";
                        } else {
                                $link = str_replace("[FROM]", ($perpage * ($current_page)), $url);
                                $nppage .= "<a href='{$link}' class='NextLink'>►</a>";
                        }
                }
                return $nppage;
        }
 
        // Использование выпадающего списка страниц
        $np_parm['template'] = "[PREV]&nbsp;&nbsp;[DROPDOWN]&nbsp;&nbsp;[NEXT]";
        $np_parms['prev'] = "&nbsp;&nbsp;&lt;&lt;&nbsp;&nbsp;";
        $np_parms['next'] = "&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;";
        $np_parms['np_class'] = 'tbox npbutton';
        $np_parms['dropdown_class'] = 'tbox npdropdown';
 
        if($cached_parms = getcachedvars('nextprev')) {
                $tmp = $cached_parms;
                foreach($tmp as $key => $val) {
                        $np_parms[$key]=$val;
                }
        }
 
        $prev="";
        $next="";
        if($current_page > 1) {
                $prevstart = ($current_start - $perpage);
                $link = str_replace("[FROM]", $prevstart, $url);
                $prev = "<a class='{$np_parms['np_class']}' style='text-decoration:none' href='{$link}'>{$np_parms['prev']}</a>";
        }
        if($current_page < $total_pages) {
                $nextstart = ($current_start + $perpage);
                $link = str_replace("[FROM]", $nextstart, $url);
                $next = "<a class='{$np_parms['np_class']}' style='text-decoration:none' href='{$link}'>{$np_parms['next']}</a>";
        }
        $dropdown = "<select class='{$np_parms['dropdown_class']}' name='pageSelect' onchange='location.href=this.options[selectedIndex].value'>";
        for($i = 1; $i <= $total_pages; $i++) {
                $sel = "";
                if($current_page == $i) {
                        $sel = " selected='selected' ";
                }
                $newstart = ($i-1)*$perpage;
                $link = str_replace("[FROM]", $newstart, $url);
                $c = $i-1;
                $title = ($pagetitle[$c]) ? $pagetitle[$c] : $i;
                $dropdown .= "<option value='{$link}' {$sel}>{$title}</option>\n";
        }
        $dropdown .= "</select>";
        $ret = $np_parm['template'];
        $ret = str_replace('[DROPDOWN]', $dropdown, $ret);
        $ret = str_replace('[PREV]', $prev, $ret);
        $ret = str_replace('[NEXT]', $next, $ret);
 
        return $caption.$ret;
}
 
return "";