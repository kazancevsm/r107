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

	require_once(HEADERF);
	
	@session_start();
	
	if(USER){ //���� ��� �����
		$text = '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/about.png" alt="INFO" /> '
		.LOGINZA_LOGIN_OK.'</h3></div><script type="text/javascript">
		setTimeout(\'location.replace("'.SITEURL.'")\', 1000);
		</script>';
	}else{
		@require_once('loginza_class.php');
		$loginza = new loginza;
		if(is_array($data = $loginza->get_data($_POST['token']))){
			if(!isset($data['error_type']) && isset($data['provider']) && isset($data['identity'])){ //��������� ��� �� ������ � ������
			
				$_SESSION['loginza'] = $data; //���������� � ������, �.�. ������� ������� �� ������ 2 ���� ����
				
				if(isset($_POST['email'])&&!isset($data['email'])){ $data['email'] = $_POST['email']; } //���� ���� � POST� -> �������� � ������� ������
				if(isset($_POST['nickname'])){ $data['nickname'] = $_POST['nickname']; }
				
				//���� ���� "��������" => ������������
				if($sql->db_Select($pref['loginza_db'],'user_id',"`identity` = '"
				.$tp->toDB($data['identity'])."' AND `provider` = '"
				.$tp->toDB($data['provider'])."'")){
				
					list($e_user_id) = $sql->db_Fetch();
					
					if($sql->db_Select('user','user_password',"`user_id`='".intval($e_user_id)."'")){
						list($e_pass) = $sql->db_Fetch();
						$text .= $loginza->loginza_e107($e_user_id, $e_pass, $_GET['url']);
					}else{
						$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '.LOGINZA_ERR.'User with ID '.intval($e_user_id).' is not found'.LOGINZA_ERR2.'</h3></div>';
					}
					unset($_SESSION['loginza']);
				}else{ //���� ��� ������ ������������ => ��������� ����+����� � ������
					if((isset($data['email']) && check_email($data['email'])) || (!isset($data['email']) && $pref['disable_emailcheck']==1)){ //���� ������� ���������� ����
						if($sql->db_Count('user','(`user_id`)'," WHERE `user_email`='".$tp->toDB($data['email'])."' OR `user_loginname` = '".$tp->toDB($data['identity'])."' LIMIT 1")==0){
							//��������� ���
							unset($err_nick);
							$data['nickname'] = trim($data['nickname']);
							if(isset($data['nickname'])){
								$nicklen = mb_strlen($data['nickname'], 'UTF-8');
								if($nicklen < 2 || $nicklen > varset($pref['displayname_maxlength'],15)){
									$err_nick[] = LOGINZA_LENG_NICK;
								}
								if($sql->db_Count('user','(`user_id`)'," WHERE `user_name`='".$tp->toDB($data['nickname'])."' LIMIT 1")>0){
									$err_nick[] = LOGINZA_HAS_NICK;
								}
							}else{
								$err_nick[] = LOGINZA_EMPTY_NICK;
							}
							//���� ���� ������ => �������
							if(is_array($err_nick)){
								$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/about.png" alt="INFO" /> ';
								for($b=0;$b<count($err_nick);$b++){
									$text .= $err_nick[$b];
								}
								$text .= '</h3></div><form action="'.e_SELF.'?'.e_QUERY.'" method="POST">
								<input type="hidden" name="token" value="'.htmlspecialchars($_POST['token'], ENT_QUOTES).'" />
								'.(isset($_POST['email'])?'<input type="hidden" name="email" value="'.htmlspecialchars($_POST['email'], ENT_QUOTES).'">':'').'
								<div class="forumheader3">'.LOGINZA_ENTER_NICK.': <input class="tbox" type="text" name="nickname" value="'.htmlspecialchars($data['nickname'], ENT_QUOTES).'" /></div>
								<br /><div class="forumheader3"><input type="submit" class="button" value="'.LOGINZA_OK.'" /></div>
								</form>';
							}else{
								$uniq = md5(md5(uniqid(rand(),1)));
								if((CHARSET == 'windows-1251') && function_exists('iconv')){ //���������� ���������
									$data['nickname'] = (($new_nick = iconv('UTF-8','CP1251',$data['nickname']))!=false?$new_nick:$data['nickname']);
									$data['name']['full_name'] = (($new_name = iconv('UTF-8','CP1251',$data['name']['full_name']))!=false?$new_name:$data['name']['full_name']);
								}
								/* ������ */
								if(isset($data['photo']) && preg_match("#^(http|https)://[a-z0-9\./-_]+(jpg|jpeg|png|gif)$#i",$data['photo'])){
									$data['photo'] = str_replace(array('\'', '"', '(', ')'), '', $data['photo']);
									if ($size = @getimagesize($data['photo']))
									{
										$avwidth = $size[0];
										$avheight = $size[1];
								
										$pref['im_width'] = varset($pref['im_width'], 120);
										$pref['im_height'] = varset($pref['im_height'], 100);
										if ($avwidth <= $pref['im_width'] || $avheight <= $pref['im_height']) 
										{
											$new_ava = $data['photo'];
										}else{
											$new_ava = '';
										}
									}else{
										$new_ava = '';
									}
								}else{
									$new_ava = '';
								}
								/* END ������ */
								
								// ��������� ������������
								$niq = $sql->db_Insert('user', "0, '".$tp->toDB(strip_tags($data['nickname']))."', '".$tp->toDB($data['identity'])."', '', '"
								.$uniq."', '', '".$tp->toDB($data['email'])."', '', '".$tp->toDB($new_ava)."', '', '1', '".time()."', '0', '"
								.time()."', '0', '0', '0', '0', '".$tp->toDB($e107->getip())."', '0', '0', '', '', '0', '0', '"
								.$tp->toDB($data['name']['full_name'])."', '', '', '', '0', '' ");
								
								if($niq>0){
									
									// ��������� �������� � ��������
									if($sql->db_Insert($pref['loginza_db'], "0, '".intval($niq)."', '".$tp->toDB($data['provider'])."', '".$tp->toDB($data['identity'])."', 0")>0){
									
										/* ���. ���� */
										$sql->db_Select('user_extended_struct','*');
										while($ext = $sql->db_Fetch()){
											if($ext['user_extended_struct_name']=='homepage' && isset($data['web']['default']) && preg_match("#^[a-z0-9]+://#si", $data['web']['default'])){
												$new_ext[]="`user_homepage`='".$tp->toDB($data['web']['default'])."'";
											}elseif($ext['user_extended_struct_name']=='icq' && isset($data['im']['icq']) && preg_match("#^[0-9\-]{5,9}$#", $data['im']['icq'])){
												$new_ext[]="`user_icq`='".$tp->toDB($data['im']['icq'])."'";
											}elseif($ext['user_extended_struct_name']=='jabber' && isset($data['im']['jabber']) && check_email($data['im']['jabber'])){
												$new_ext[]="`user_jabber`='".$tp->toDB($data['im']['jabber'])."'";
											}elseif($ext['user_extended_struct_name']=='skype' && isset($data['im']['skype']) && preg_match("#^[a-zA-Z0-9-_\.]{6,32}$#", $data['im']['skype'])){
												$new_ext[]="`user_skype`='".$tp->toDB($data['im']['skype'])."'";
											}
										}
										if(count($new_ext)>0){
											$sql->db_Select_gen("INSERT INTO #user_extended (user_extended_id, user_hidden_fields) values ('".intval($niq)."', '')");
											$sql->db_Update("user_extended", implode(',', $new_ext)." WHERE user_extended_id = '".intval($niq)."'");
										}
										/* END ���. ���� */
										
										$text .= $loginza->loginza_e107($niq, $uniq, $_GET['url']);
									
									}else{
										$text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '.LOGINZA_ERR.'Failed to add bind: '.intval($niq).' is not found'.LOGINZA_ERR2.'</h3></div>';
									}
									unset($_SESSION['loginza']);
								}else{
									$text = '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '
									.LOGINZA_NEWUSER_FAIL.'</h3></div></div>';
									unset($_SESSION['loginza']);
								}
							}
						}else{
							$text = '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '
							.LOGINZA_HAS_MAIL_OR_LOGIN.'</h3></div></div>';
							unset($_SESSION['loginza']);
						}
					}else{ //������ ������� ����
						if(isset($_POST['email']) && !check_email($_POST['email'])) $text .= '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '.
						LOGINZA_INVALID_EMAIL.'</h3></div><br />'; //���� ��� ��������� ������������
						$text .= '<form action="'.e_SELF.'?'.e_QUERY.'" method="POST">
						<input type="hidden" name="token" value="'.htmlspecialchars($_POST['token'], ENT_QUOTES).'" />
						<div class="forumheader3">'.LOGINZA_ENTER_EMAIL.' <input type="text" class="tbox" name="email" value="'.htmlspecialchars($_POST['email'], ENT_QUOTES).'" /></div>
						<br /><div class="forumheader3"><input type="submit" class="button" value="'.LOGINZA_OK.'" /></div>
						</form>';
					}
				}
				
			}else{ //���� ������ � ������ ��� "������" �����
				$text = '<div class="forumheader3"><h3><img src="'.e_PLUGIN.'loginza/images/abort.png" alt="STOP" /> '
				.(isset($data['error_message'])?htmlspecialchars($data['error_message'], ENT_QUOTES):LOGINZA_ERR.'empty provider or identity'.LOGINZA_ERR2).'</h3></div>';
			}
		}else{
			$text .= $data;
		}
	}
	
	$ns -> tablerender($pref['loginza_menu_title'], '<div style="text-align: center;">'.$text.'</div>');
	
	require_once(FOOTERF);

?>