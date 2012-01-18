<?php
/**
 * ccenter is a form module
 * 
 * File: index.php
 * 
 * index-page of ccenter module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * --------------------------------------------------------------------------------------------------------
 * 				ccenter
 * @since		0.94
 * @author		Nobuhiro Yasutomi
 * @package		ccenter
 * --------------------------------------------------------------------------------------------------------
 * 				ccenter
 * @since		1.00
 * @author		QM-B
 * @package		ccenter
 * @version		$Id$
 * 
 */


include "header.php";

$errors = array();
$op = "form";

$id= isset($_GET['form']) ? (int) $_GET['form'] : 0;

$cond = "active";
if (is_object(icms::$user)) {
    $conds = array();
    foreach (icms::$user->getGroups() as $gid) {
		$conds[] = "grpperm LIKE '%|$gid|%'";
    }
    if ($conds) $cond .= " AND (".join(' OR ', $conds).")";
} else {
    $cond .= " AND grpperm LIKE '%|".ICMS_GROUP_ANONYMOUS."|%'";
}
if ($id) $cond .= " AND formid=$id";
$res = icms::$xoopsDB->query("SELECT * FROM ".FORMS." WHERE $cond ORDER BY weight,formid");

if (!$res) {
    redirect_header('index.php', 3, _NOPERM);
    exit;
}

$breadcrumbs = new CcenterBreadcrumbs();


if (icms::$xoopsDB->getRowsNum($res)!=1) {
    include ICMS_ROOT_PATH."/header.php";
    $xoopsOption['template_main'] = "ccenter_form.html";
    $forms = array();
    while ($form=icms::$xoopsDB->fetchArray($res)) {
	if ($form['priuid']<0) continue; // need uid setting
	$forms[] = $form;
    }
    $icmsTpl->assign('forms', $forms);
    $breadcrumbs->assign();
    include ICMS_ROOT_PATH."/footer.php";
    exit;
}

if (isset($_POST['op']) && !isset($_POST['edit'])) $op = $_POST['op'];
$form = icms::$xoopsDB->fetchArray($res);
get_attr_value($form['optvars']); // set default values
$items = get_form_attribute($form['defs']);
if ($form['priuid']< 0) {	// assign group member
    $priuid = isset($_GET['uid'])?intval($_GET['uid']):0;
    if ($priuid) {
	$member_handler =& icms::handler('icms_member');
	$priuser = $member_handler->getUser($priuid);
	if (!is_object($priuser) || !in_array(-$form['priuid'], $priuser->groups())) $priuid=0;
    }
    if (empty($priuid)) {
	$back = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:ICMS_URL;
	redirect_header($back, 3, _NOPERM);
	exit;
    } else {
	$form['priuser'] = array('uid'=>$priuser->getVar('uid'),
				 'uname'=>$priuser->getVar('uname'),
				 'name'=>$priuser->getVar('name'));
    }
}

$errors = array();
if ($op!="form") {
    $errors = assign_post_values($items);
    if (count($errors)) {
	$op = 'form';
	assign_form_widgets($items);
    } elseif ($op == 'store') {
	$errors = store_message($items, $form);
    } elseif ($op == 'confirm') {
	assign_form_widgets($items, true);
    }
} else {
    assign_form_widgets($items);
}

$cust = $form['custom'];
$form['items'] =& $items;
$action = "form.php?form=".$form['formid'];
if (!empty($form['priuser'])) $action .= '&amp;uid='.$form['priuser']['uid'];
$form['action'] = $action;


$title = htmlspecialchars($form['title']);
$breadcrumbs->set($title, "form.php?form=$id");

$xoopsOption['template_main'] = "ccenter_custom.html";
include ICMS_ROOT_PATH."/header.php";

$icmsTpl->assign('errors', $errors);
$icmsTpl->assign('icms_pagetitle', $title);
$breadcrumbs->assign();
$res = render_form($form, $op);
if ($cust!=_CC_TPL_FULL) include ICMS_ROOT_PATH."/footer.php";
else echo $icmsTpl->fetch('db:'.$xoopsOption['template_main']);

	function store_message($items, $form) {
    
		$uid = is_object(icms::$user)?icms::$user->getVar('uid'):0;
		$store = $form['store'];
		if ($store==_DB_STORE_NONE) {
			$showaddr = true;	// no store to need show address
		} else {
			$showaddr = get_attr_value(null, 'notify_with_email');
		}
		$from = $email = "";
		$attach = array();
		$vals = array();
		$rtext = '';
		foreach ($items as $item) {
			if (empty($item['name'])) continue;
			$name = $item['name'];
			$val = $item['value'];
			$vals[$name] = $val;
			$opts = &$item['options'];
			switch ($item['type']) {
				case 'mail':
					if (empty($email)) { // save first email for contact
						$email = $vals[$name];
						$mail_name = $name;
						if ($showaddr) {
							$from = $email;
							break;
						}
						continue 2;		/* PHP switch catch continue! */
					}
					break;
				case 'file':
					$val = $vals[$name];
					if ($val) {
						$vals[$name] = "file=".$val;
						$attach[] = $val;
					}
					break;
				case 'radio':
				case 'select':
					if (isset($opts[$val])) $val = strip_tags($opts[$val]);
					break;
				case 'checkbox':
					foreach ($val as $k=>$v) {
						$val[$k] = isset($opts[$v])?strip_tags($opts[$v]):$v;
					}
					$val = join(', ', $val);
					break;
			}
			if (!empty($val) && preg_match('/\n/', $val)) $val = "\n\t".preg_replace('/\n/', "\n\t", $val);
			$rtext .= strip_tags($item['label']).": $val\n";
		}
		// remove if not show/store email address in database
		if (!$showaddr && isset($mail_name)) unset($vals[$mail_name]);
		$text = serialize_text($vals);		    // store value
		$onepass = ($uid==0)?cc_onetime_ticket($email):"";
		if ($form['priuid'] < 0) {
			$touid = empty($form['priuser'])?0:$form['priuser']['uid'];
		} else {
			$touid = $form['priuid'];
		}
		$now = time();
		$values = array(
			'uid'=>$uid, 'touid'=>$touid,
			'ctime'=>$now, 'mtime'=>$now, 'atime'=>$now,
			'fidref'=>$form['formid'],
			'email'=>icms::$xoopsDB->quoteString($email),
			'onepass'=>icms::$xoopsDB->quoteString($onepass));
			$parg = $onepass?"&p=".urlencode($onepass):"";
			if ($store==_DB_STORE_YES) {
				$values['body']=icms::$xoopsDB->quoteString($text);
			}

			if ($store!=_DB_STORE_NONE) {
				$res = icms::$xoopsDB->query("INSERT INTO ".CCMES. "(".join(',',array_keys($values)).") VALUES (".join(',', $values).")");
				if ($res===false) return array("Error in DATABASE insert");
				$id = icms::$xoopsDB->getInsertID();
				if (empty($id)) return array("Internal Error in Store Message");
			} else {
				$id = 0;
			}
		$member_handler =& icms::handler('icms_member');
		if ($touid) {
			$toUser = $member_handler->getUser($touid);
			$toUname = $toUser->getVar('uname');
		} else {
			$toUser = false;
			$toUname = _MD_CONTACT_NOTYET;
		}
		$atext = "";		// reply sender
		$btext = "";		// to contact and monitors
		if (count($attach)) {
			$atext = $btext = "\n"._MD_ATTACHMENT."\n";
			foreach ($attach as $i=>$file) {
				move_attach_file('', $file, $id);
				$a = cc_attach_image($id, $file, true);
				$atext .= "$a$parg\n";
				$btext .= "$a\n";
			}
			rmdir(ICMS_UPLOAD_PATH.cc_attach_path(0, ''));
		}
		$dirname = icms::$module -> getVar( 'dirname' );
		$uname = icms::$user?icms::$user->getVar('uname'):$GLOBALS['xoopsConfig']['anonymous'];
		$tags = array('SUBJECT'=>$form['title'],
		  'TO_USER'=>$toUname,
		  'FROM_USER'=>$uname,
		  'FROM_EMAIL'=>$email,
		  'REMOTE_ADDR'=>$_SERVER["REMOTE_ADDR"],
		  'HTTP_USER_AGENT'=>$_SERVER["HTTP_USER_AGENT"],
		  'MSGID'=>$id);
		foreach ($vals as $k=>$v) {
			$tags[$k] = $v;
		}
		$tpl = get_attr_value(null, 'from_confirm_tpl', 'form_confirm.tpl');
		$msgurl = ICMS_URL.($id?"/modules/$dirname/message.php?id=$id":'/');
		if ($email) {		// reply automaticaly
			$tags['VALUES'] = "$rtext$atext";
			$tags['MSG_URL'] = ($store==_DB_STORE_NONE)?'':"\n"._MD_NOTIFY_URL."\n$msgurl$parg";
			cc_notify_mail($tpl, $tags, $email, $toUser?$toUser->getVar('email'):'');
		}
		$tags['VALUES'] = "$rtext$btext";
		$tags['MSG_URL'] = ($store==_DB_STORE_NONE)?'':"\n"._MD_NOTIFY_URL."\n".$msgurl;

		$notification_handler = icms::handler( 'icms_data_notification' );
		$notification_handler->triggerEvent('global', 0, 'new', $tags);
		$notification_handler->triggerEvent('form', $form['formid'], 'new', $tags);
		// force subscribe sender and recipient
		if ($id) $notification_handler->subscribe('message', $id, 'comment');
		if ($touid) {
			if ($id) $notification_handler->subscribe('message', $id, 'comment', null, null, $touid);
			cc_notify_mail(get_attr_value(null, 'charge_notify_tpl', $tpl), $tags, $toUser, $from);
		} elseif ($form['cgroup']) { // contact group notify
			$users = $member_handler->getUsersByGroup($form['cgroup'], true);
			cc_notify_mail(get_attr_value(null, 'group_notify_tpl', $tpl), $tags, $users, $from);
		}

		if ($id) $msgurl .= $parg;
		$redirect = get_attr_value(null, 'redirect');
		if (!empty($redirect)) {
			$msgurl = preg_match('/^\\//', $redirect)?ICMS_URL.$redirect:$redirect;
		}
		redirect_header($msgurl, 3, _MD_CONTACT_DONE);
		exit;
	}