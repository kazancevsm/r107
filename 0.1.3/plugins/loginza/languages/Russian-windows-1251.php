<?php
/*
+-------------------------------------------------------------------------
|
|     Loginza plugin version 0.4 for e107
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

define(LOGINZA_DESC,'Плагин реализует возможность входа на сайт через <a href="http://loginza.ru">Loginza.API</a>. Loginza.API - это единый механизм авторизации использующий различные алгоритмы аутентификации пользователей различных провайдеров учетных записей (OpenID, Google, Yandex и тп.).');
define(LOGINZA_ENTER,'Войти через loginza');
define(LOGINZA_ENTER_CAP,'Вход через loginza');
define(LOGINZA_EMPTY_TOKEN,'Пустой Token!');
define(LOGINZA_LOGIN_OK,'Авторизация прошла успешно');
define(LOGINZA_HAS_NICK,'<p style="color: red;">Ник занят</p>');
define(LOGINZA_LENG_NICK,'<p style="color: red;">Длина ника должна быть от 2 до '.varset($pref['displayname_maxlength'],15).' символов.</p>');
define(LOGINZA_EMPTY_NICK,'<p style="color: red;">Пустой ник</p>');
define(LOGINZA_ENTER_NICK,'Пожалуйста, укажите Ваш ник');
define(LOGINZA_OK,'Далее');
define(LOGINZA_HAS_MAIL_OR_LOGIN,'<p style="color: red;">Указанный Email или логин уже используется другим пользователей</p>');
define(LOGINZA_INVALID_EMAIL,'<p style="color: red;">Некорректный Email</p>');
define(LOGINZA_ENTER_EMAIL,'Пожалуйста, укажите Ваш Email');
define(LOGINZA_PROFILE,'Прикреплённый аккаунт:');
define(LOGINZA_EDIT_DESC,'Через указанный аккаунт Вы можете авторизироваться под этим пользователем.');
define(LOGINZA_ADD_ACC,'Прикрепить');
define(LOGINZA_DEL_ACC,'Удалить');
define(LOGINZA_DEL_OK,'Привязка удалена');
define(LOGINZA_DEL_Q,'Вы уверены, что хотите удалить?');
define(LOGINZA_YES,'Да');
define(LOGINZA_NO,'Нет');
define(LOGINZA_ERR,'Ошибка (');
define(LOGINZA_ERR2,')! Обратитесь к администратору сайта.');
define(LOGINZA_NEWUSER_FAIL,'Ошибка! Не удалось создать нового пользователя. Если ошибка повторится - обратитесь к администратору сайта.');
define(LOGINZA_403,'Доступ запрещён!');
define(LOGINZA_HAS_ACC,'<p style="color: red;">Этот OpenID уже привязан к другому аккаунту.</p>');
define(LOGINZA_ADMIN_SAVED,'Сохранено');
define(LOGINZA_ADMIN_SAVE,'Сохранить');
define(LOGINZA_ADMIN_CONF,'Настройки');
define(LOGINZA_ADMIN_PROVS,'Провайдеры');
define(LOGINZA_ADMIN_PROV,'Для выбора нескольких провайдеров используйте Ctrl');
define(LOGINZA_ADMIN_LANG,'Язык');
define(LOGINZA_ADMIN_RU,'Русский');
define(LOGINZA_ADMIN_UK,'Украинский');
define(LOGINZA_ADMIN_EN,'Английский');
define(LOGINZA_ADMIN_STAT,'Статистика/Очистка');
define(LOGINZA_ADMIN_TOTAL,'Всего привязок:');
define(LOGINZA_ADMIN_MENU,'Меню');
define(LOGINZA_ADMIN_DEL_ACC,'Удалить неиспользуемые привязки');
define(LOGINZA_ADMIN_DEL_OK,'Удалены');

?>