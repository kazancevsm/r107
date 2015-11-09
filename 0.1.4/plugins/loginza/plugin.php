<?php
/*
+-------------------------------------------------------------------------
|
|     Loginza plugin version 0.5.1 for e107
|
|     Author: Evlanov Alexander (Kapman)
|     alex@aleksander.org.ru
|     http://free-lance.ru/users/kapman
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+-------------------------------------------------------------------------
*/
@include_once(e_PLUGIN.'loginza/languages/'.e_LANGUAGE.'-'.CHARSET.'.php');

// Plugin info
$eplug_name 		= 'Loginza';
$eplug_version 		= '0.5.1';
$eplug_description  = LOGINZA_DESC;
$eplug_author		= 'Evlanov Alexander [Kapman]';
$eplug_email		= 'alex@aleksander.org.ru';
$eplug_url			= 'http://free-lance.ru/users/kapman';
$eplug_compatible	= 'e107v0.7.2++';

// Name of the plugin's folder
$eplug_folder		= 'loginza';

$eplug_status = TRUE;

// Icon image
$eplug_icon 		= $eplug_folder.'/images/loginza_32.png';
$eplug_icon_small 	= $eplug_folder.'/images/loginza.png';

$eplug_prefs = array(
	'loginza_db' => 'loginza',
	'loginza_lang' => 'ru',
	'loginza_providers' => array(
								'google',
								'yandex',
								'mailruapi',
								'mailru',
								'vkontakte',
								'facebook',
								'twitter',
								'loginza',
								'myopenid',
								'webmoney',
								'rambler',
								'flickr',
								'lastfm',
								'verisign',
								'aol',
								'steam',
								'openid',
								'livejournal',
								'odnoklassniki',
							),
	'loginza_menu_title' => LOGINZA_ENTER_CAP,
	'loginza_connect' => '0',
	'loginza_widget_id' => '',
	'loginza_api_signature' => '',
	'loginza_secure_login' => '0'
);

// Name of the admin configuration file
$eplug_conffile    = 'admin_loginza.php';

// List of preferences
$eplug_table_names = array(
	'loginza'
);

// SQL
$eplug_tables = array(
	"CREATE TABLE `".MPREFIX."loginza` (
		`id` int(8) NOT NULL auto_increment,
		`user_id` int(8) NOT NULL,
		`provider` varchar(120) NOT NULL,
		`identity` varchar(120) NOT NULL,
		`hide` int(1) NOT NULL,
		PRIMARY KEY  (`id`)
	) TYPE=MyISAM;"
);

// Update to 0.5
$upgrade_alter_tables = array(
   "ALTER TABLE `".MPREFIX."loginza` ADD hide int(1) NOT NULL"
);

?>