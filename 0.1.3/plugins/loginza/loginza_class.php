<?php
/*
+-------------------------------------------------------------------------
|
|     Loginza plugin version 0.5 for e107
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

if (!defined('e107_INIT')) { exit; }

class loginza{
	
	function loginza_e107($user_id,$userpass,$url = ''){ //�����������
		global $pref;
		$cookieval = $user_id.'.'.md5($userpass);
		if ($pref['user_tracking'] == "session") {
			$_SESSION[$pref['cookie_name']] = $cookieval;
		} else {
			cookie($pref['cookie_name'], $cookieval, (time() + 3600 * 24 * 30));
		}
		return '<div class="r_header3"><h3><img src="'.e_PLUGIN.'loginza/images/apply.png" alt="OK" /> '
			.LOGINZA_LOGIN_OK.'</h3></div><script type="text/javascript">
			setTimeout(\'location.replace("'.($url!=''?htmlspecialchars(urldecode($_GET['url']), ENT_QUOTES):SITEURL).'")\', 1000);
			</script>';
	}
	
	function get_data($token = ''){
		global $pref;
		
		//fix
		if($_SESSION['loginza']) return $_SESSION['loginza'];
		
		//���� ������ �����
		if(!preg_match('#^[a-z0-9]{32}$#i',$token))
			return '<div class="r_header3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '.LOGINZA_EMPTY_TOKEN.'</h3></div>';
			
		if($pref['loginza_secure_login']=='1' && is_numeric($pref['loginza_widget_id']) && $pref['loginza_api_signature']!=''){
			$sign = '&id='.$pref['loginza_widget_id'].'&sig='.md5($token.$pref['loginza_api_signature']);
		}
		
		if($pref['loginza_connect'] == 0 && @ini_get('allow_url_fopen') == 1){		//���� allow_url_fopen = Off
			$data_f = file_get_contents('http://loginza.ru/api/authinfo?token='.$token.$sign);
		}
		
		if($pref['loginza_connect'] == 1 && function_exists('curl_init')){
			if ($ch = @curl_init()) {

                @curl_setopt($ch, CURLOPT_URL,              'http://loginza.ru/api/authinfo?token='.$token.$sign);
                @curl_setopt($ch, CURLOPT_HEADER,           false);
                @curl_setopt($ch, CURLOPT_RETURNTRANSFER,   true);
                @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,   3);

                $data_f = @curl_exec($ch);

                @curl_close($ch);
            }
		}
		
		if($pref['loginza_connect'] == 2){
			$buff = '';
            $fp = @fsockopen('loginza.ru', 80, $errno, $errstr, 3);
            if ($fp) {
                @fputs($fp, "GET /api/authinfo?token=".$token.$sign." HTTP/1.0\r\nHost: loginza.ru\r\n");
                @fputs($fp, "User-Agent: PHP\r\n\r\n");
                while (!@feof($fp)) {
                    $buff .= @fgets($fp, 128);
                }
                @fclose($fp);

                $page = explode("\r\n\r\n", $buff);

                $data_f = $page[1];
            }
		}
		
		if($data_f){
			if(function_exists('json_decode')){
				$data = json_decode($data_f, true);
			}else{
				@include_once('JSON.php');
				$json = new Services_JSON();
				$data = (array) $json->decode($data_f);
			}
			return $data;
		}else{
			return '<div class="r_header3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '.LOGINZA_ERR.'get data'.LOGINZA_ERR2.'</h3></div>';
		}
	}
	
	function getprovico($prov){
		$providers = array(
			'yandex.ru' => 'yandex.png',
			'ya.ru' => 'yandex.png',
			'vkontakte.ru' => 'vkontakte.png',
			'vk.com' => 'vkontakte.png',
			'loginza.ru' => 'loginza.png',
			'myopenid.com' => 'myopenid.png',
			'livejournal.com' => 'livejournal.png',
			'google.ru' => 'google.png',
			'google.com' => 'google.png',
			'flickr.com' => 'flickr.png',
			'mail.ru' => 'mailru.png',
			'rambler.ru' => 'rambler.png',
			'webmoney.ru' => 'webmoney.png',
			'webmoney.com' => 'webmoney.png',
			'wmkeeper.com' => 'webmoney.png',
			'wordpress.com' => 'wordpress.png',
			'blogspot.com' => 'blogger.png',
			'diary.ru' => 'diary',
			'bestpersons.ru' => 'bestpersons.png',
			'facebook.com' => 'facebook.png',
			'twitter.com' => 'twitter.png',
			'last.fm' => 'lastfm.png',
			'lastfm.ru' => 'lastfm.png'
		);
		
		$icon_dir = SITEURLBASE.e_PLUGIN_ABS.'loginza/images/';
	
		if (preg_match('/^https?:\/\/([^\.]+\.)?([a-z0-9\-\.]+\.[a-z]{2,5})/i', $prov, $matches)) {

			$provider_key = $matches[2];
				
			if (array_key_exists($provider_key, $providers)) {
				return '<img src="'.$icon_dir.$providers[$provider_key].'" alt="'.$provider_key.'" class="loginza_provider_ico" />';
			}
		}
		
		return '<img src="'.$icon_dir.'openid.png" alt="OpenID" class="loginza_provider_ico" />';
	}
}

?>