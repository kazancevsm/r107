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

	header('Content-type: text/css');
	@require_once('../../class.php');
	
	global $pref;
	
	echo "@charset 'utf-8';
	.top-button{
		background: #".$pref['tb_colorground']." url(".e_PLUGIN."page_scrolling/icons/".$pref['tb_icons'].") center center no-repeat;			
		color: #fff;
		width: ".$pref['tb_size']."px;
		height: ".$pref['tb_size']."px;
		font-family: verdana;
		border-radius: ".$pref['tb_radius']."px;
		-moz-border-radius: ".$pref['tb_radius']."px;
		-webkit-border-radius: ".$pref['tb_radius']."px;
		-o-border-radius: ".$pref['tb_radius']."px;
		cursor: pointer;
		padding: 15px;
		margin-right: ".$pref['tb_right']."px;
		}
		
";

?>