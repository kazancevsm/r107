<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Steve Dunstan 2001-2002
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/email_handler.php $
|     $Revision: 11948 $
|     $Id: email_handler.php 11948 2010-11-02 22:36:41Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

// Experimental e-token
if (isset($_POST['emailsubmit']) && !isset($_POST['e-token']))
{
	// set e-token so it can be processed by class2
	$_POST['e-token'] = '';
}

require_once("class2.php");
if (!check_class(varset($pref['email_item_class'],e_UC_MEMBER)))
{
	header('Location: '.e_BASE.'index.php');
	exit();
}
require_once(HEADERF);

$use_imagecode = FALSE;
$imgtypes = array('jpeg', 'png', 'gif');
foreach($imgtypes as $t)
{
	if(function_exists('imagecreatefrom'.$t))
	{
		$use_imagecode = TRUE;
	}
}

if ($use_imagecode)
{
	require_once(e_HANDLER.'secure_img_handler.php');
	$sec_img = new secure_image;
}

if (e_QUERY)
{
	$qs = explode('.', e_QUERY, 2);
}
else
{
	header('location:'.e_BASE.'index.php');
	exit;
}
$source = $qs[0];
$parms = varset($qs[1], '');
unset($qs);
$error = '';
$message = '';

$referrer = strip_tags(urldecode(html_entity_decode(varset($_SERVER['HTTP_REFERER'],''), ENT_QUOTES)));
$emailurl = ($source == 'referer') ? $referrer : SITEURL;

$comments = $tp->post_toHTML(varset($_POST['comment'],''), TRUE, 'retain_nl, emotes_off, no_make_clickable');
$author = $tp->post_toHTML(varset($_POST['author_name'],''),FALSE,'emotes_off, no_make_clickable');
$email_send = check_email(varset($_POST['email_send'],''));


if (isset($_POST['emailsubmit']))
{
	if (!$email_send)
	{
		$error .= LAN_EMAIL_106;
	}

	if($use_imagecode)
	{
		if(!isset($_POST['code_verify']) || !isset($_POST['rand_num']))
		{
			header('location:'.e_BASE.'index.php');
			exit;
		}
		if (!$sec_img->verify_code($_POST['rand_num'], $_POST['code_verify']))
		{
			header('location:'.e_BASE.'index.php');
			exit;
		}
	}

	if ($comments == '')
	{
		$message = LAN_EMAIL_6.' '.SITENAME.' ('.SITEURL.')';
		if (USER == TRUE)
		{
			$message .= "\n\n".LAN_EMAIL_1." ".USERNAME;
		}
		else
		{
			$message .= "\n\n".LAN_EMAIL_1." ".$author;
		}
	}
	else
	{
//		$message .= $comments."\n";		// Added into message later
	}
	$ip = $e107->getip();
	$message .= "\n\n".LAN_EMAIL_2." ".$ip."\n\n";

	if (substr($source,0,7) == 'plugin:')
	{
		$plugin = substr($source,7);
		$text = '';
		if(file_exists(e_PLUGIN.$plugin.'/e_emailprint.php'))
		{
			include_once(e_PLUGIN.$plugin.'/e_emailprint.php');
			$text = email_item($parms);
			$emailurl = SITEURL;
		}
		if($text == '')
		{
			header('location:'.e_BASE.'index.php');
			exit;
		}
		$message .= $text;
	}
	elseif($source == 'referer')
	{
		if(!isset($_POST['referer']) || $_POST['referer'] == '')
		{
			header('location:'.e_BASE.'index.php');
			exit;
		}
		$message .= strip_tags($_POST['referer']);
		$emailurl = strip_tags($_POST['referer']);
	}
	else
	{
		$emailurl = strip_tags($_POST['referer']);
        $message = '';
		$parms = intval($parms);
        if($sql->db_Select('news', '*', 'news_id='.$parms))
        {
            list($news_id, $news_title, $news_body, $news_extended, $news_datestamp, $news_author, $news_source, $news_url, $news_category, $news_allow_comments) = $sql->db_Fetch();
			$message = "<h3 class='email_heading'>".$news_title."</h3><br />".$news_body."<br />".$news_extended."<br /><br /><a href='{e_BASE}news.php?extend.".$parms."'>{e_BASE}news.php?extend.".$parms."</a><br />";
            $message = $tp->toEmail($message);

        }

		if($message == '')
		{
			header('location:'.e_BASE.'index.php');
			exit;
		}
	}

	if ($error == '')
	{
	    // Load Mail Handler and Email Template.
		require_once(e_HANDLER.'mail_handler.php');
		if (file_exists(THEME.'email_template.php'))
		{
			require_once(THEME.'email_template.php');
		}
		else
		{
			require_once(e_THEME.'templates/email_template.php');
		}

		$email_body = '';
		if(isset($EMAIL_HEADER))
		{
			$email_body = $tp->parseTemplate($EMAIL_HEADER);
		}

		$email_body .= (trim($comments) != '') ? $tp->toEmail($comments).'<hr />' : '';
		$email_body .= $tp->toEmail($message);
		if (isset($EMAIL_FOOTER))
		{
			$email_body .= $tp->parseTemplate($EMAIL_FOOTER);
		}

		if (sendemail($email_send, LAN_EMAIL_3.SITENAME,$email_body))
		{
			$text = "<div style='text-align:center'>".LAN_EMAIL_10." ".$email_send."</div>";
		}
		else
		{
			$text = "<div style='text-align:center'>".LAN_EMAIL_9."</div>";
		}
		$ns->tablerender(LAN_EMAIL_11, $text);
	}
	else
	{
		$ns->tablerender(LAN_EMAIL_12, "<div style='text-align:center'>".$error."</div>");
	}
}


// --------------------- Form -------------------------------------------------



$text = "<form method='post' action='".e_SELF."?".e_QUERY."'>\n
	<table>";

if (USER != TRUE)
{
	$text .= "<tr>
		<td style='width:25%'>".LAN_EMAIL_15."</td>
		<td style='width:75%'>
		<input class='tbox' type='text' name='author_name' size='60' style='width:95%' value='$author' maxlength='100' />
		</td>
		</tr>";
}

$text .= "
<tr>
	<td style='width:25%'>".LAN_EMAIL_8."</td>
	<td style='width:75%'>
	<textarea class='tbox' name='comment' cols='70' rows='4' style='width:95%'>".LAN_EMAIL_6." ".SITENAME." (".$emailurl.")
";

if (USER == TRUE)
{
	$text .= "\n\n".LAN_EMAIL_1." ".USERNAME;
}

$text .= "</textarea>
	</td>
	</tr>

	<tr>
	<td style='width:25%'>".LAN_EMAIL_187."</td>
	<td style='width:75%'>
	<input class='tbox' type='text' name='email_send' size='60' value='$email_send' style='width:95%' maxlength='100' />
	</td>
	</tr>
	";

if($use_imagecode)
{
	$text .= "<tr><td>".LAN_EMAIL_190."</td><td>";
	$text .= $sec_img->r_image();
	$text .= " <input class='tbox' type='text' name='code_verify' size='15' maxlength='20' />
		<input type='hidden' name='rand_num' value='".$sec_img->random_number."' /></td></tr>";
}

$text .= "
	<tr style='vertical-align:top'>
	<td style='width:25%'></td>
	<td style='width:75%'>
	<input class='button' type='submit' name='emailsubmit' value='".LAN_EMAIL_4."' />
	<input type='hidden' name='referer' value='".$referrer."' />
	<input type='hidden' name='e-token' value='".e_TOKEN."' />
</td>
	</tr>
	</table>
	</form>";

$ns->tablerender(LAN_EMAIL_5, $text);

require_once(FOOTERF);
?>