<?php
//============================= Virtual-Trade ====================================
//	author: ComPolyS team, http://e107.compolys.ru, sunout@compolys.ru
//	coders: Sunout, Geo
//	language officer Georgy Pyankov
//	license GNU GPL
//==================== the project started in March 2012 =========================

define("LAN_EF_PLUG_NAME","Управление заказами");
define("LAN_EF_PLUG_INST","Плагин успешно установлен.");
define("LAN_EF_PLUG_UNINST","Плагин успешно удален.");
define("LAN_EF_PLUG_ABOUT","Этот плагин является отдельным модулем для других плагинов: например, таких как, Каталог, Доска объявлений, Галерея и др. С помощью этого плагина можно легко организовать интернет-магазин, или прочую электронную торговлю на своем сайте. Также этот плагин позволяет вести первичную бухгалтерию.<br>");
//admin_menu.php
define("LAN_EF_INFO_01","Каталог продукции");
//admin_menu.php
define("LAN_EF_MENU_00","Меню");
define("LAN_EF_MENU_CONF","Настройки");
define("LAN_EF_MENU_02","Категории");
define("LAN_EF_MENU_03","Номенклатура");
define("LAN_EF_MENU_04","Заказы");
define("LAN_EF_MENU_05","Баннеры");
define("LAN_EF_MENU_06","О плагине");
//admin_config.php-config
define("LAN_EF_CONF_CAP","Настройки VTrade");
define("LAN_EF_CONF_GNL_CAP","Общие настройки:");
define("LAN_EF_CONF_02","Заголовок интернет магазина:");
define("LAN_EF_CONF_05","E-mail VTrade (сюда будут приходить письма с заказами)");
define("LAN_EF_CONF_08","Уменьшить загружаемое изображение до");
define("LAN_EF_CONF_09","Уменьшить иконку загружаемого изображения до");
define("LAN_EF_CONF_10","Во сколько столбцов выводить категори?");
define("LAN_EF_CONF_11","Во сколько строк выводить категори?");
define("LAN_EF_CONF_12","Во сколько столбцов выводить номенклатуру?");
define("LAN_EF_CONF_13","Во сколько строк выводить номенклатуру?");
define("LAN_EF_CONF_NEW_CAP","Новые поступления");
define("LAN_EF_CONF_NEW_01","Отображать новые поступления на главной странице?");
define("LAN_EF_CONF_NEW_02","Введите заголовок для нового товара:");
define("LAN_EF_CONF_NEW_03","Сколько позиций номенклатуры отображать?");
define("LAN_EF_CONF_SALE_CAP","Распродажа");
define("LAN_EF_CONF_SALE_01","Отображать распродажу на главной странице?");
define("LAN_EF_CONF_SALE_02","Введите заголовок для распродажи:");
define("LAN_EF_CONF_SALE_03","Сколько позиций номенклатуры отображать?");
define("LAN_EF_CONF_HIT_CAP","Хиты продаж");
define("LAN_EF_CONF_HIT_01","Отображать хиты продаж на главной странице?");
define("LAN_EF_CONF_HIT_02","Введите заголовок для хитов продаж:");
define("LAN_EF_CONF_HIT_03","Сколько позиций номенклатуры отображать?");
//admin_config.php-category
define("LAN_EF_CAT_FORMEDIT","Выбор для редактирования и удаления категорий VTrade");
define("LAN_EF_CAT_FORMUPLOAD","Загрузка изображений для категорий VTrade");
define("LAN_EF_CAT_FORMNEW","Создание и редактирование категорий VTrade");
define("LAN_EF_CAT_CAT","Категории");
define("LAN_EF_CAT_NAME","Имя категории");
define("LAN_EF_CAT_SUB","Принадлежит категории");
define("LAN_EF_CAT_VIS","Видимость категории");
define("LAN_EF_CAT_DESC","Описание категории");
define("LAN_EF_CAT_08","Информация");
//admin_config.php-items
define("LAN_EF_AI_CAP_01","Редактирование и удаление номенклатуры");
define("LAN_EF_AI_CAP_02","Добавление и редактирование номенклатуры");
define("LAN_EF_AI_01","Выберите категорию");
define("LAN_EF_AI_02","Выберите номенклатуру");
define("LAN_EF_AI_NUM","Номер:");
define("LAN_EF_AI_ART","Артикул:");
define("LAN_EF_AI_CODE","Штрих код:");
define("LAN_EF_AI_NAME","Наименование товара:");
define("LAN_EF_AI_CAT","В категории:");
define("LAN_EF_AI_UNIT","Еденица измерения:");
define("LAN_EF_AI_TYPE","Вид номенклатуры (ТМЦ, Услуга, Тара):");
define("LAN_EF_AI_DESC","Подробное описание:");
define("LAN_EF_AI_PRICE1","Цена закупочная:");
define("LAN_EF_AI_PRICE2","Цена розничная:");
define("LAN_EF_AI_PRICE3","Цена со скидкой:");
define("LAN_EF_AI_PRICE4","Цена оптовая:");

//vtrade.php
define("LAN_EF_LAN_EF_CAT","Другие категории");
define("LAN_EF_LAN_EF_SUB","Подкатегории");
define("LAN_EF_LAN_EF_SCAT","Выберите категорию");
define("LAN_EF_LAN_EF_SSUB","Выберите подкатегорию");
define("LAN_EF_CAT","Категории");
define("LAN_EF_SUB","Подкатегории");
define("LAN_EF_LAN_EF_DESC","Подробное описание");

//cart.php
define("LAN_EF_CART_CAP","Ваша корзина");
$webaddy = SITEURL."signup.php";
define("LAN_EF_CART_01","Корзина");
define("LAN_EF_26","Вы не вошл");
define("LAN_EF_27","Вы должны быть зарегистрированы или войти в систему </br><a href=$webaddy>Регистрация</a></br>");
define("LAN_EF_28","");


define("LAN_EF_31","Возвратиться к выбору товаров");
define("LAN_EF_32","Описание");
define("LAN_EF_33","Цена за ед. товара");
define("LAN_EF_34","Удалить?");
define("LAN_EF_35","This Item Doesnt Apper to Exist!!");
define("LAN_EF_36","Стоимость доставки:");
define("LAN_EF_37","Всего:");
define("LAN_EF_38","Назад к выбору товаров");
define("LAN_EF_39","Интернет магазин - Курс доллара = 30.0");
define("LAN_EF_40","Удалить");
define("LAN_EF_73","Количество");
define("LAN_EF_74","SKU");

//myprods.php
define("LAN_EF_MP_01","Нет товаров в этой категории. Пожалуйста сообщите Администратору. <a href=myStore.php>Back to Categories</a>");


//myStore.php
define("LAN_EF_44","В магазине нет категорий. Пожжалуйста сообщите Администратору, чтобы он добавил категории.");
define("LAN_EF_45","Категории товаров");

//myStore_config.php
define("LAN_EF_46","Email админа магазина:");
define("LAN_EF_47","Коммерч.(PayPal) Email:");
define("LAN_EF_48","Доставка:");
define("LAN_EF_49","за товар:");
define("LAN_EF_50","бесплатно:");
define("LAN_EF_51","Мин. цена доставки:");
define("LAN_EF_52","Если беспл. введите 0.00");
define("LAN_EF_53","Макс. цена доставки:");
define("LAN_EF_72","Валюта:");

//notify.php
define("LAN_EF_55","A Purchase Has been Completed from your Site");
define("LAN_EF_56","Follow this link to view purchase details: $webaddress \n\n The Payment Status is:$payment_status\n\nPlease contact the user to obtain delivery details.\n\n\nhttp://www.myTipper.com");
define("LAN_EF_57","Your Purcahse from");
define("LAN_EF_58","The purchase you made did not get paid correctly, the Paypal Payment Status is:$payment_status, \n\n please disucss with paypal or the site Admin for further information.");
define("LAN_EF_59","Failed");

//sales.php
define("LAN_EF_60","Purchase From");
define("LAN_EF_61","myStore Pending Sales");
define("LAN_EF_62","myStore Old Sales");

//sdetail.php
define("LAN_EF_63","Корзина покупок");
define("LAN_EF_64","Описание");
define("LAN_EF_65","Товар");
define("LAN_EF_66","Цена за шт");
define("LAN_EF_67","Статус");
define("LAN_EF_68","myStore Purchase for");
define("LAN_EF_69","This Item Doesnt Apper to Exist!!");

//================images==========================//
define('LAN_EF_IMG_00',"Изображение");
define('LAN_EF_IMG_01',"Загрузить картинку");
define('LAN_EF_IMG_02',"Выберите изображение");
define('LAN_EF_IMG_03',"Показать иконки");
define('LAN_EF_IMG_04',"Поменять картинку");
//================yes or no=======================//
define('LAN_EF_YES', "да");
define('LAN_EF_NO', "нет");
//================date formate====================//
define('LAN_EF_RDATE_01', "00.00.0000");
define('LAN_EF_FDATE_01', "%d.%m.%Y");
define('LAN_EF_RDATE_02', "00-00-0000");
define('LAN_EF_FDATE_02', "%d-%m-%Y");
//=====================button====================//
define('LAN_EF_BUT_ADD',"Добавить");
define('LAN_EF_BUT_DEL',"Удалить");
define('LAN_EF_BUT_EDIT',"Редактировать");
define('LAN_EF_BUT_UPD',"Обновить");
define('LAN_EF_BUT_RES',"Очистить");
define('LAN_EF_BUT_CANS',"Отменить");
define('LAN_EF_BUT_AGR',"Принять");
define('LAN_EF_BUT_SEA',"Найти");
define('LAN_EF_BUT_GO',"Перейти");
define('LAN_EF_BUT_ADDBASK',"В корзину");
define("LAN_EF_BUT_BASK","Корзина");
define("LAN_EF_BUT_BEGIN","В начало");
define("LAN_EF_BUT_BACK","Вернуться к выбору товара");
/*--------------messeg----------------------------*/
define('LAN_EF_MES_START',"VTrade пока не готов к работе, пожалуйста, обратитесь к администратору сайта.");
define('LAN_EF_MES_CAP',"Сообщение");
define('LAN_EF_MES_00',"<font color=red>Настройки обновлены</font>");
define('LAN_EF_MES_01',"<font color=red>Не выбрана запись для редактирования</font>");
define('LAN_EF_MES_02',"<font color=red>Не выбрана запись для удаления</font>");
define('LAN_EF_MES_03',"<font color=red>Вы действительно хотите удалить категорию</font>");
define('LAN_EF_MES_04',"<font color=red>Вы пытаетесь добавить пустую категорию!</font>");
define('LAN_EF_MES_05',"<font color=red>Категория успешно добавлена</font>");
define('LAN_EF_MES_06',"<font color=red>Категория обновлена</font>");
define('LAN_EF_MES_07',"<font color=red>Категория</font>");
define('LAN_EF_MES_08',"<font color=red>удалена</font>");
define('LAN_EF_MES_09',"<font color=red>Неправильный формат номера страницы!</font>");
define('LAN_EF_MES_10',"<font color=red>Неправильный запрос к базе.</font>");
define('LAN_EF_MES_11',"<font color=red>Вы пытаетесь добавить пустую подкатегорию!</font>");
define('LAN_EF_MES_12',"<font color=red>Подкатегория успешно добавлена</font>");
define('LAN_EF_MES_13',"<font color=red>Под-категория обновлена</font>");
define('LAN_EF_MES_14',"<font color=red>Не вся информация была введена</font>");
define('LAN_EF_MES_15',"<font color=red>Без картинки</font>");
define('LAN_EF_MES_16',"<font color=red>Введите ваше имя, не более 20 символов!</font>");
define('LAN_EF_MES_17',"<font color=red>Установки обновлены</font>");
define('LAN_EF_MES_18',"<font color=red>Установки добавлены</font>");
define('LAN_EF_MES_19',"<font color=red>Вы уже добавили этот товар в Вашу корзину</font>");
define("LAN_EF_MES_EMPT_01","<font color=red>Ваша корзина пуста</font>");
define("LAN_EF_MES_EMPT_02","<font color=red>Ваша корзина пуста (Содержимое корзины автоматически очищается после 24 часов неиспользования)</font>");
define("LAN_EF_MES_NOLOGIN","Вы должны быть зарегестрированным пользователем.<br>Регистрация очень проста и не займет у вас много времени.<br><a href=".e_HTTP."signup.php><b>[Перейти к процедуре регистации]</b></a>");
define("LAN_EF_MES_DISCOUNT","Чтобы воспользоваться типом скидки Накопительная, вы должны быть зарегестрированы.<br><a href=".e_HTTP."signup.php>Перейти к процедуре регистации?</a>");
define("LAN_EF_MES_FILL","Возможно вы заполнили не все поля отмеченные заком *");
//=====================about====================//
define('LAN_EF_ABO_MENU',"О плагине");
define('LAN_EF_ABO_CAP',"Информация о плагине");
define('LAN_EF_ABO_INFO',"Как и прежде, вы можете оставить ваши пожелания и предложения по работе плагина на <a href='http://e107.compolys.ru'>сайте разработки и технической поддержки плагинов для любимой системы Е107</a>. <br><br>Так же Вы можете присоедениться к команде разработчиков. Мы всегда открыты для сотрудничества в области дизайна и программирования. Философия нашей команды - GNU GPL. Свободный софт - для свободных людей! 
<br><br>Если Вы используете наш плагин и хотели бы его почаще обновлять - Вы можете помочь проекту любым способом:
<br>1) Разместите на своем ресурсе эту кнопку <img src='".e_PLUGIN."nboard/theme/e107_compolys.png' alt='".LAN_EF_INFO."'> с ссылкой на наш сайт<br>
Вот код: <font color=red>&#60a href='http://e107.compolys.ru'&#62&#60img src='&#34.e_PLUGIN.&#34nboard/theme/e107_compolys.png' alt='&#34.LAN_EF_INFO.&#34'&#62&#60/a&#62</font><br>
<br>2) Разместить баннер на доске объявлений с сылкой на наш сайт(баннер можно включить из админской части)<br>
<br>3) Или сделайте пожертвования любым из перечиселнных способов на нашем сайте, все полученные средсва помогают развивать проект быстрее.<br>");
define('LAN_EF_ABO_00',"В этой версии плагина Virtual-Trade:
<br>1) Упрощены требования к подаче объявлений
<br>2) Защита от спама реализована на уровне вопроса из базы, который можно менять в настройках. От предыдущего антиспама было решено отказаться, возможно в дальнейшем будет настроена другая защита.
<br>3) Плагин обзавелся своей темой
<br>4) Добавлена возможность встраивания Virtual-Trade в плагин 'Новое на сайте', можно выводить такие данные, как: Иконка, Автор, Дата, Заголовок объявлений
<br>5) Добавлены диалоги и коментарии
<br>6) Внесены изменения в файловую структуру плагина
<br>7) Пересмотрена и реструктурирована база данных, таблицы nb_subcat более не существует, теперь категории и субкатегори определяются таблицей nb_cat
<br>8) Пересмотрены и структурированы языковые константы
<br>9) Вопросы безопасности вводимых данных полностью возложены на ядро системы
<br>10) Работа плагина с датой возвращена на Unix эпоху, измененены типы полей и названия.
<br>11) Добавлена возможность выбора формата даты для вывода
<br>12) Доработана админская часть плагина: настройки теперь редактируются, создание категорий и субкатегорий и их редактирование, управление баннерами, управление объявлениями(просмотр и удаление), информация о плагине!
<br>13) Появилась панель навигации по доске объявлений (бета версия), есть некоторые недоработки
<br>14) Улучшена работа с банерами, теперь банеры можно ставить в главную страницу Virtual-Trade
<br>15) Исправлен баг с залогиниванием на странице добавления объявлений
<br>16) Улучшен дизайн плагина, всеэлементы теперь подчиняются таблице стилей
<br>17) Адреса почтовых ящиков пользователей теперь выводятся в скрытой форме
<br>18) Внесены важные изменения по безопасности
<br>К сожалению обновление установкой поверх первой версии без изменения структуры данных не представляется возможным в силу множественных изменений на уровне бызы данных, но вы можете сделать бекап Вашей бызы в формате CVS, затем открыть ее в редакторе таблиц и отформатировать поля в соответсвии со структурой базы данных. Так же уделите особое внимание старым полям gnl_date, gnl_datе_kikoz, теперь это поля gnl_date_start, gnl_date_end, так же изменен их тип. Придется перевести даты в Unix эпоху. В дальнейшем кординальных перестроек в базе уже не будет, могут добавляться некоторые поля, но таблицы остануться неизменными
<br>Планы на разработку Virtual-Trade
<br>1) Возможность незарегестрированным пользователям управлять подаными объявлениями
<br>2) Разделение объявлений на частные и объявления коммерческого храктера
<br>3) Улучшить загрузку и обработку изображений при подаче объявлений
<br>4) Доработать редактирование объявлений в админской части
<br>5) Доработка админской части по объявлениям, пока можно только просматривать и удалять объявления.
<br>6) Внедрить возможность вести торг на доске объявлений
<br>7) Добавить рассылку по окончанию срока объявлений
<br>8) Создание механизма отслеживания новой версии и механизм автоматического обновления
<br>9) Перевод всех диалогов и сообщений на js или ajax");
//=====================================================exemple================================================
define("EXEMP_CAT_NAME_01","Художнику оформителю");
define("EXEMP_CAT_NAME_02","Канцелярские товары");
define("EXEMP_CAT_NAME_03","Инструменты");
define("EXEMP_CAT_DESC_01","Товары для художника оформителя");
define("EXEMP_CAT_DESC_02","Папки, бумага, ручки");
define("EXEMP_CAT_DESC_03","Молотки, лупы");

define("EXEMP_NOM_NAME_01","Планшет с кистью");
define("EXEMP_NOM_TYPE_01","тмц");
define("EXEMP_NOM_UNIT_01","шт");
define("EXEMP_NOM_DESC_01","Планшет графический с кистью.<br>Очень удобный, эргономичный.<br>В комплект поставки входят дополнительные кисти разной жесткости ворса.<br>Производство Россия.");
define("EXEMP_NOM_NAME_02","Планшет с карандашем и линейками");
define("EXEMP_NOM_TYPE_02","тмц");
define("EXEMP_NOM_UNIT_02","шт");
define("EXEMP_NOM_DESC_02","Планшет графический с карандашем и линейками.<br>Очень удобный, эргономичный.<br>В комплект поставки входят дополнительные карандаши разной твердости.<br>Производство Россия.");

?>