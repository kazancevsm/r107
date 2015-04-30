<?php
/*
+---------------------------------------------------------------+
|	MGMshop Plugin for e107
|
|	Yuri Titov
|	http://mgmarket.ru
|	admin@mgmarket.ru
|
|	Плагин магазина для большого количества товаров с возможностью
|	интеграции с 1С
+---------------------------------------------------------------+
*/
//Created by MGMarket (admin@mgmarket.ru, ICQ: 294-237-169)
//Скрипт управления товарами на складе продавца, имеющимися в наличии.

//---------------------------------------------
// Страница добавления прайсов


require_once("../../../class2.php");
if(!getperms("P")){header("location:".e_BASE."index.php"); exit; }
require_once(e_HANDLER."form_handler.php");
require_once(e_HANDLER."userclass_class.php");
require_once(e_ADMIN."auth.php");
include_once("function.php");
session_name("base");
session_start("base");
require_once("function.php");


if(isset($_POST['save']))
{
	$trans=transliterate($_POST['catalog_name1']);
	$file=$trans.".csv";
	$dir = e_PLUGIN.'MGMshop/v_price/';
	$filename=$dir.basename($file);
	fopen($filename, 'w');

	$query_savec = "SELECT * FROM `".MPREFIX."category` WHERE `cat_option`='".$_POST['catalog']."' ORDER BY `cat_id`";
	$result_savec = mysql_query ($query_savec) or die ("Query failed");
	while($line_savec = mysql_fetch_array($result_savec))
	{
		//запишем в файл категорию
		$categ=";;".$line_savec['cat_name'].";;;";
		if(is_writable($filename))
		{
			if(!$handle = @fopen($filename, 'a'))
			{
				echo "<div align='center'><b>Не могу открыть файл ($filename)! Возможно файл открыт другой программой.<br />
						Закройте файл и вернитесь для повторения процедуры.</b><br />
							<form action='".e_SELF."' method='POST'>
								<input class='class_button' type='submit' value='Вернуться'>
							</form>
						</div>";
				exit;
			}
			// Записываем $somecontent в наш открытый файл.
			if(fwrite($handle, $categ."\r\n") === FALSE)
			{
				echo "Не могу произвести запись в файл ($filename)";
				exit;
			}
			fclose($handle);
		}
		else
		{
			echo "Файл $filename недоступен для записи";
		}

		$categ=$line_savec['cat_name'];
		$query_save = "SELECT * FROM `".MPREFIX."item` WHERE `itemcat_id`='".$line_savec['cat_id']."' ORDER BY `item_id`";
		$result_save = mysql_query ($query_save) or die ("Query failed");
		while($line_save = mysql_fetch_array($result_save))
		{
			$somecontent=$line_save['item_img'].";".$line_save['item_art'].";".$line_save['item_name'].";".$line_save['item_price'].";".$line_save['item_amount'];
			if(is_writable($filename))
			{
				if(!$handle = fopen($filename, 'a'))
				{
					echo "Не могу открыть файл ($filename)";
					exit;
				}
				// Записываем $somecontent в наш открытый файл.
				if(fwrite($handle, $somecontent."\r\n") === FALSE)
				{
					echo "Не могу произвести запись в файл ($filename)";
					exit;
				}
				fclose($handle);
			}
			else
			{
				echo "Файл $filename недоступен для записи";
			}
		}
	}

	// загружаем полученный файл на локальный компьютер
	$name=$file;
	$file1=$filename;
	$sss=output_file($file1,$name);
	unlink($file1);
}
if(isset($_POST['save_shab']))
{
	// загружаем полученный файл на локальный компьютер
	$name="proba.csv";
	$file1=e_PLUGIN.'MGMshop/v_price/'.basename($name);
	$sss=output_file($file1,$name);
}

// загружаем на сервер файл прайса в выбранный каталог
if(!empty($_FILES) and !isset($_POST['add_x']) and !isset($_POST['save']) and $sss==FALSE and !isset($_POST['item']) and !isset($_POST['catal_id']))
{
	// Каталог, в который мы будем принимать файл:
	$uploaddir = e_PLUGIN.'MGMshop/v_price/';
	$uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);

	// Копируем файл из каталога для временного хранения файлов:
	if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
	{
		echo "<script>alert('<h3>Файл успешно загружен на сервер</h3>');</script>";// document.location = 'admin.php';
		$handle= fopen(e_PLUGIN."MGMshop/v_price/".$_FILES['uploadfile']['name']."", "r");
		while(($data = fgetcsv($handle, 1000, ";")) !== FALSE)
		{
			$pri[]=$data;
		}
		$catalog=$_POST['prise_id'];
		insert_category($pri, $catalog);
		print(insert_items($pri, $catalog));

		$filename=$uploadfile;
		// Открываем файл
		$fd = fopen($filename, "w");
		// Обнуляем файл
		fputs($fp, "");
		trim($fp);
		// Закрываем файл
		fclose($fd);
		fclose($handle);
		unlink($filename);
	}
	else
	{
		echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
	}
}
// если добавляем каталог
if(isset($_POST['add_x']) and !empty($_POST['catalog_name']))
{
	if(!empty($_FILES['uploadfile']['name']))
	{
		// Каталог, в который мы будем принимать файл:
		$uploaddir = e_PLUGIN.'MGMshop/images/catalog/';
		$uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);

		// Копируем файл из каталога для временного хранения файлов:
		if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
		{
			echo "<script>alert('<h3>Файл успешно загружен на сервер</h3>');</script>";
		}
		else
		{
			echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
		}
	}
	mysql_query("INSERT INTO `".MPREFIX."catalog` VALUES(NULL, '".$_POST['catalog_name']."', '".$uploadfile."', '');") or die(mysql_error());
	unset($_POST);
}

// если изменяем каталог выбираем его
if($_GET['id']!=="default" and !isset($_POST['edit_x']))
{
	$query = "SELECT * FROM `".MPREFIX."catalog` WHERE `catalog_id`='".$_GET['id']."' LIMIT 1";
	$result = mysql_query ($query) or die ("Query failed");
	$catal=mysql_fetch_array($result);
}

// если выбрали каталог для загрузки  прайса выводим его
if(isset($_GET['price_id']))
{
	$query2 = "SELECT * FROM `".MPREFIX."catalog` WHERE `catalog_id`='".$_GET['price_id']."' LIMIT 1";
	$result2 = mysql_query ($query2) or die ("Query failed");
	$catal2=mysql_fetch_array($result2);
}

// если выбрали каталог для выгрузки прайса выводим его
if(isset($_GET['price_id_out']))
{
	$query2 = "SELECT * FROM `".MPREFIX."catalog` WHERE `catalog_id`='".$_GET['price_id_out']."' LIMIT 1";
	$result2 = mysql_query ($query2) or die ("Query failed");
	$catal23=mysql_fetch_array($result2);
}

// если каталог выбран для редактирования и нажата изменить
if(isset($_POST['edit_x']) and !empty($_POST['catalog_id']))
{
	if(!empty($_FILES['uploadfile']['name']))
	{
		@unlink($_POST['catalog_img']);
		// Каталог, в который мы будем принимать файл:
		$uploaddir = e_PLUGIN.'MGMshop/images/catalog/';
		$uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
		$uploadfile=transliterate($uploadfile);
		// Копируем файл из каталога для временного хранения файлов:
		if (copy($_FILES['uploadfile']['tmp_name'], $uploadfile))
		{
			echo "<script>alert('<h3>Файл успешно загружен на сервер</h3>');</script>";
		}
		else
		{
			echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
		}
	}
	else
	{
		$uploadfile=$_POST['catalog_img'];
	}
	// Перезаписываем в базе
	mysql_query("UPDATE `".MPREFIX."catalog` SET `catalog_name` = '".$_POST['catalog_name']."', `catalog_img`='".$uploadfile."' WHERE `catalog_id`='".$_POST['catalog_id']."' LIMIT 1;") or die(mysql_error());
	$query = "SELECT * FROM `".MPREFIX."catalog` WHERE `catalog_id`='".$_POST['catalog_id']."' LIMIT 1";
	$result = mysql_query ($query) or die ("Query failed");
	$catal=mysql_fetch_array($result);
}

// если каталог выбран для удаления
if(isset($_POST['delete_x']))
{
	@unlink($_POST['catalog_img']);
	mysql_query("DELETE FROM `".MPREFIX."catalog` WHERE `catalog_id` = '".$_POST['catalog_id']."';") or die(mysql_error());
}

if(ADMIN==TRUE)
{
	// таблицы
	$text .="<table width=100% border='1' bgcolor='#F8FFE1' cellpadding='5'>";

	// выберем каталог
	$query1 = "SELECT * FROM `".MPREFIX."catalog`";
	$result1 = mysql_query ($query1) or die ("Query failed");

	$text .="<form name='config' method='POST' action='".e_SELF ."' enctype=multipart/form-data>";
	$text .="<tr bgcolor='#FFEBBF'><th colspan='7'>Добавление/редактирование каталога</th></tr>";
	$text .="	<tr><td colspan='4'>Выберите каталог для редактирования:</td>
				<Input Type='hidden' Name='select value'>
				<td colspan='3'><select name='catal_id' OnChange='top.location.href = this.options[this.selectedIndex].value;'>";
	$text .="		<option value='default'>Выберите каталог</option>";
	while($line = mysql_fetch_array($result1))
	{

		$text .="<option value='?id=".$line['catalog_id']."'>".$line['catalog_name']."</option>";
	}
	$text .="</select></td>";
	$text .="</tr>";

	$text .="
				<tr>
					<td colspan='4' rowspan='2'>Добавить/редактировать каталог:</td>
					<td colspan='2'><input name='catalog_name' type='text' value='".$catal['catalog_name']."'> Имя каталога</td>
					<td rowspan='2'>
						<input type=image src='images/system/downloads_32.png' name='add' title='Добавить новый'>
						<input type=image src='images/system/edit_32.png' name='edit' title='Изменить'>
						<input type=image src='images/system/delete_32.png' name='delete' title='Удалить'>
					</td>
				</tr>
				<tr>
					<td><input name='uploadfile' type='file' /> Добавить/изменить фото</td>
					<td>";
	if($catal['catalog_img']!='')
	{
		$text .="<img src='".$catal['catalog_img']."' border='0'>";
	}
	else
	{
		$text .="нет фото";
	}
	$text .="	</td></tr>
				<input name='catalog_id' type='hidden' value='".$catal['catalog_id']."'>
				<input name='catalog_img' type='hidden' value='".$catal['catalog_img']."'>
			</form>";
	$text .="<tr><td bgcolor='#FFFFFF' colspan='7'>-</td></tr>";
	$text .="<tr><th bgcolor='#FFFFFF' colspan='7'>Загрузка файла прайс-листа на сервер</th></tr>";

	// выберем каталог
	$query1 = "SELECT * FROM `".MPREFIX."catalog`";
	$result1 = mysql_query ($query1) or die ("Query failed");


	$text .="	<tr><td colspan='4'>Выберите каталог для редактирования:</td>
				<Input Type='hidden' Name='select value'>
				<td><select name='catal_price' OnChange='top.location.href = this.options[this.selectedIndex].value;'>";
	$text .="		<option value='default'>Выберите каталог</option>";
	while($line = mysql_fetch_array($result1))
	{

		$text .="<option value='?price_id=".$line['catalog_id']."'>".$line['catalog_name']."</option>";
	}
	$text .="</select></td>
			<td colspan='2'>
				<b>Выбранный каталог<br /><font color='red'>".$catal2['catalog_name']."</font></b>
			</td>";
	$text .="</tr>";
	$text .="<tr>
				<td colspan='2'>
					Загрузить прайс
				</td>
				<td colspan='5'>
					<form action='".e_SELF."' method='POST' enctype=multipart/form-data>
						<input name='uploadfile' type='file' />
						<input class='class_button' type='submit' name='upload_file' value='Загрузить'>
						<input name='prise_id' type='hidden' value='".$_GET['price_id']."'>
					</form>
				</td>
			</tr>";

	// html выгрузки файла
	$text .="<tr><td bgcolor='#FFFFFF' colspan='7'>-</td></tr>";
	$text .="<tr><th bgcolor='#FFFFFF' colspan='7'>Выгрузка файла прайс-листа с сервера на локальный компьютер</th></tr>";

	// выберем каталог
	$query1 = "SELECT * FROM `".MPREFIX."catalog`";
	$result1 = mysql_query ($query1) or die ("Query failed");


	$text .="	<tr><td colspan='4'>Выберите каталог для редактирования:</td>
				<Input Type='hidden' Name='select value'>
				<td><select name='catal_price' OnChange='top.location.href = this.options[this.selectedIndex].value;'>";
	$text .="		<option value='default'>Выберите каталог</option>";
	while($line = mysql_fetch_array($result1))
	{

		$text .="<option value='?price_id_out=".$line['catalog_id']."'>".$line['catalog_name']."</option>";
	}
	$text .="</select></td>
			<td colspan='2'>
				<b>Выбранный каталог<br /><font color='red'>".$catal23['catalog_name']."</font></b>
			</td>";
	$text .="</tr>";
	$text .="	<tr>
					<td colspan='2'>
						Выгрузить файл с сервера:
					</td>
					<td colspan='5'>
						<form action='".e_SELF."' method='POST'>
							<input name='catalog' type='hidden' value='".$catal23['catalog_id']."'>
							<input name='catalog_name1' type='hidden' value='".$catal23['catalog_name']."'>
							<input class='class_button' type='submit' name='save' value='Получить'>
						</form>
					</td>
				</tr>";
	$text .="	<tr>
					<td colspan='2'>
						Выгрузить с сервера шаблон прайс-листа:
					</td>
					<td colspan='5'>
						<form action='".e_SELF."' method='POST'>
							<input class='class_button' type='submit' name='save_shab' value='Получить'>
						</form>
					</td>
				</tr>";
	$text .="</table>";
	print $text;
}
else
{
	die("<div align='center'><h1><font color='red'>Вы не имеете прав на использование данного ресурса<br />
				Обратитесь к главному администратору ресурса.</font></h1></div>");
}

require_once(e_ADMIN."footer.php");
?>