<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©Steve Dunstan 2001-2002
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/powered_by_menu/powered_by_menu.php $
|     $Revision: 11678 $
|     $Id: powered_by_menu.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/
if (!defined('e107_INIT')) { exit; }

$text = "
<div class='power_by'>
	<div class='power_by_spacer'>
		<a href='http://osgroup.pro' rel='external'>
			<img src='".e_PLUGIN_ABS."powered_by_menu/images/osgroup.png' alt='Open Source Group' style='border: 0px; width: 88px; height: 31px' />
		</a>
	</div>
	<div class='power_by_spacer'>
		<a href='http://e107club.ru' rel='external'>
			<img src='".e_PLUGIN_ABS."powered_by_menu/images/e107club.png' alt='Клуб e107' style='border: 0px; width: 88px; height: 31px' />
		</a>
	</div>
	<div class='power_by_spacer'>
		<a href='http://e107.org' rel='external'>
			<img src='".e_PLUGIN_ABS."powered_by_menu/images/e107.png' alt='e107' style='border: 0px; width: 88px; height: 31px' />
		</a>
	</div>
	<div class='power_by_spacer'>
		<a href='http://php.net' rel='external'>
			<img src='".e_PLUGIN_ABS."powered_by_menu/images/php.gif' alt='PHP' style='border: 0px; width: 88px; height: 31px' />
		</a>
	</div>
	<div class='power_by_spacer'>
		<a href='http://mysql.com' rel='external'>
			<img src='".e_PLUGIN_ABS."powered_by_menu/images/mysql.png' alt='MySQL' style='border: 0px; width: 88px; height: 31px' />
		</a>
	</div>
</div>";
$ns -> tablerender(POWEREDBY_L1,  $text, 'powered_by');
?>