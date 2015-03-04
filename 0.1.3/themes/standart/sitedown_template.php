<?php

if (!defined('e107_INIT')) { exit; }

// ##### SITEDOWN TABLE -----------------------------------------------------------------
if(!isset($SITEDOWN_TABLE))
{
	$SITEDOWN_TABLE = (defined("STANDARDS_MODE") ? "" : "<?xml version='1.0' encoding='".CHARSET."' "."?".">")."<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
	";
	$SITEDOWN_TABLE .= "
		<html xmlns='http://www.w3.org/1999/xhtml'".(defined("TEXTDIRECTION") ? " dir='".TEXTDIRECTION."'" : "").(defined("CORE_LC") ? " xml:lang=\"".CORE_LC."\"" : "").">
			<head>
				<meta http-equiv='content-type' content='text/html; charset=".CHARSET."' />
				<meta http-equiv='content-style-type' content='text/css' />\n
				<link rel='stylesheet' href='".THEME_ABS."style.css' type='text/css' media='all' />
				<title>{SITEDOWN_TABLE_PAGENAME}</title>
			</head>
			<body>
				<center>
				<div style='text-align:center;width:900px;'>
					<div style='text-align:center'>
						{LOGO}
					</div>
					<hr />
					<div style='background:#fff;text-align:left;padding:20px;font-size:14px; color:black; font-family:Tahoma,Verdana,Arial,Helvetica'>
						<div style='width:860px;'>
							{SITEDOWN_TABLE_MAINTAINANCETEXT}
						</div>
					</div>
				</div>
				<center>
			</body>
		</html>";
}
// ##### ------------------------------------------------------------------------------------------
?>
