<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================
/* $Id: e_search.php 11346 2010-02-17 18:56:14Z secretr $ */
if (!defined('e107_INIT')) { exit; }

include_lan(e_PLUGIN."md_vtrade/languages/".e_LANGUAGE."/lan_content_search.php");

$search_info[] = array( 'sfile' => e_PLUGIN.'md_vtrade/search/search_parser.php', 'qtype' => 'Магазин', 'refpage' => 'vtrade.php', 'advanced' => e_PLUGIN.'md_vtrade/search/search_advanced.php');

