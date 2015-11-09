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

	@require_once('../../class2.php');
	
	global $sql, $tp, $pref, $PLUGINS_DIRECTORY;
	
	@include_once(e_PLUGIN.'loginza/languages/'.e_LANGUAGE.'-'.CHARSET.'.php');
	
	$adm_user = $sql->db_Count('user','(`user_id`)'," WHERE `user_admin`='1' AND `user_id`='".intval($_GET['user'])."'");
	
	//���� (�� ���� ������� � �� �����) ��� (������� ������ � �� ����) => �������
	if((USERID != $_GET['user'] && !ADMIN) || (USERID != $_GET['user'] && $adm_user != 0)){
		header('Location: '.SITEURL);
		exit;
	}
	
	require_once(HEADERF);
	
	if(isset($_GET['del'])){
		if($_GET['del']==$_SESSION['loginza_del']){
			if($sql->db_Delete($pref['loginza_db'],"`user_id`='".intval($_GET['user'])."'")){
				$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/apply.png" alt="OK" /> '
				.LOGINZA_DEL_OK.'</h3></div>';
			}else{
				$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '
				.LOGINZA_ERR.'</h3></div>';
			}
			unset($_SESSION['loginza_del']);
		}else{
			$uniq = md5(uniqid(rand(),1));
			$_SESSION['loginza_del'] = $uniq;
			$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/about.png" alt="INFO" /> 
			'.LOGINZA_DEL_Q.'<br /><input type="button" onclick="location.href=\''.SITEURL.$PLUGINS_DIRECTORY.'loginza/edit.php?user='.intval($_GET['user'])
			.'&del='.$uniq.'\'" class="button" value="'.LOGINZA_YES.'" />&nbsp;&nbsp;&nbsp;<input type="button" onclick="history.back();" class="button" value="'.LOGINZA_NO.'" />
			</div>';
		}
	}elseif(isset($_GET['hide'])){
		$sql->db_Update($pref['loginza_db'],"`hide`='".intval($_GET['hide'])."' WHERE `user_id`='".intval($_GET['user'])."'");
		$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/apply.png" alt="OK" /> OK</h3></div><script type="text/javascript">
			setTimeout(\'location.replace("'.e_HTTP.'usersettings.php?'.intval($_GET['user']).'")\', 500);</script>';
	}else{
	
		require_once('loginza_class.php');
		$loginza = new loginza;
	
		if(is_array($data = $loginza->get_data($_POST['token']))){
			if(!isset($data['error_type']) && isset($data['provider']) && isset($data['identity'])){ //��������� ��� �� ������ � ������
				
				if($sql->db_Select($pref['loginza_db'],'`user_id`',"`identity` = '"
				.$tp->toDB($data['identity'])."' AND `provider` = '".$tp->toDB($data['provider'])."'")){ //���� ��� ����
					$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '
					.LOGINZA_HAS_ACC.'</h3></div><script type="text/javascript">
					setTimeout(\'location.replace("'.SITEURL.'user.php?id.'.intval($_GET['user']).'")\', 5000);
					</script>';
				}else{
					
					if($sql->db_Select($pref['loginza_db'],'*',"`user_id` = '".intval($_GET['user'])."'")){
						$result2 = $sql->db_Fetch();
						if($sql->db_Update($pref['loginza_db'], "`provider`='".$tp->toDB($data['provider'])."', `identity`='"
						.$tp->toDB($data['identity'])."' WHERE `id`='".intval($result2['id'])."'")){
							$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/apply.png" alt="OK" /> '
							.LOGINZA_LOGIN_OK.'</h3></div><script type="text/javascript">
							setTimeout(\'location.replace("'.SITEURL.'user.php?id.'.intval($_GET['user']).'")\', 1000);
							</script>';
						}else{
							$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '
							.LOGINZA_ERR.'update)</h3></div>';
						}
					}else{
						if($sql->db_Insert($pref['loginza_db'], "0, '".intval($_GET['user'])."', '".$tp->toDB($data['provider'])."', '"
						.$tp->toDB($data['identity'])."', 0")>0){
							$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/apply.png" alt="OK" /> '
							.LOGINZA_LOGIN_OK.'</h3></div><script type="text/javascript">
							setTimeout(\'location.replace("'.SITEURL.'user.php?id.'.intval($_GET['user']).'")\', 1000);
							</script>';
						}else{
							$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '
							.LOGINZA_ERR.'insert)</h3></div>';
						}
					}
				}
				
			}else{ //���� ������ � ������
				$text = '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '
				.(isset($data['error_message'])?htmlspecialchars($data['error_message'], ENT_QUOTES):LOGINZA_ERR).'</h3></div>';
			}
		}else{
			$text .= $data;
		}
	}
	
	$ns -> tablerender(LOGINZA_ENTER_CAP, '<div style="text-align: center;">'.$text.'</div>');
	
	require_once(FOOTERF);

?>