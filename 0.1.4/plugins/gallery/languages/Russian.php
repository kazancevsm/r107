<?php
/*
+ ----------------------------------------------------------------------------------------------+
|     e107 website system  : http://e107.org.ru
|     Released under the terms and conditions of the GNU General Public License (http://gnu.org).
|
|     Plugin "my_gallery"
|     Author: Alex ANP alex-anp@ya.ru
|     Home page: http://e107.seafoxy.ru
|				 http://e107plugins.blogspot.com
+-----------------------------------------------------------------------------------------------+
*/
define("LAN_GAL_NAME", "Галерея");
define("LAN_GAL_MENU_NAME", "Меню галереи");
define("LAN_GAL_ABOUT", "Плагин Галерея создает фотогалерею, основан на технологии Highslide JS");

//-----Меню
define("LAN_GAL_MENU_CAP", "Галерея");
define("LAN_GAL_MENU_CAT", "Каталоги");
define("LAN_GAL_MENU_ADD_CAT", "Создать каталог");
define("LAN_GAL_MENU_IMG_UPLOAD", "Добавить изображение");
define("LAN_GAL_MENU_IMG", "Изображения");
define("LAN_GAL_MENU_OPTIONS", "Настройки");

//----- Заголовки страниц
define("LAN_GAL_CAP_CAT_MAN", "Управление каталогами");
define("LAN_GAL_CAP_CAT_CRE", "Создание каталогов");
define("LAN_GAL_CAP_IMG", "Изображения");
define("LAN_GAL_CAP_IMG_UP", "Добавить изображение");
define("LAN_GAL_CAP_OPTIONS", "Настройки галереи");

//----- Каталоги
define("LAN_GAL_CAT_NAME", "Название альбома/раздела");
define("LAN_GAL_CAT_DESC", "Описание альбома/раздела");
define("LAN_GAL_CAT_IMG", "Изображение альбома/раздела");
define("LAN_GAL_PARENT", "Родитель");
define("LAN_GAL_NOPARENT", "Нет родителя (главный раздел)");
define("LAN_GAL_DIR", "Директория");
define("LAN_GAL_DATE", "Дата");
define("LAN_GAL_USER", "Пользователь");
define("LAN_GAL_CAT", "Каталог");
define("LAN_GAL_COUNT", "Просмотры");
define("LAN_GAL_OPTIONS", "Опции");
define("LAN_GAL_SUBCAT_CRE", "Создать подкаталог");

//----- Изображения
define("LAN_GAL_IMG_IMG", "Изображение");
define("LAN_GAL_IMG_NAME", "Название");
define("LAN_GAL_IMG_DESC", "Описание");
define("LAN_GAL_IMG_STATUS", "Статус");
define("LAN_GAL_IMG_COUNT", "Просмотры");
define("LAN_GAL_IMG_OPTIONS", "Опции");
define("LAN_GAL_IMG_FILE", "Файл:");
define("LAN_GAL_IMG_BROUSE", "Обзор");

//----- Настройки галереи
define("LAN_GAL_OPT_CAP", "Настройки галереи");
define("LAN_GAL_OPT_CAP1", "Главная страница галереи");
define("LAN_GAL_OPT_CAP2", "Общие настройки");
define("LAN_GAL_OPT_CAP3", "Эффекты и оформление");
define("LAN_GAL_OPT_CAP4", "Случайная картинка");
define("LAN_GAL_OPT_CAP5", "Новые поступления");
define("LAN_GAL_OPT_CAP6", "Загрузка изображений");
define("LAN_GAL_OPT_CAP7", "Меню галереи");

//----- Кнопки
define("LAN_GAL_BUT_PUBLIC", "Опубликовать");
define("LAN_GAL_BUT_CREATE", "Создать");
define("LAN_GAL_BUT_UPDATE", "Обновить");
define("LAN_GAL_BUT_MOVE", "Переместить");
define("LAN_GAL_BUT_CAN", "Отменить");
define("LAN_GAL_BUT_EDIT", "Редактировать");

//-----Сообщения
define("LAN_GAL_MES", "Сообщение");
define("LAN_GAL_MES_INSTALL", "Плагин успешно установлен");
define("LAN_GAL_MES_UPGRADE", "Плагин успешно обнавлен");
define("LAN_GAL_MES_ADD_PREFS", "Настройки добавлены");
define("LAN_GAL_MES_REM_PREFS", "Настройки удалены");
define("LAN_GAL_MES_SAVE_PREFS", "Настройки сохранены");
define("LAN_GAL_MES_ADD_CAT", "Категория успешно добавлена");
define("LAN_GAL_MES_UPD_CAT", "Категория успешно обновлена");
define("LAN_GAL_MES_DIR_CRE", "создана");
define("LAN_GAL_MES_DELETE", "удален");
define("LAN_GAL_MES_NOCRE", "Проверте правильнсоть заполнения формы, обязательных полей");

define("LAN_GAL_OPT_001", "Название фотогалереи:");
define("LAN_GAL_OPT_002", "На главной странице показывать:");
define("LAN_GAL_OPT_003", "Последние добавления");
define("LAN_GAL_OPT_004", "Последние комментарии");
define("LAN_GAL_OPT_005", "Случайные файлы");
define("LAN_GAL_OPT_006", "Положение панели навигации:");
define("LAN_GAL_OPT_007", "Сверху страницы");
define("LAN_GAL_OPT_008", "Внизу страницы");
define("LAN_GAL_OPT_009", "Показывать описание к галерее:");
define("LAN_GAL_OPT_010", "Не активно");
define("LAN_GAL_OPT_011", "Над галереей");
define("LAN_GAL_OPT_012", "Под галереей");
define("LAN_GAL_OPT_013", "Количество иконок на странице (колонок * рядов):");
define("LAN_GAL_OPT_014", "Максимальная высота и ширина иконки (в точках):");
//define("LAN_GAL_OPT_015", "Максимальная ширина иконки (в точках):");
define("LAN_GAL_OPT_015", "Максимальная высота и ширина просмотра фотографии (в точках):");
//define("LAN_GAL_OPT_017", "Максимальная ширина просмотра фотографии (в точках):");
define("LAN_GAL_OPT_018", "Метод отображения иконок:");
define("LAN_GAL_OPT_019", "Показывать иконки в виде слайдов (images/tn_blank.jpg)");
define("LAN_GAL_OPT_020", "Стиль отображения Highslide:");
define("LAN_GAL_OPT_021", "Используются настройки плагина eHighSlide");
define("LAN_GAL_OPT_022", "Разрешить комментировать фотографии:");
define("LAN_GAL_OPT_023", "Разрешить оценивать фотографии:");
define("LAN_GAL_OPT_024", "Метод сортировки изображений:");
define("LAN_GAL_OPT_025", "Заголовок меню галереи:");
define("LAN_GAL_OPT_026", "Максимальный размер картинки в меню (в точках):");
//define("LAN_GAL_OPT_027", "Количество случайных картинок:");
define("LAN_GAL_OPT_028", "При загрузке создавать:");
define("LAN_GAL_OPT_029", "Файлы иконок");
define("LAN_GAL_OPT_030", "Файлы просмотра");
define("LAN_GAL_OPT_031", "Оригинал");
define("LAN_GAL_OPT_032", "Качество (%)");
define("LAN_GAL_OPT_033", "Количество случайных изображений в меню (колонок * рядов):");

define("LAN_GAL_L038", "[Изменить]");
define("LAN_GAL_L002", "Случайная картинка");


define("LAN_GAL_L012", "Путь к титульной картинке (URL):");



define("LAN_GAL_L016", "Путь к каталогу для случайной выборки картинок (URL):");

define("LAN_GAL_L018", "Сохранить настройки");
define("LAN_GAL_L019", "Администрирование фотогалереи");
define("LAN_GAL_L020", "Необходимо выбрать галерею");
define("LAN_GAL_L021", "Навигация по галерее");
define("LAN_GAL_L022", "Скачать");
define("LAN_GAL_L026", "Размер:");
define("LAN_GAL_L034", "Изменение описания для галереи:");
define("LAN_GAL_L035", "Сохранить");
define("LAN_GAL_L045", "Комментарии:");
define("LAN_GAL_L052", "Обновить существующие");
define("LAN_GAL_L053", "Создать/обновить");
define("LAN_GAL_L056", "Переместить");
define("LAN_GAL_L057", "Закрыть");
define("LAN_GAL_L059", "Спасибо. Ваша загрузка на сервер будет проверена администратором и добавлена, если будет одобрена.");
define("LAN_GAL_L060", "У вас нет необходимых разрешений на загрузку файлов на этот сервер.");
define("LAN_GAL_L061", "Ошибка!");
define("LAN_GAL_L062", "Имя");
define("LAN_GAL_L063", "e-mail");
define("LAN_GAL_L064", "Файл превышает указанный максимальный размер - удален.");
define("LAN_GAL_L065", "Удалить");
define("LAN_GAL_L067", "Прислал");
define("LAN_GAL_L070", "Гость");
define("LAN_GAL_L073", "Изображения");
define("LAN_GAL_L074", "Новые поступления");
define("LAN_GAL_L075", "Создать раздел");
define("LAN_GAL_L076", "Создать каталог");
define("LAN_GAL_L078", "Удалить пустой альбом");
define("LAN_GAL_L081", "Внимание, выбранные альбомы будут удалены вместе с изображениями!");
define("LAN_GAL_L082", "Галерея пользователя");
define("LAN_GAL_L083", "Посмотреть галерею пользователя");
define("LAN_GAL_L084", "Посмотреть профиль пользователя");
define("LAN_GAL_L085", "-пусто-");


?>