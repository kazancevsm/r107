<?php

if (!defined('e107_INIT')) { exit; }

$text  ="<div style='text-align:center'>\n<a href='".SITEURL."'><img src='".(strstr(SITEBUTTON, "http:") ? SITEBUTTON : e_FILE."buttons/".SITEBUTTON)."' alt='".SITENAME."' style='border: 0px; width: 88px; height: 31px' /></a>\n</div>";
$text .= "".SITEBUTTON_MENU_L2."";
$text .="<textarea rows=5>\n<a href='".SITEURL."'><img src='".SITEURL."".(strstr(SITEBUTTON, "http:") ? SITEBUTTON : e_FILE."buttons/".SITEBUTTON)."' alt='".SITENAME."' style='border: 0px; width: 88px; height: 31px' /></a>\n</textarea>";

$ns->tablerender(SITEBUTTON_MENU_L1, $text, 'sitebutton');
?>