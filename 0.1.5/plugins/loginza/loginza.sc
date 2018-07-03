if(!USER){

	global $e107, $pref, $PLUGINS_DIRECTORY;
	@include_once(e_PLUGIN.'loginza/languages/'.e_LANGUAGE.'-'.CHARSET.'.php');

	return '<div style="text-align:center;"><script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
		<a href="https://loginza.ru/api/widget?token_url='.urlencode(SITEURL.$PLUGINS_DIRECTORY.'loginza/auth.php?url='.urlencode($_SERVER['REQUEST_URI'])).'&amp;providers_set='
		.implode(',',$pref['loginza_providers']).'&amp;lang='.$pref['loginza_lang'].'" class="loginza">
		<img src="http://loginza.ru/img/sign_in_button_gray.gif" alt="'.LOGINZA_ENTER.'" />
		</a></div>';
	
}

return '';