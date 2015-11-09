global $user, $sql, $pref;

@include_once(e_PLUGIN.'loginza/languages/'.e_LANGUAGE.'-'.CHARSET.'.php');

$sql->db_Select($pref['loginza_db'],'*',"`user_id`='".intval($user['user_id'])."'");

$logres = $sql->db_Fetch();

require_once(e_PLUGIN.'loginza/loginza_class.php');
$loginza = new loginza;

if($logres['hide']=='1' && USERID!=$user['user_id'] && !ADMIN){
	return LOGINZA_HIDDEN_ACC;
}

return $loginza->getprovico($logres['identity']).'&nbsp;<a href="'.$logres['identity'].'">'.$logres['identity'].'</a>';
