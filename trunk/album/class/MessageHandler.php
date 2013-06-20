<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/MessageHandler.php
 *
 * Classes responsible for managing album message objects
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_album_MessageHandler extends icms_ipf_Handler {

	private $_aHandler;
	public $_usersArray;

	function __construct(&$db) {
		parent::__construct($db, "message", "message_id", "message_item", "message_body", ALBUM_DIRNAME);

		$this->_aHandler = new mod_album_AlbumHandler(icms::$xoopsDB);
	}

	public function getMessages($iid = FALSE, $approve = TRUE) {
		$criteria = new icms_db_criteria_Compo();
		if($approve) $criteria->add(new icms_db_criteria_Item("message_approve", TRUE));
		if($iid) $criteria->add(new icms_db_criteria_Item("message_item", $iid));
		$perm_handler = new icms_ipf_permission_Handler($this->_aHandler);
		$grantedItems = $perm_handler->getGrantedItems("album_grpperm");
		unset($perm_handler);
		if(count($grantedItems) > 0)
		$criteria->add(new icms_db_criteria_Item("message_album", '(' . implode(', ', $grantedItems) . ')', 'IN'));
		$messages = $this->getObjects($criteria, TRUE, FALSE);
		unset($criteria);
		$ret = array();
		foreach ($messages as $k => $message) {
			$ret[$k] = $message;
		}
		return $ret;
	}

	public function loadUsers() {
		global $icmsConfig, $icmsConfigUser;
		if(!count($this->_usersArray)) {
			$member_handler = icms::handler("icms_member_user");
			$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("level", 0, '>='));
			$sql = "SELECT DISTINCT (message_uid) FROM " . $this->table;
			$critTray = new icms_db_criteria_Compo();
			if ($result = icms::$xoopsDB->query($sql)) {
				while ($myrow = icms::$xoopsDB->fetchArray($result)) {
					$critTray->add(new icms_db_criteria_Item("uid", $myrow['message_uid']), "OR");
				}
			}
			$criteria->add($critTray);
			$users = $member_handler->getObjects($criteria, TRUE);
			unset($criteria);
			foreach (array_keys($users) as $key) {
				$arr = array();
				$arr['uid'] = $key;
				$arr['link'] = '<a rel="userlink" class="user_link" href="'.ICMS_URL.'/userinfo.php?uid='.$key.'">'.$users[$key]->getVar("uname").'</a>';
				if ($users[$key]->getVar('user_avatar') && $users[$key]->getVar('user_avatar') != 'blank.gif' && $users[$key]->getVar('user_avatar') != ''){
					$arr['avatar'] = ICMS_UPLOAD_URL.'/'.$users[$key]->getVar('user_avatar');
				} elseif ($icmsConfigUser['avatar_allow_gravatar'] == 1) {
					$arr['avatar'] = $users[$key]->gravatar('G', $icmsConfigUser['avatar_width']);
				}
				$arr['attachsig'] = $users[$key]->getVar("attachsig");
				$arr['user_sig'] = icms_core_DataFilter::checkVar($users[$key]->getVar("user_sig", "n"), "html", "output");
				$arr['uname'] = $users[$key]->getVar("uname");
				$arr['icq'] = $users[$key]->getVar("user_icq");
				$arr['msn'] = $users[$key]->getVar("user_msnm");
				$arr['yim'] = $users[$key]->getVar("user_yim");
				$arr['regdate'] = date("d/m/Y", $users[$key]->getVar("user_regdate", "e"));
				$this->_usersArray[$key] = $arr;
				unset($arr, $users[$key]);
			}
			unset($users, $member_handler);
		}
		return $this->_usersArray;
	}

	// approve/deny message
	public function changeApprove($message_id) {
		$approve = '';
		$messageObj = $this->get($message_id);
		if ($messageObj->getVar('message_approve', 'e') == TRUE) {
			$messageObj->setVar('message_approve', 0);
			$approve = 0;
		} else {
			$messageObj->setVar('message_approve', 1);
			$approve = 1;
		}
		$this->insert($messageObj, TRUE);
		return $approve;
	}

	public function message_approve_filter() {
		return array(0 => 'Denied', 1 => 'Approved');
	}

	public function getImageFilter() {
		$album_images_handler = icms_getModuleHandler("images", ALBUM_DIRNAME, "album");
		$images = $album_images_handler->getList();
		return $images;
	}

	// some related functions for storing
	protected function beforeInsert(&$obj) {
		$body = $obj->getVar("message_body", "e");
		$message = urldecode($body);
		$message = strip_tags($message,'<br><a><b><i>');
		$body = icms_core_DataFilter::checkVar($message, "html", "input");
		$obj->setVar("message_body", $body);
		return TRUE;
	}
}
