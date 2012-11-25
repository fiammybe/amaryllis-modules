<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /class/Comment.php
 * 
 * Class representing event comment objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.2.0
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_event_Comment extends icms_ipf_Object {
	
	public $_updating = FALSE;
	
	/**
	 * Constructor
	 *
	 * @param mod_event_Comment $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);
		$this->quickInitVar("comment_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("comment_uid", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("comment_eid", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("comment_eid_uid", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("comment_ip", XOBJ_DTYPE_OTHER, TRUE);
		$this->quickInitVar("comment_fprint", XOBJ_DTYPE_OTHER, TRUE);
		$this->quickInitVar("comment_pdate", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("comment_body", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("comment_approve", XOBJ_DTYPE_INT, TRUE);
		$this->initCommonVar("dohtml", FALSE, TRUE);
		$this->initCommonVar("dobr", FALSE, TRUE);
		$this->initCommonVar("doimage", FALSE, TRUE);
		$this->initCommonVar("dosmiley", FALSE, TRUE);
		$this->initCommonVar("docxode", FALSE, TRUE);
		
		$this->setControl("comment_approve", "yesno");
	}
	
	/**
	 * Overriding the icms_ipf_Object::getVar method to assign a custom method on some
	 * specific fields to handle the value before returning it
	 *
	 * @param str $key key of the field
	 * @param str $format format that is requested
	 * @return mixed value of the field that is requested
	 */
	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array("comment_pdate"))) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
	
	public function comment_pdate()	{
		global $eventConfig;
		return date($eventConfig['date_format'], $this->getVar("comment_pdate", "e"));
	}
	
	public function comment_approve() {
		$active = $this->getVar('comment_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . EVENT_ADMIN_URL . 'comment.php?comment_id=' . $this->id() . '&amp;op=changeApprove">
				<img src="' . EVENT_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . EVENT_ADMIN_URL . 'comment.php?comment_id=' . $this->id() . '&amp;op=changeApprove">
				<img src="' . EVENT_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	function getPublisher() {
		global $icmsConfig;
		$uid = $this->getVar('comment_uid', 'e');
		$users = $this->handler->loadUsers();
		$user = (array_key_exists($uid, $users) && $uid > 0 ) ? $users[$uid] : FALSE;
		if($user) return $user;
		$userinfo = array();
		$userinfo['uid'] = 0;
		$userinfo['link'] = $icmsConfig['anonymous'];
		$userinfo['avatar'] = ICMS_UPLOAD_URL."/blank.gif";
		$userinfo['user_sig'] = "";
		$userinfo['uname'] = $icmsConfig['anonymous'];
		return $userinfo;
	}
	
	public function isApproved() {
		return ($this->getVar("comment_approve", "") == 1) ? TRUE : FALSE;
	}
	
	public function getApproved() {
		return ($this->getVar("comment_approve", "") == 1) ? "" : "comment_approve";
	}
	
	public function getLink() {
		$eid = $this->getVar("comment_eid", "e");
		$events = $this->handler->loadEventLinks();
		if(array_key_exists($eid, $events)) return $events[$eid].'#event_comment_'.$this->id();
		return FALSE;
	}
	
	public function renderComment($block = false) {
		global $eventConfig;
		icms_loadLanguageFile("core", "user");
		$uinfo = $this->getPublisher();
		$path = EVENT_ROOT_PATH.'templates/event_singlecomment.html';
		$content = file_get_contents($path);
		$content = str_replace("{COMMENT_BODY}", $this->summary(), $content);
		if($block && $this->getLink()) {
			$content = str_replace("{COMMENT_PDATE}", '<a href="'.$this->getLink().'" title="Goto..">'.$this->comment_pdate().'</a>', $content);
		} else {
			$content = str_replace("{COMMENT_PDATE}", $this->comment_pdate(), $content);
		}
		$content = str_replace("{COMMENT_ID}", (!$block) ? $this->id() : "block_".$this->id(), $content);
		$content = str_replace("{COMMENT_UNAME}", $uinfo['uname'], $content);
		$content = str_replace("{COMMENT_AVATAR}", $uinfo['avatar'], $content);
		//$content = str_replace("{COMMENT_AVATAR_DIM}", $eventConfig['avatar_dimensions'], $content);
		$content = str_replace("{COMMENT_ULINK}", $uinfo['link'], $content);
		$content = str_replace("{COMMENT_USIG}", $uinfo['user_sig'], $content);
		$content = str_replace("{COMMENT_UID}", $uinfo['uid'], $content);
		$content = str_replace("{COMMENT_UONLINE}", $uinfo['online'], $content);
		$content = str_replace("{COMMENT_UICQ}", (is_object(icms::$user) && $uinfo['icq'] !== "") ? _US_ICQ.': '.$uinfo['icq'] : "", $content);
		$content = str_replace("{COMMENT_UMSN}", (is_object(icms::$user) && $uinfo['msn'] !== "") ? _US_MSNM.': '.$uinfo['msn'] : "", $content);
		$content = str_replace("{COMMENT_UYIM}", (is_object(icms::$user) && $uinfo['yim'] !== "") ? _US_YIM.': '.$uinfo['yim'] : "", $content);
		$content = str_replace("{COMMENT_APPROVAL}", $this->isApproved() ? "" : _CO_EVENT_SUCCESSFUL_COMMENTED_APPROVAL, $content);
		$content = str_replace("{COMMENT_APPROVE}", $this->getApproved(), $content);
		$content = str_replace("{COMMENT_APPROVAL_LINK}", (!$this->isApproved() && !$block) ? '<img class="comment_approval_link icon_middle" original-id="'.$this->id().'" src="'.EVENT_IMAGES_URL.'approved.png" />' : "", $content);
		$content = str_replace("{COMMENT_REGDATE}", _US_MEMBERSINCE .": ".$uinfo['regdate'], $content);
		return $content;
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->id();
		$ret['user'] = $this->getPublisher();
		$ret['body'] = $this->summary();
		$ret['comment'] = $this->renderComment();
		$ret['comment_block'] = $this->renderComment(TRUE);
		return $ret;
	}

}