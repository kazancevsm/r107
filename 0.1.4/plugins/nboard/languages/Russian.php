<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/
/*---------------info plugin--------------------*/
define('LAN_NB_PLUG_NAME',"Доска объявлений");
define('LAN_NB_PLUG_EDIT',"Настройки доски объявлений");
define('LAN_NB_PLUG_ABOUT',"Плагин 'Доска объявлений' позволяет организовать на сайте прием и публикацию объявлений. На данный момент ведутся разработки по отчистке от старых объявлений, ожидайте в следующей версии.");
define('LAN_NB_PLUG_INSTALL',"Доска объявлений успешно установлена!");
define('LAN_NB_PLUG_UNINSTALL',"Доска объявлений удалена.");
define('LAN_NB_PLUG_UPGRADE',"Обновление плагина успешно завершено");
/*---------------menu---------------------------*/
define('LAN_NB_ADMIN_MENU_CAP',"Опции доски объявлений");
define('LAN_NB_MENU_GNL',"Главная страница");
define('LAN_NB_MENU_CON',"Опции");
define('LAN_NB_MENU_CAT',"Категории");
define('LAN_NB_MENU_NOT',"Редактор");
define('LAN_NB_MENU_DEL',"Удаление");
define('LAN_NB_MENU_BAN',"Баннеры");
define('LAN_NB_MENU_ABO',"О плагине");
/*--------------gnl-----------------------------*/
define('LAN_NB_GNL_CAP',"Существующие объявления");
define('LAN_NB_GNL_ID',"ID");
define('LAN_NB_GNL_IMG',"Значек");
define('LAN_NB_GNL_NAME',"Заголовок");
define('LAN_NB_GNL_USER',"Пользователь");
define('LAN_NB_GNL_DATE',"Дата");
define('LAN_NB_GNL_OPT',"Опции");
/*--------------config--------------------------*/
define('LAN_NB_CONF_CAP',"Настройки доски объявлений");
define('LAN_NB_CONF_MAIL',"E-mail Доски объявлений");
define('LAN_NB_CONF_DAY',"Обявление действительно (дней)");
define('LAN_NB_CONF_FORM',"Формат представления даты");
define('LAN_NB_CONF_IMBIG',"Уменьшить загружаемое изображение до");
define('LAN_NB_CONF_IMSMALL',"Уменьшить иконку загружаемого изображения до");
define('LAN_NB_CONF_COL1',"Во сколько столбцов выводить категори?");
define('LAN_NB_CONF_ROW1',"Cколько строк объявлений выводить на странице?");
define('LAN_NB_CONF_ROW2',"Cколько строк объявлений выводить в меню?");
define('LAN_NB_CONF_QUE',"Контрольный вопрос, защита от спама");
define('LAN_NB_CONF_ANS',"Ответ на контрольный вопрос");
define('LAN_NB_CONF_PROLONG',"На сколько дней разрешить продление?");
define('LAN_NB_CONF_COMMENT',"Разрешить комментарии на доске объявлений?");
/*---------------category-----------------------*/
define('LAN_NB_CAT_00',"Управление категориями доски объявлений");
define('LAN_NB_CAT_01',"Категории");
define('LAN_NB_CAT_02',"Категория");
define('LAN_NB_CAT_03',"Имя категории");
define('LAN_NB_CAT_04',"Описание категории");
define('LAN_NB_CAT_05',"Выберите категорию");
define('LAN_NB_CAT_COUNT',"объявлений в категории");
define('LAN_NB_SCAT_MENU',"Под-категории");
define('LAN_NB_SCAT_00',"Управление под-категориями доски объявлений");
define('LAN_NB_SCAT_01',"Под-категории");
define('LAN_NB_SCAT_02',"Под-категория");
define('LAN_NB_SCAT_03',"Имя под-категории");
define('LAN_NB_SCAT_04',"Под-категории объявлений");
define('LAN_NB_SCAT_05',"Выберите подкатегорию");
define('LAN_NB_SCAT_06',"Переместить категорию в :");
define('LAN_NB_SCAT_07',"Выберите родительскую категорию");
/*--------------notice--------------------------*/
define('LAN_NB_NOT_CAP',"Управление объявлениями");
define('LAN_NB_NOT_ID',"ID");
define('LAN_NB_NOT_NAME',"Заголовок объявления");
define('LAN_NB_NOT_CAT',"Категория объявления");
define('LAN_NB_NOT_SCAT',"Под-категория объявления");
define('LAN_NB_NOT_DET',"Полный текст объявления");
define('LAN_NB_NOT_PRICE',"Цена");
define('LAN_NB_NOT_USER',"Пользователь");
define('LAN_NB_NOT_CITY',"Город");
define('LAN_NB_NOT_PHONE',"Номер телефона");
define('LAN_NB_NOT_EMAIL',"E-mail для связи");
define('LAN_NB_NOT_LONG',"Продлить объявление на");
define('LAN_NB_NOT_DAYS',"Дней");
define('LAN_NB_NOT_DATESTART',"Дата публикации");
define('LAN_NB_NOT_DATESTOP',"Дата окончания публикации");
/*--------------notice--------------------------*/
define('LAN_NB_PO_CAP',"Личный кабинет");
define('LAN_NB_PO_FROM',"от");
define('LAN_NB_PO_TO',"до");
/*--------------banner--------------------------*/
define('LAN_NB_BAN_00',"Управление баннерами доски объявлений");
define('LAN_NB_BAN_01',"Категория");
define('LAN_NB_BAN_02',"Выберите категорию");
define('LAN_NB_BAN_03',"Организация");
define('LAN_NB_BAN_04',"Ссылка на сайт");
define('LAN_NB_BAN_05',"Дата включения / выключения баннера");
define('LAN_NB_BAN_06',"Баннер");
define('LAN_NB_BAN_07',"Выбрать баннер");
define('LAN_NB_BAN_08',"Показать баннеры");
define('LAN_NB_BAN_09',"Управление");
define('LAN_NB_BAN_10',"Главная страница");
define('LAN_NB_BAN_11',"На всех страницах");
/*--------------about---------------------------*/
define('LAN_NB_ABO_CAP',"Информация о плагине");
define('LAN_NB_ABO_INFO',"Как и прежде, вы можете оставить ваши пожелания и предложения по работе плагина на <a href='http://e107.compolys.ru'>сайте разработки и технической поддержки плагинов для любимой системы Е107</a>. <br><br>Так же Вы можете присоедениться к команде разработчиков. Мы всегда открыты для сотрудничества в области дизайна и программирования. Философия нашей команды - GNU GPL. Свободный софт - для свободных людей! 
<br><br>Если Вы используете наш плагин и хотели бы его почаще обновлять - Вы можете помочь проекту любым способом:<br>
1) Разместите на своем ресурсе кнопку с ссылкой на наш сайт<br>
Вот код: <font color=red>&#60a href='http://e107.compolys.ru'&#62&#60img src='http://compolys.ru/promoute/mdws_button.png' alt='Magic Dream Web Studio'&#62&#60/a&#62</font><br>
2) Разместить баннер на доске объявлений с сылкой на наш сайт(баннер можно включить из админской части)<br>
3) Или сделайте пожертвования любым из перечиселнных способов на нашем сайте, все полученные средсва помогут развивать проект быстрее.<br>");
define('LAN_NB_ABO_DOC',"Возможности этой версии плагина ".LAN_NB_INFO." описаны в документации (здесь).");
/*--------------add-----------------------------*/
define('LAN_NB_ADD_CAP',"Управление объявлениями");
define('LAN_NB_ADD_01',"Заголовок объявления");
define('LAN_NB_ADD_02',"Категория");
define('LAN_NB_ADD_03',"Пожалуйста, выберите категорию");
define('LAN_NB_ADD_04',"Под-категория");
define('LAN_NB_ADD_05',"Пожалуйста, выберите под-категорию");
define('LAN_NB_ADD_06',"Загрузить картинку");
define('LAN_NB_ADD_07',"Полный текст объявления");
define('LAN_NB_ADD_08',"Цена");
define('LAN_NB_ADD_09',"Ваше имя (ник)");
define('LAN_NB_ADD_10',"Населенный пункт");
define('LAN_NB_ADD_11',"Номер телефона");
define('LAN_NB_ADD_12',"E-mail для связи");
define('LAN_NB_ADD_13',"Решите пример");
define('LAN_NB_ADD_14',"Объявления");
define('LAN_NB_ADD_15',"Дата");
define('LAN_NB_ADD_16',"Цена");
define('LAN_NB_ADD_17',"Ваши предыдущие объявления");
/*--------------nboard---------------------------*/
define('LAN_NB_NAME_DATE',"Дата");
define('LAN_NB_NAME_NAME',"Объявление");
define('LAN_NB_NAME_PRICE',"Цена");
define('LAN_NB_NAME_CITY',"Место");
define('LAN_NB_NAME_PHOTO',"");
/*--------------detailed---------------------------*/
define('LAN_NB_DETAIL_CAP',"Объявление");
define('LAN_NB_DETAIL_01',"Заголовок");
define('LAN_NB_DETAIL_02',"Текст объявления");
define('LAN_NB_DETAIL_03',"Цена");
define('LAN_NB_DETAIL_04',"Изображение");
define('LAN_NB_DETAIL_05',"Отсутствует");
define('LAN_NB_DETAIL_06',"Предыдущий");
define('LAN_NB_DETAIL_07',"Следующий");
define('LAN_NB_DETAIL_08',"Автор");
define('LAN_NB_DETAIL_09',"Город (населенный пункт)");
define('LAN_NB_DETAIL_10',"Номер телефона");
define('LAN_NB_DETAIL_11',"E-mail для связи");
define('LAN_NB_DETAIL_12',"Написать автору");
define('LAN_NB_DETAIL_13',"Дата публикации / окончания");
define('LAN_NB_DETAIL_14',"Количество просмотров объявления");
define('LAN_NB_DETAIL_COMMENT',"Комментарии к объявлению");
define('LAN_NB_DETAIL_ALLNOTICE',"Всего объявлений в категории: ");
define('LAN_NB_AUTH_1',"Автор");
/*--------------serch----------------------------*/
define('LAN_NB_SARCH_CAP',"Поиск объявлений");
define('LAN_NB_SARCH_01',"Введите текст для поиска");
define('LAN_NB_SARCH_02',"по заголовку объявления");
define('LAN_NB_SARCH_03',"по тексту объявления");
define('LAN_NB_SARCH_04',"объявления");
define('LAN_NB_SARCH_05',"текст объявления");
define('LAN_NB_SARCH_06',"К сожалению, по вашему запросу ничего не найдено. Попробуйте изменить критерий поиска.");
/*--------------navigation------------------------*/
define('LAN_NB_NAVI_PANEL',"Панель навигации");
define('LAN_NB_NAVI_SEARCH',"Найти объявления");
define('LAN_NB_NAVI_ADD',"Добавить объявление");
define('LAN_NB_NAVI_ALL',"Все объявления");
define('LAN_NB_NAVI_PRE',"Предыдущее");
define('LAN_NB_NAVI_FOL',"Следущее");
define('LAN_NB_NAVI_PO',"Личный кабинет");
/*--------------images----------------------------*/
define('LAN_NB_IMG_00',"Изображение");
define('LAN_NB_IMG_01',"Загрузить картинку");
define('LAN_NB_IMG_02',"Выбрать иконку");
define('LAN_NB_IMG_03',"Показать иконки");
define('LAN_NB_IMG_04',"Поменять картинку");
/*--------------action---------------------------*/
define('LAN_NB_COL_00', "Выбирите количество деней публикации объявления");
define('LAN_NB_COL_01', "7 Дней");
define('LAN_NB_COL_02', "15 Дней");
define('LAN_NB_COL_03', "30 Дней");
/*--------------date formate---------------------*/
define('LAN_NB_RDATE_01', "00.00.0000");
define('LAN_NB_FDATE_01', "%d.%m.%Y");
define('LAN_NB_RDATE_02', "00-00-0000");
define('LAN_NB_FDATE_02', "%d-%m-%Y");
/*--------------button----------------------------*/
define('LAN_NB_BUT_PROLONG',"Продлить");
define('LAN_NB_BUT_ADD',"Добавить");
define('LAN_NB_BUT_DEL',"Удалить");
define('LAN_NB_BUT_EDIT',"Редактировать");
define('LAN_NB_BUT_UPD',"Обновить");
define('LAN_NB_BUT_RES',"Очистить");
define('LAN_NB_BUT_CANS',"Отменить");
define('LAN_NB_BUT_AGR',"Принять");
define('LAN_NB_BUT_SEA',"Найти");
/*--------------yes no----------------------------*/
define('LAN_NB_SEL_YES',"Да");
define('LAN_NB_SEL_NO',"Нет");
/*--------------message & question----------------*/
define('LAN_NB_MES_NULL',"Не сконфигурирована ни одна категория объявлений, пожалуйста, обратитесь к администратору сайта.");
define('LAN_NB_MES_00',"Сообщение");
define('LAN_NB_MES_01',"Не выбрана запись для редактирования");
define('LAN_NB_MES_02',"Не выбрана запись для удаления");
define('LAN_NB_MES_03',"Вы действительно хотите удалить категорию");
define('LAN_NB_MES_04',"Вы пытаетесь добавить пустую категорию!");
define('LAN_NB_MES_05',"Категория успешно добавлена");
define('LAN_NB_MES_06',"Категория обновлена");
define('LAN_NB_MES_07',"Категория");
define('LAN_NB_MES_08',"удалена");
define('LAN_NB_MES_09',"Неправильный формат номера страницы!");
define('LAN_NB_MES_10',"Неправильный запрос к базе.");
define('LAN_NB_MES_11',"Вы пытаетесь добавить пустую подкатегорию!");
define('LAN_NB_MES_12',"Подкатегория успешно добавлена");
define('LAN_NB_MES_13',"Под-категория обновлена");
define('LAN_NB_MES_14',"Настройки обновлены");
define('LAN_NB_MES_15',"Без картинки");
define('LAN_NB_MES_16',"Введите ваше имя, не более 20 символов!");
define('LAN_NB_MES_17',"Установки обновлены");
define('LAN_NB_MES_18',"Установки добавлены");
define('LAN_NB_MES_19',"Ваше объявление успешно добавлено!");
define('LAN_NB_MES_20',"Ваше объявление добавлено сроком до ");
define('LAN_NB_MES_21',"Заполните пожалуйста все поля отмеченные знаком *");
define('LAN_NB_MES_22',"Объявление обновлено");
define('LAN_NB_MES_23',"Информация о баннере обновлена!");
define('LAN_NB_MES_24',"Объявление удалено");
define('LAN_NB_MES_30',"Ваше объявление продлено, и будет действительно еще ");
define('LAN_NB_MES_31',"дней!");
define('LAN_NB_QUE_DEL_NOT',"Вы действительно хотите удалить объявление?");
define('LAN_NB_QUE_DEL_NOTOLD',"Вы действительно хотите удалить старые объявления?");
/*--------------example----------------------------*/
define('LAN_NB_EX_CONF_01',"Сколько будет 4+4");
define('LAN_NB_EX_CONF_02',"8");
define('LAN_NB_EX_CAT_01',"Авто");
define('LAN_NB_EX_CATDESC_01',"Автомобили, мотоциклы, запчасти");
define('LAN_NB_EX_CAT_02',"Недвижимость");
define('LAN_NB_EX_CATDESC_02',"Квартиры, дома, дачи, офисы");
define('LAN_NB_EX_CAT_03',"Цифра");
define('LAN_NB_EX_CATDESC_03',"Компьютеры, телефоны, спутниквое оборудование");
define('LAN_NB_EX_CAT_04',"Люди");
define('LAN_NB_EX_CATDESC_04',"Знакомства, объявления о работе, вакансии");
define('LAN_NB_EX_CAT_05',"продажа");
define('LAN_NB_EX_CAT_06',"покупка");
define('LAN_NB_EX_CAT_07',"обмен");
define('LAN_NB_EX_CAT_08',"аренда");
define('LAN_NB_EX_CAT_09',"ищу, познакомлюсь");
define('LAN_NB_EX_CAT_10',"вакансии");
define('LAN_NB_EX_CAT_11',"предлагаю работу");
?>