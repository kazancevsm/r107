<?php
/*
+-------------------------------------------------------------------------
|
|     Loginza plugin version 0.4.2 for e107
|
|     Author: Evlanov Alexander (Kapman)
|     alex@aleksander.org.ru
|     http://free-lance.ru/users/kapman
|
|     Translate into English by joginvik (modified by Kapman)
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
+-------------------------------------------------------------------------
*/

define(LOGINZA_DESC,'Easy enter on site via <a href="http://loginza.ru">Loginza.API</a>. Loginza.API - easy login with (OpenID, Google, Yandex and so on).');
define(LOGINZA_ENTER,'Easy Enter');
define(LOGINZA_ENTER_CAP,'Easy Enter');
define(LOGINZA_EMPTY_TOKEN,'Null Token!');
define(LOGINZA_LOGIN_OK,'OK');
define(LOGINZA_HAS_NICK,'<p style="color: red;">Used nick</p>');
define(LOGINZA_LENG_NICK,'<p style="color: red;">Nick must be from 2 till '.varset($pref['displayname_maxlength'],15).'.</p>');
define(LOGINZA_EMPTY_NICK,'<p style="color: red;">Null Nick</p>');
define(LOGINZA_ENTER_NICK,'Please, enter your nick');
define(LOGINZA_OK,'More');
define(LOGINZA_HAS_MAIL_OR_LOGIN,'<p style="color: red;">Nick in use</p>');
define(LOGINZA_INVALID_EMAIL,'<p style="color: red;">Wrong Email</p>');
define(LOGINZA_ENTER_EMAIL,'Please, enter your Email');
define(LOGINZA_PROFILE,'Attached account:');
define(LOGINZA_EDIT_DESC,'Under this account you can enter.');
define(LOGINZA_ADD_ACC,'Attache');
define(LOGINZA_DEL_ACC,'Delete');
define(LOGINZA_HIDE_ACC,'Hide'); //0.5
define(LOGINZA_SHOW_ACC,'Show'); //0.5
define(LOGINZA_HIDDEN_ACC,'Hidden by request'); //0.5
define(LOGINZA_DEL_OK,'Deleted');
define(LOGINZA_DEL_Q,'Shure?');
define(LOGINZA_YES,'Yes');
define(LOGINZA_NO,'No');
define(LOGINZA_ERR,'Mistake (');
define(LOGINZA_ERR2,')! Write to site admin.');
define(LOGINZA_NEWUSER_FAIL,'Mistake! New user was not created. Write to site admin.');
define(LOGINZA_403,'No right!');
define(LOGINZA_HAS_ACC,'<p style="color: red;">This OpenID in use.</p>');
define(LOGINZA_ADMIN_SAVED,'Saved');
define(LOGINZA_ADMIN_SAVE,'Save');
define(LOGINZA_ADMIN_CONF,'Options');
define(LOGINZA_ADMIN_PROVS,'Providers');
define(LOGINZA_ADMIN_PROV,'Use Ctrl for selecting few providers');
define(LOGINZA_ADMIN_LANG,'Language');
define(LOGINZA_ADMIN_RU,'Russian');
define(LOGINZA_ADMIN_UK,'Ukrainian');
define(LOGINZA_ADMIN_EN,'English');
define(LOGINZA_ADMIN_STAT,'Stats/Delete');
define(LOGINZA_ADMIN_TOTAL,'All attachments:');
define(LOGINZA_ADMIN_MENU,'Menu');
define(LOGINZA_ADMIN_DEL_ACC,'Delete unused attachments');
define(LOGINZA_ADMIN_DEL_OK,'Deleted');
define(LOGINZA_ADMIN_CONNECT,'Connection method to server'); //0.5
define(LOGINZA_MENU_TITLE,'Menu title'); //0.5
define(LOGINZA_SECURE_LOGIN,'Safe mode check token'); //0.5
define(LOGINZA_ENABLED,'Enabled'); //0.5
define(LOGINZA_SECRET_KEY,'Secret key'); //0.5
define(LOGINZA_SECURE_DESC,'<p class="smalltext">For maximum security authentication mode must use the secure verification token.<br />
Receive ID widget and secret key it is possible in section <a href="https://loginza.ru/my-widgets" rel="external">My widget Loginza</a> of your account Loginza (registration required).</p>'); //0.5


?>