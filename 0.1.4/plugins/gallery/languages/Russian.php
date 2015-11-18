<?php
//------md_gallery--------------------------------------------------------------------------------
//	for e107 website system : http://e107.org.ru
//	released under the terms and conditions of the GNU General Public License (http://gnu.org)
//	is based on "my_gallery"
//	author: sunout sunout@mail.ru
//	http://magicdreamwebstudio.ru
//------project start in 2013 y-------------------------------------------------------------------

//-----MG_PLUGIN
define("MG_PLUGIN_NAME", "Волшебная галерея");
define("MG_PLUGIN_DESC", "Плагин ".MG_PLUGIN_NAME." предназначен для создания фотогалереи. Плагин подключается к различным модулям с помощью биби кода. Он основан на технологии CSS.");
define("MG_PLUGIN_INST", "Плагин успешно установлен.");
define("MG_PLUGIN_UNINST", "Плагин удален из системы.");
define("MG_PLUGIN_UPGRADE", "Плагин успешно обновлен.");
define("MG_PLUGIN_LINK", "Фотогалерея");
define("MG_PLUGIN_AUTHOR1", "Казанцев Сергей [sunout]");
define("MG_PLUGIN_AUTHOR2", "Лебедев Александр [StAlKeR_PeOpLe]");

//-----MG_MENU_PLUGIN
define("MG_MENU_CAPTION", "Волшебная галерея");

//-----MG_ADMIN_CONFIG
define("MG_ADMENU_CAP", "Меню галереи");
define("MG_ADMENU_GNL", "Главная страница");
define("MG_ADMENU_ALB", "Альбомы");
define("MG_ADMENU_ADDPIC", "Добавить изображение");
define("MG_ADMENU_NEWPIC", "Новые изображения");
define("MG_ADMENU_OPTION", "Опции");

define("MG_ADMCAT_CAP", "Управление категориями");
define("MG_ADMADD_CAP", "Добавление новых изображений");
define("MG_ADMUPL_CAP", "Присланные пользователями изображения");
define("MG_ADMOPT_CAP", "Опции фотогалереи");

//-----MG_ADMIN_GENERAL
define("MG_ADMGNL_CAP", "Главная страница");
define("MG_ADMGNL_ID", "ID");
define("MG_ADMGNL_NAME_ALB", "Альбом");
define("MG_ADMGNL_AMOUNT", "Количество фото/размер, мб");
define("MG_ADMGNL_USER", "Пользователь");
define("MG_ADMGNL_OPT", "Опции");

//-----MG_NAVIGATION
define("MG_NAVI_CAP", "Главная страница");
define("MG_NAVI_ALL", "Все альбомы");
define("MG_NAVI_SEARCH", "Поиск");
define("MG_NAVI_ADD", "Загрузить фото");
define("MG_NAVI_PO", "Личный кабинет");

//-----MG_MENU
define("MG_MENU_CAP", "Случайная картинка"); //MYGAL_L002

define("MG_ALBUM_ID", "ID");
define("MG_ALBUM_USER", "id пользователя");
define("MG_ALBUM_CAT", "Категория");
define("MG_ALBUM_NAME", "Название");
define("MG_ALBUM_DIR", "Название папки");
define("MG_ALBUM_DESC", "Описание");
define("MG_ALBUM_ICON", "Изображение");
define("MG_ALBUM_RATE", "Рейтинг");
define("MG_CREATE_ALBUM", "Создать альбом");


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