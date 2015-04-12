global $inp, $sql, $pref, $PLUGINS_DIRECTORY;

@include_once(e_PLUGIN.'loginza/languages/'.e_LANGUAGE.'-'.CHARSET.'.php');

$sql->db_Select($pref['loginza_db'],'*',"`user_id`='".intval($inp)."'");

$logres = $sql->db_Fetch();

if(isset($logres['identity'])){

	require_once(e_PLUGIN.'loginza/loginza_class.php');
	$loginza = new loginza;
	
	if($logres['hide']=='0'){
		$showhide = '<a href="'.SITEURL.$PLUGINS_DIRECTORY.'loginza/edit.php?user='.intval($inp).'&hide=1">'.LOGINZA_HIDE_ACC.'</a>';
	}else{
		$showhide = '<a href="'.SITEURL.$PLUGINS_DIRECTORY.'loginza/edit.php?user='.intval($inp).'&hide=0">'.LOGINZA_SHOW_ACC.'</a>';
	}

	return $loginza->getprovico($logres['identity']).'&nbsp;<a href="'.$logres['identity'].'">'.$logres['identity'].'</a>
	<br /><br />
	<script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
	<a href="https://loginza.ru/api/widget?token_url='.urlencode(SITEURL.$PLUGINS_DIRECTORY.'loginza/edit.php?user='.intval($inp)).
	'&providers_set='.implode(',',$pref['loginza_providers']).'&lang='.$pref['loginza_lang'].'" class="loginza">'.LOGINZA_ADD_ACC.'</a>
	&nbsp;&nbsp;&nbsp;<a href="'.SITEURL.$PLUGINS_DIRECTORY.'loginza/edit.php?user='.intval($inp).'&del=1">'.LOGINZA_DEL_ACC.'</a>
	&nbsp;&nbsp;&nbsp;'.$showhide;


}else{
	return '<script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
	<a href="https://loginza.ru/api/widget?token_url='.urlencode(SITEURL.$PLUGINS_DIRECTORY.'loginza/edit.php?user='.intval($inp)).'&providers_set='
		.implode(',',$pref['loginza_providers']).'&lang='.$pref['loginza_lang'].'" class="loginza">'.LOGINZA_ADD_ACC.'</a>';
}