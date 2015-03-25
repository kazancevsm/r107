<?php
/*============================= Notice-Board ===========================|
|	author - Sunout, MagicDreamWebStudio, http://e107.compolys.ru	|
|	coder - Sunout, Geo, Sander and other 				|
|	sunout@compolys.ru						|
|	license GNU GPL							|
=======================the project beginning in 2011 ===================*/
/*---------------info plugin--------------------*/
define('NB_INFO',"Доска объявлений");
define('NB_AUTH',"<a href='http://e107.compolys.ru'>MagicDreamWebStudio</a>");
define('NB_EDIT_01',"Настройки доски объявлений");
define('NB_ABOUT',"Notice-Board. Плагин доски объявлений.");
define('NB_INSTALL',"Доска объявлений успешно установлена!");
define('NB_UNINSTALL',"Доска объявлений удалена.");
define('NB_UPGRADE',"Обновление плагина успешно завершено");
/*---------------menu---------------------------*/
define('NB_ADMIN_MENU_CAP',"Опции доски объявлений");
define('NB_GNL_MENU',"Главная страница");
define('NB_CON_MENU',"Опции");
define('NB_CAT_MENU',"Категории");
define('NB_NOT_MENU',"Редактор");
define('NB_DEL_MENU',"Удаление");
define('NB_BAN_MENU',"Баннеры");
define('NB_ABO_MENU',"О плагине");
/*--------------gnl-----------------------------*/
define('NB_GNL_CAP',"Существующие объявления");
define('NB_GNL_ID',"ID");
define('NB_GNL_IMG',"Значек");
define('NB_GNL_NAME',"Заголовок");
define('NB_GNL_USER',"Пользователь");
define('NB_GNL_DATE',"Дата");
define('NB_GNL_OPT',"Опции");
/*--------------config--------------------------*/
define('NB_CONF_CAP',"Настройки доски объявлений");
define('NB_CONF_MAIL',"E-mail Доски объявлений");
define('NB_CONF_DAY',"Обявление действительно (дней)");
define('NB_CONF_FORM',"Формат представления даты");
define('NB_CONF_IMBIG',"Уменьшить загружаемое изображение до");
define('NB_CONF_IMSMALL',"Уменьшить иконку загружаемого изображения до");
define('NB_CONF_COL1',"Во сколько столбцов выводить категори?");
define('NB_CONF_ROW1',"Cколько строк объявлений выводить на странице?");
define('NB_CONF_ROW2',"Cколько строк объявлений выводить в меню?");
define('NB_CONF_QUE',"Контрольный вопрос, защита от спама");
define('NB_CONF_ANS',"Ответ на контрольный вопрос");
define('NB_CONF_PROLONG',"На сколько дней разрешить продление?");
define('NB_CONF_COMMENT',"Разрешить комментарии на доске объявлений?");
/*---------------category-----------------------*/
define('NB_CAT_00',"Управление категориями доски объявлений");
define('NB_CAT_01',"Категории");
define('NB_CAT_02',"Категория");
define('NB_CAT_03',"Имя категории");
define('NB_CAT_04',"Описание категории");
define('NB_CAT_05',"Выберите категорию");
define('NB_CAT_COUNT',"объявлений в категории");
define('NB_SCAT_MENU',"Под-категории");
define('NB_SCAT_00',"Управление под-категориями доски объявлений");
define('NB_SCAT_01',"Под-категории");
define('NB_SCAT_02',"Под-категория");
define('NB_SCAT_03',"Имя под-категории");
define('NB_SCAT_04',"Под-категории объявлений");
define('NB_SCAT_05',"Выберите подкатегорию");
define('NB_SCAT_06',"Переместить категорию в :");
define('NB_SCAT_07',"Выберите родительскую категорию");
/*--------------notice--------------------------*/
define('NB_NOT_CAP',"Управление объявлениями");
define('NB_NOT_ID',"ID");
define('NB_NOT_NAME',"Заголовок объявления");
define('NB_NOT_CAT',"Категория объявления");
define('NB_NOT_SCAT',"Под-категория объявления");
define('NB_NOT_DET',"Полный текст объявления");
define('NB_NOT_PRICE',"Цена");
define('NB_NOT_USER',"Пользователь");
define('NB_NOT_CITY',"Город");
define('NB_NOT_PHONE',"Номер телефона");
define('NB_NOT_EMAIL',"E-mail для связи");
define('NB_NOT_LONG',"Продлить объявление на");
define('NB_NOT_DAYS',"Дней");
define('NB_NOT_DATESTART',"Дата публикации");
define('NB_NOT_DATESTOP',"Дата окончания публикации");
/*--------------notice--------------------------*/
define('NB_PO_CAP',"Личный кабинет");
define('NB_PO_FROM',"от");
define('NB_PO_TO',"до");
/*--------------banner--------------------------*/
define('NB_BAN_00',"Управление баннерами доски объявлений");
define('NB_BAN_01',"Категория");
define('NB_BAN_02',"Выберите категорию");
define('NB_BAN_03',"Организация");
define('NB_BAN_04',"Ссылка на сайт");
define('NB_BAN_05',"Дата включения / выключения баннера");
define('NB_BAN_06',"Баннер");
define('NB_BAN_07',"Выбрать баннер");
define('NB_BAN_08',"Показать баннеры");
define('NB_BAN_09',"Управление");
define('NB_BAN_10',"Главная страница");
define('NB_BAN_11',"На всех страницах");
/*--------------about---------------------------*/
define('NB_ABO_CAP',"Информация о плагине");
define('NB_ABO_INFO',"Как и прежде, вы можете оставить ваши пожелания и предложения по работе плагина на <a href='http://e107.compolys.ru'>сайте разработки и технической поддержки плагинов для любимой системы Е107</a>. <br><br>Так же Вы можете присоедениться к команде разработчиков. Мы всегда открыты для сотрудничества в области дизайна и программирования. Философия нашей команды - GNU GPL. Свободный софт - для свободных людей! 
<br><br>Если Вы используете наш плагин и хотели бы его почаще обновлять - Вы можете помочь проекту любым способом:<br>
1) Разместите на своем ресурсе кнопку с ссылкой на наш сайт<br>
Вот код: <font color=red>&#60a href='http://e107.compolys.ru'&#62&#60img src='http://compolys.ru/promoute/mdws_button.png' alt='Magic Dream Web Studio'&#62&#60/a&#62</font><br>
2) Разместить баннер на доске объявлений с сылкой на наш сайт(баннер можно включить из админской части)<br>
3) Или сделайте пожертвования любым из перечиселнных способов на нашем сайте, все полученные средсва помогут развивать проект быстрее.<br>");
define('NB_ABO_DOC',"Возможности этой версии плагина ".NB_INFO." описаны в документации (здесь).");
/*--------------add-----------------------------*/
define('NB_ADD_CAP',"Управление объявлениями");
define('NB_ADD_01',"Заголовок объявления");
define('NB_ADD_02',"Категория");
define('NB_ADD_03',"Пожалуйста, выберите категорию");
define('NB_ADD_04',"Под-категория");
define('NB_ADD_05',"Пожалуйста, выберите под-категорию");
define('NB_ADD_06',"Загрузить картинку");
define('NB_ADD_07',"Полный текст объявления");
define('NB_ADD_08',"Цена");
define('NB_ADD_09',"Ваше имя (ник)");
define('NB_ADD_10',"Населенный пункт");
define('NB_ADD_11',"Номер телефона");
define('NB_ADD_12',"E-mail для связи");
define('NB_ADD_13',"Решите пример");
define('NB_ADD_14',"Объявления");
define('NB_ADD_15',"Дата");
define('NB_ADD_16',"Цена");
define('NB_ADD_17',"Ваши предыдущие объявления");
/*--------------nboard---------------------------*/
define('NB_NAME_DATE',"Дата");
define('NB_NAME_NAME',"Объявление");
define('NB_NAME_PRICE',"Цена");
define('NB_NAME_CITY',"Место");
define('NB_NAME_PHOTO',"");
/*--------------detailed---------------------------*/
define('NB_DETAIL_CAP',"Объявление");
define('NB_DETAIL_01',"Заголовок");
define('NB_DETAIL_02',"Текст объявления");
define('NB_DETAIL_03',"Цена");
define('NB_DETAIL_04',"Изображение");
define('NB_DETAIL_05',"Отсутствует");
define('NB_DETAIL_06',"Предыдущий");
define('NB_DETAIL_07',"Следующий");
define('NB_DETAIL_08',"Автор");
define('NB_DETAIL_09',"Город (населенный пункт)");
define('NB_DETAIL_10',"Номер телефона");
define('NB_DETAIL_11',"E-mail для связи");
define('NB_DETAIL_12',"Написать автору");
define('NB_DETAIL_13',"Дата публикации / окончания");
define('NB_DETAIL_14',"Количество просмотров объявления");
define('NB_DETAIL_COMMENT',"Комментарии к объявлению");
define('NB_DETAIL_ALLNOTICE',"Всего объявлений в категории: ");
define('NB_AUTH_1',"Автор");
/*--------------serch----------------------------*/
define('NB_SARCH_CAP',"Поиск объявлений");
define('NB_SARCH_01',"Введите текст для поиска");
define('NB_SARCH_02',"по заголовку объявления");
define('NB_SARCH_03',"по тексту объявления");
define('NB_SARCH_04',"объявления");
define('NB_SARCH_05',"текст объявления");
define('NB_SARCH_06',"К сожалению, по вашему запросу ничего не найдено. Попробуйте изменить критерий поиска.");
/*--------------navigation------------------------*/
define('NB_NAVI_PANEL',"Панель навигации");
define('NB_NAVI_SEARCH',"Найти объявления");
define('NB_NAVI_ADD',"Добавить объявление");
define('NB_NAVI_ALL',"Все объявления");
define('NB_NAVI_PRE',"Предыдущее");
define('NB_NAVI_FOL',"Следущее");
define('NB_NAVI_PO',"Личный кабинет");
/*--------------images----------------------------*/
define('NB_IMG_00',"Изображение");
define('NB_IMG_01',"Загрузить картинку");
define('NB_IMG_02',"Выбрать иконку");
define('NB_IMG_03',"Показать иконки");
define('NB_IMG_04',"Поменять картинку");
/*--------------action---------------------------*/
define('NB_COL_00', "Выбирите количество деней публикации объявления");
define('NB_COL_01', "7 Дней");
define('NB_COL_02', "15 Дней");
define('NB_COL_03', "30 Дней");
/*--------------date formate---------------------*/
define('NB_RDATE_01', "00.00.0000");
define('NB_FDATE_01', "%d.%m.%Y");
define('NB_RDATE_02', "00-00-0000");
define('NB_FDATE_02', "%d-%m-%Y");
/*--------------button----------------------------*/
define('NB_BUT_PROLONG',"Продлить");
define('NB_BUT_ADD',"Добавить");
define('NB_BUT_DEL',"Удалить");
define('NB_BUT_EDIT',"Редактировать");
define('NB_BUT_UPD',"Обновить");
define('NB_BUT_RES',"Очистить");
define('NB_BUT_CANS',"Отменить");
define('NB_BUT_AGR',"Принять");
define('NB_BUT_SEA',"Найти");
/*--------------yes no----------------------------*/
define('NB_SEL_YES',"Да");
define('NB_SEL_NO',"Нет");
/*--------------message & question----------------*/
define('NB_MES_NULL',"Не сконфигурирована ни одна категория объявлений, пожалуйста, обратитесь к администратору сайта.");
define('NB_MES_00',"Сообщение");
define('NB_MES_01',"Не выбрана запись для редактирования");
define('NB_MES_02',"Не выбрана запись для удаления");
define('NB_MES_03',"Вы действительно хотите удалить категорию");
define('NB_MES_04',"Вы пытаетесь добавить пустую категорию!");
define('NB_MES_05',"Категория успешно добавлена");
define('NB_MES_06',"Категория обновлена");
define('NB_MES_07',"Категория");
define('NB_MES_08',"удалена");
define('NB_MES_09',"Неправильный формат номера страницы!");
define('NB_MES_10',"Неправильный запрос к базе.");
define('NB_MES_11',"Вы пытаетесь добавить пустую подкатегорию!");
define('NB_MES_12',"Подкатегория успешно добавлена");
define('NB_MES_13',"Под-категория обновлена");
define('NB_MES_14',"Настройки обновлены");
define('NB_MES_15',"Без картинки");
define('NB_MES_16',"Введите ваше имя, не более 20 символов!");
define('NB_MES_17',"Установки обновлены");
define('NB_MES_18',"Установки добавлены");
define('NB_MES_19',"Ваше объявление успешно добавлено!");
define('NB_MES_20',"Ваше объявление добавлено сроком до ");
define('NB_MES_21',"Заполните пожалуйста все поля отмеченные знаком *");
define('NB_MES_22',"Объявление обновлено");
define('NB_MES_23',"Информация о баннере обновлена!");
define('NB_MES_24',"Объявление удалено");
define('NB_MES_30',"Ваше объявление продлено, и будет действительно еще ");
define('NB_MES_31',"дней!");
define('NB_QUE_DEL_NOT',"Вы действительно хотите удалить объявление?");
define('NB_QUE_DEL_NOTOLD',"Вы действительно хотите удалить старые объявления?");
/*--------------example----------------------------*/
define('NB_EX_CONF_01',"Сколько будет 4+4");
define('NB_EX_CONF_02',"8");
define('NB_EX_CAT_01',"Авто");
define('NB_EX_CATDESC_01',"Автомобили, мотоциклы, запчасти");
define('NB_EX_CAT_02',"Недвижимость");
define('NB_EX_CATDESC_02',"Квартиры, дома, дачи, офисы");
define('NB_EX_CAT_03',"Цифра");
define('NB_EX_CATDESC_03',"Компьютеры, телефоны, спутниквое оборудование");
define('NB_EX_CAT_04',"Люди");
define('NB_EX_CATDESC_04',"Знакомства, объявления о работе, вакансии");
define('NB_EX_CAT_05',"продажа");
define('NB_EX_CAT_06',"покупка");
define('NB_EX_CAT_07',"обмен");
define('NB_EX_CAT_08',"аренда");
define('NB_EX_CAT_09',"ищу, познакомлюсь");
define('NB_EX_CAT_10',"вакансии");
define('NB_EX_CAT_11',"предлагаю работу");
?>