<?php
//------md_gallery--------------------------------------------------------------------------------
//	for e107 website system : http://e107.org.ru
//	released under the terms and conditions of the GNU General Public License (http://gnu.org)
//	is based on "my_gallery"
//	author: sunout sunout@mail.ru
//	http://magicdreamwebstudio.ru
//------project start in 2013 y-------------------------------------------------------------------

//-----LAN_PLUGIN_MD
define("LAN_PLUGIN_MD_NAME", "Волшебная галерея");
define("LAN_PLUGIN_MD_DESC", "Плагин ".LAN_PLUGIN_MD_NAME." предназначен для создания фотогалереи. Плагин подключается к различным модулям с помощью биби кода. Он основан на технологии CSS.");
define("LAN_PLUGIN_MD_INST", "Плагин успешно установлен.");
define("LAN_PLUGIN_MD_UNINST", "Плагин удален из системы.");
define("LAN_PLUGIN_MD_UPGRADE", "Плагин успешно обновлен.");
define("LAN_PLUGIN_MD_LINK", "Фотогалерея");
define("LAN_PLUGIN_MD_AUTHOR1", "Казанцев Сергей [sunout]");
define("LAN_PLUGIN_MD_AUTHOR2", "Лебедев Александр [StAlKeR_PeOpLe]");

//-----LAN_MENU_PLUGIN
define("LAN_MENU_CAPTION", "Волшебная галерея");

//-----LAN_ADMIN_CONFIG
define("LAN_ADMENU_CAP", "Меню галереи");
define("LAN_ADMENU_ALB", "Управление альбомами");
define("LAN_ADMENU_IMG", "Управление изображениями");
define("LAN_ADMENU_NEWPIC", "Новые изображения");
define("LAN_ADMENU_OPTION", "Опции");

define("LAN_ADMCAT_CAP", "Управление категориями");
define("LAN_ADMADD_CAP", "Добавление новых изображений");
define("LAN_ADMUPL_CAP", "Присланные пользователями изображения");
define("LAN_ADMOPT_CAP", "Опции фотогалереи");

//-----ADMIN_GENERAL
define("LAN_ADMGNL_CAP", "Главная страница");
define("LAN_ADMGNL_ID", "ID");
define("LAN_ADMGNL_NAME_ALB", "Альбом");
define("LAN_ADMGNL_AMOUNT", "Количество фото/размер, мб");
define("LAN_ADMGNL_USER", "Пользователь");
define("LAN_ADMGNL_OPT", "Опции");

//-----NAVIGATION
define("LAN_NAVI_CAP", "Главная страница");
define("LAN_NAVI_ALL", "Все альбомы");
define("LAN_NAVI_SEARCH", "Поиск");
define("LAN_NAVI_ADD", "Загрузить фото");
define("LAN_NAVI_PO", "Личный кабинет");

//-----MENU_CAPTION_RENDOMIZE_IMAGES
define("LAN_MENU_CAP_RND", "Случайная картинка");

define("LAN_ALBUM_ID", "ID");
define("LAN_ALBUM_USER", "Автор");
define("LAN_ALBUM_CAT", "Категория");
define("LAN_ALBUM_NAME", "Название");
define("LAN_ALBUM_DIR", "Название папки");
define("LAN_ALBUM_DESC", "Описание");
define("LAN_ALBUM_ICON", "Изображение");
define("LAN_ALBUM_RATE", "Рейтинг");
define("LAN_ALBUM_OPTIONS", "Опции");
define("LAN_CREATE_ALBUM", "Создать альбом");

define("LAN_CAT_ID", "ID");
define("LAN_CAT_NAME", "Название");
define("LAN_CAT_ICON", "Изображение");
define("LAN_CAT_DESC", "Описание");

//-----IMAGES
define('LAN_IMG_00',"Изображение");
define('LAN_IMG_01',"Загрузить картинку");
define('LAN_IMG_02',"Выберите изображение");
define('LAN_IMG_03',"Показать иконки");
define('LAN_IMG_04',"Поменять картинку");

//-----BUTTONS
define('LAN_BUT_ADD',"Добавить");
define('LAN_BUT_DEL',"Удалить");
define('LAN_BUT_EDIT',"Редактировать");
define('LAN_BUT_UPD',"Обновить");
define('LAN_BUT_RES',"Очистить");
define('LAN_BUT_CANS',"Отменить");
define('LAN_BUT_AGR',"Принять");
define('LAN_BUT_SEA',"Найти");
define('LAN_BUT_GO',"Перейти");
define('LAN_BUT_ADDBASK',"В корзину");
define("LAN_BUT_BASK","Корзина");
define("LAN_BUT_BEGIN","В начало");
define("LAN_BUT_BACK","Вернуться к выбору товара");

//-----MESSAGE
define('LAN_MES_START',"Catalog пока не готов к работе, пожалуйста, обратитесь к администратору сайта.");
define('LAN_MES_CAP',"Сообщение");
define('LAN_MES_00',"<font color=red>Настройки обновлены</font>");
define('LAN_MES_01',"<font color=red>Не выбрана запись для редактирования</font>");
define('LAN_MES_02',"<font color=red>Не выбрана запись для удаления</font>");
define('LAN_MES_03',"<font color=red>Вы действительно хотите удалить категорию</font>");
define('LAN_MES_04',"<font color=red>Вы пытаетесь добавить пустую категорию!</font>");
define('LAN_MES_05',"<font color=red>Категория успешно добавлена</font>");
define('LAN_MES_06',"<font color=red>Категория обновлена</font>");
define('LAN_MES_07',"<font color=red>Категория</font>");
define('LAN_MES_08',"<font color=red>удалена</font>");
define('LAN_MES_09',"<font color=red>Неправильный формат номера страницы!</font>");
define('LAN_MES_10',"<font color=red>Неправильный запрос к базе.</font>");
define('LAN_MES_11',"<font color=red>Вы пытаетесь добавить пустую подкатегорию!</font>");
define('LAN_MES_12',"<font color=red>Подкатегория успешно добавлена</font>");
define('LAN_MES_13',"<font color=red>Под-категория обновлена</font>");
define('LAN_MES_14',"<font color=red>Не вся информация была введена</font>");
define('LAN_MES_15',"<font color=red>Без картинки</font>");
define('LAN_MES_16',"<font color=red>Введите ваше имя, не более 20 символов!</font>");
define('LAN_MES_17',"<font color=red>Установки обновлены</font>");
define('LAN_MES_18',"<font color=red>Установки добавлены</font>");
define('LAN_MES_19',"<font color=red>Вы уже добавили этот товар в Вашу корзину</font>");
define("LAN_MES_EMPT_01","<font color=red>Ваша корзина пуста</font>");
define("LAN_MES_EMPT_02","<font color=red>Ваша корзина пуста (Содержимое корзины автоматически очищается после 24 часов неиспользования)</font>");
define("LAN_MES_NOLOGIN","Вы должны быть зарегестрированным пользователем.<br>Регистрация очень проста и не займет у вас много времени.<br><a href=".e_HTTP."signup.php><b>[Перейти к процедуре регистации]</b></a>");
define("LAN_MES_DISCOUNT","Чтобы воспользоваться типом скидки Накопительная, вы должны быть зарегестрированы.<br><a href=".e_HTTP."signup.php>Перейти к процедуре регистации?</a>");
define("LAN_MES_FILL","Возможно вы заполнили не все поля отмеченные заком *");

//-----CONFIRM
define("LAN_CAT_DEL_CONFIRM","Вы действительно хотите удалить категорию?");
define("LAN_ALB_DEL_CONFIRM","Вы действительно хотите удалить альбом?");
define("LAN_IMG_DEL_CONFIRM","Вы действительно хотите удалить изображение?");

define("MYGAL_L003", "Галерея");
define("MYGAL_L004", "Настройки сохранены");
define("MYGAL_L005", "Настройки галереи");
define("MYGAL_L006", "Путь к фотогалереи (URL):");
define("MYGAL_L007", "Количество иконок на странице (колонок * рядов):");
define("MYGAL_L008", "Максимальная высота иконки (в точках):");
define("MYGAL_L009", "Максимальная ширина иконки (в точках):");
define("MYGAL_L010", "Максимальная высота просмотра фотографии (в точках):");
define("MYGAL_L011", "Максимальная ширина просмотра фотографии (в точках):");
define("MYGAL_L012", "Путь к титульной картинке (URL):");
define("MYGAL_L013", "Название фотогалереи:");
define("MYGAL_L014", "Настройка меню галереи");
define("MYGAL_L015", "Заголовок меню галереи:");
define("MYGAL_L016", "Путь к каталогу для случайной выборки картинок (URL):");
define("MYGAL_L017", "Максимальный размер картинки в меню (в точках):");
define("MYGAL_L018", "Сохранить настройки");
define("MYGAL_L019", "Администрирование фотогалереи");
define("MYGAL_L020", "Необходимо выбрать галерею");
define("MYGAL_L021", "Навигация по галерее");
define("MYGAL_L022", "Скачать");
define("MYGAL_L023", "Положение панели навигации:");
define("MYGAL_L024", "Сверху страницы");
define("MYGAL_L025", "Внизу страницы");
define("MYGAL_L026", "Размер:");
define("MYGAL_L027", "Файл:");
define("MYGAL_L028", "Метод отображения иконок:");
define("MYGAL_L029", "Показывать иконки в виде слайдов (images/tn_blank.jpg)");
define("MYGAL_L030", "Показывать описание к галерее:");
define("MYGAL_L031", "Не активно");
define("MYGAL_L032", "Над галереей");
define("MYGAL_L033", "Под галереей");
define("MYGAL_L034", "Изменение описания для галереи:");
define("MYGAL_L035", "Сохранить");
define("MYGAL_L036", "Название");
define("MYGAL_L037", "Описание");
define("MYGAL_L038", "[Изменить]");
define("MYGAL_L039", "На главной странице показывать:");
define("MYGAL_L040", "Титульный файл");
define("MYGAL_L041", "Случайные файлы");
define("MYGAL_L042", "Количество случайных картинок:");
define("MYGAL_L043", "Меню Галереи");
define("MYGAL_L044", "Разрешить комментировать фотографии:");
define("MYGAL_L045", "Комментарии:");
define("MYGAL_L046", "Каталог/Раздел:");
define("MYGAL_L047", "Разрешить оценивать фотографии:");
define("MYGAL_L048", "Стиль отображения Highslide:");
define("MYGAL_L049", "Файлы иконок и просмотра:");
define("MYGAL_L050", "Файлы иконок");
define("MYGAL_L051", "Файлы просмотра");
define("MYGAL_L052", "Обновить существующие");
define("MYGAL_L053", "Создать/обновить");
define("MYGAL_L054", "Качество (%)");
define("MYGAL_L055", "Метод сортировки изображений:");
define("MYGAL_L056", "Переместить");
define("MYGAL_L057", "Закрыть");
define("MYGAL_L058", "Добавить изображение");
define("MYGAL_L059", "Спасибо. Ваша загрузка на сервер будет проверена администратором и добавлена, если будет одобрена.");
define("MYGAL_L060", "У вас нет необходимых разрешений на загрузку файлов на этот сервер.");
define("MYGAL_L061", "Ошибка!");
define("MYGAL_L062", "Имя");
define("MYGAL_L063", "e-mail");
define("MYGAL_L064", "Файл превышает указанный максимальный размер - удален.");
define("MYGAL_L065", "Удалить");
define("MYGAL_L066", "Опубликовать");
define("MYGAL_L067", "Прислал");
define("MYGAL_L068", "Последние добавления");
define("MYGAL_L069", "Последние комментарии");
define("MYGAL_L070", "Гость");
define("MYGAL_L071", "Оригинал");
define("MYGAL_L072", "Переместить");
define("MYGAL_L073", "Изображения");
define("MYGAL_L074", "Новые поступления");
define("MYGAL_L075", "Создать раздел");
define("MYGAL_L076", "Создать каталог");
define("MYGAL_L077", "Используются настройки плагина eHighSlide");
define("MYGAL_L078", "Удалить пустой альбом");
define("MYGAL_L079", "Каталоги");
define("MYGAL_L080", "Список каталогов");
define("MYGAL_L081", "Внимание, выбранные альбомы будут удалены вместе с изображениями!");
define("MYGAL_L082", "Галерея пользователя");
define("MYGAL_L083", "Посмотреть галерею пользователя");
define("MYGAL_L084", "Посмотреть профиль пользователя");
define("MYGAL_L085", "-пусто-");

?>