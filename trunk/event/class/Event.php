<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /class/Event.php
 * 
 * Class representing event event objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_event_Event extends icms_ipf_seo_Object {
	
	public $_updating = FALSE;
	/**
	 * Constructor
	 *
	 * @param mod_event_Event $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("event_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("event_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("event_cid", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("event_dsc", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("event_contact", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("event_cemail", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("event_url", XOBJ_DTYPE_URLLINK, FALSE);
		$this->quickInitVar("event_phone", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("event_street", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("event_zip", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("event_city", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("event_allday", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("event_startdate", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("event_enddate", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("event_public", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar("event_tags", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("event_joiner", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, '0');
		$this->quickInitVar("event_submitter", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("event_created_on", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("event_approve", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
        $this->quickInitVar("event_notif_sent", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->initCommonVar("counter", FALSE, 0);
		$this->initCommonVar("dohtml", FALSE, TRUE);
		$this->initCommonVar("dobr", FALSE, FALSE);
		$this->initCommonVar("doimage", FALSE, TRUE);
		$this->initCommonVar("dosmiley", FALSE, TRUE);
		$this->initCommonVar("docxode", FALSE, TRUE);
		
		$this->setControl("event_cid", array("name" => "select", "itemHandler" => "event", "method" => "getCategoryList", "module" => "event"));
		$this->setControl("event_public", "yesno");
		$this->setControl("event_allday", "yesno");
		$this->setControl("event_submitter", "user");
		$this->setControl("event_approve", "yesno");
		
		if(!icms_get_module_status("index")) {
			$this->hideFieldFromForm("event_tags");
			$this->hideFieldFromSingleView("event_tags");
		}
		
		$this->initiateSEO();
		
		$this->hideFieldFromForm(array("event_joiner", "short_url", "meta_description", "meta_keywords", "event_submitter", "event_created_on", "event_approve", "event_notif_sent"));
	}

	public function event_approve() {
		$active = $this->getVar('event_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . EVENT_ADMIN_URL . 'event.php?event_id=' . $this->id() . '&amp;op=changeApprove">
				<img src="' . EVENT_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . EVENT_ADMIN_URL . 'event.php?event_id=' . $this->id() . '&amp;op=changeApprove">
				<img src="' . EVENT_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}

    public function getCategory() {
        $cid = $this->getVar("event_cid", "e");
        $category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
        $cat = $category_handler->get($cid);
        $title = $cat->title();
        unset($category_handler, $cat);
        return $title;
    }
    
	public function accessGranted() {
		if ($this->userCanEditAndDelete()) return TRUE;
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(EVENT_DIRNAME);
		$viewperm = $gperm_handler->checkRight('cat_view', $this->getVar('event_cid', 'e'), $groups, $module->getVar("mid"));
		if ($viewperm && $this->isApproved()) return TRUE;
		return FALSE;
	}
	
    function userCanEditAndDelete() {
		global $event_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($event_isAdmin) return TRUE;
		return $this->getVar("event_submitter", "e") == icms::$user->getVar("uid", "e");
	}
	
	public function getContact() {
		$ret = FALSE;
		$con = $this->getVar("event_contact", "e");
		$email = $this->getVar("event_cemail", "e");
		if($con == "" || $con == "0") return FALSE;
		$member_handler = icms::handler('icms_member_user');
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("uname", trim(strtolower($con))));
		$sql = "SELECT uid FROM " . icms::$xoopsDB->prefix('users') . " " . $criteria->renderWhere();
		$result = icms::$xoopsDB->query($sql);
		list($uid) = icms::$xoopsDB->fetchRow($result);
		if(!$uid) {
			$contact = ucwords($con);
			$ret = '<span class="event_contact">';
			if(!$email == "" || !$email = "0" && is_object(icms::$user)) {
				$avatar =  "http://www.gravatar.com/avatar/" . md5(strtolower($email)) . "?d=identicon";
				$email = icms_core_DataFilter::checkVar($email, "email", 1, 0);
				$ret .= '<img class="icon_middle" width="22px" height="22px" src="' . $avatar . '" />';
			}
			$ret .=  $contact . '</span>';
			if((!$email == "" || !$email = "0") && is_object(icms::$user)) $ret .= '<span class="event_contact_email">' . $email . '</span>';
		} else {
			$member = $member_handler->get($uid);
			$contact = '<a class="event_uinfo" href="' . ICMS_URL . '/userinfo.php?uid=' . $member->getVar("uid") . '" title="' . $con . '">' . ucfirst($con) . '</a>';
			$avatar = $member->gravatar();
			$ret = '<span class="event_contact"><img class="icon_middle" width="22px" height="22px" src="' . $avatar . '" />' . $contact . '</span>';
			if((!$email == "" || !$email = "0") && is_object(icms::$user)) {
				$email = icms_core_DataFilter::checkVar($email, "email", 1, 0);
				$ret .= '<span class="event_contact_email">' . $email . '</span>';
			}
			unset($member, $contact, $avatar, $uid);
		}
		unset($criteria, $member_handler, $members);
		return $ret;
	}

	public function getValue($value) {
		return (!$this->getVar("$value", "e") == "0") ? $this->getVar("$value", "e") : ""; 
	}
	
	public function getEventUrl($urllink = TRUE) {
		$urlObj = $this->getUrlLinkObj("event_url");
		if($urllink)return $urlObj->render();
		$urllink['url'] = $urlObj->getVar("url", "e");
		$urllink['dsc'] = $urlObj->getVar("description", "e");
		$urllink['cap'] = $urlObj->getVar("caption", "e");
		$urllink['tar'] = $urlObj->getVar("target", "e");
		$urllink['mid'] = $urlObj->getVar("mid");
		return $urllink;
	}
	
	public function isApproved() {
		return ($this->getVar("event_approve", "e") == 1) ? TRUE : FALSE;
	}
	
	public function notifSent() {
		return ($this->getVar("event_notif_sent", "e") == 1) ? TRUE : FALSE;
	}
	
	public function getItemLink($urlOnly = FALSE) {
		$start = $this->getVar("event_startdate", "e");
		$date = $this->formatDate($start, "Y-m-d");
		$time = $this->formatDate($start, "G");
		$url = ICMS_MODULES_URL . "/" . EVENT_DIRNAME . '/index.php?date=' . $date . "&time=" . $time;
		if($urlOnly) return $url;
		return '<a href="' . $url . '" title="' . $this->title() . '">' . $this->title() . '</a>';
	}
	
	public function getEventDsc() {
		$dsc = $this->getVar("event_dsc", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "output");
		$filtered = strpos('<!-- input filtered -->');
		$dsc = str_replace('<!-- input filtered -->', '', $dsc);
		$dsc = str_replace('<!-- warning! output filtered only -->', '', $dsc);
		return $dsc;
	}

	public function toArray() {
		$ret = parent::toArray();
        $ret['id'] = $this->id();
        $ret['name'] = $this->title();
        $ret['dsc'] = $this->getEventDsc();
        $ret['start'] = $this->getVar("event_startdate", "e");
		$ret['end'] = $this->getVar("event_enddate", "e");
		$ret['allDay'] = ($this->getVar("event_allday", "e") == 1) ? TRUE : FALSE;
        $ret['canEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
        $ret['contact'] = $this->getContact();
		$ret['street'] = $this->getValue("event_street");
		$ret['city'] = $this->getValue("event_city");
		$ret['zip'] = $this->getValue("event_zip");
		$ret['phone'] = $this->getValue("event_phone");
		$ret['cat'] = $this->getCategory();
		$ret['urllink'] = $this->getEventUrl(TRUE);
		$ret['urlpart'] = $this->getEventUrl(FALSE);
		$ret['is_approved'] = (!$this->isApproved()) ? "<span class='awaiting_approval'>" . _CO_EVENT_AWAITING_APPROVAL . "</span>" : "" ;
        return $ret;
	}
	
	function sendNotification($case) {
		$valid_case = array("event_submitted", "event_modified");
		if(in_array($case, $valid_case, TRUE)) {
			$module = icms::handler('icms_module')->getByDirname(EVENT_DIRNAME);
			$mid = $module->getVar('mid');
			$tags ['EVENT_TITLE'] = $this->title();
			$tags ['EVENT_URL'] = $this->getItemLink(FALSE);
			$tags ['EVENT_CAT'] = $this->getCategory(TRUE);
			switch ($case) {
				case 'event_submitted':
					$category = 'global';
					$file_id = 0;
					$recipient = array();
					break;
				
				case 'event_modified':
					$category = 'global';
					$file_id = 0;
					$recipient = array();
					break;
			}
			icms::handler('icms_data_notification')->triggerEvent($category, $file_id, $case, $tags, $recipient, $mid);
		}
	}
	
	public function formatDate($timestamp, $format) {
		return date("$format", $timestamp);
	}
	
	public function getSubmitter() {
		$user = $this->getVar("event_submitter", "e");
		return icms_member_user_Handler::getUserLink($user);
	}
	
	public function sendMessageApproved() {
		$pm_handler = icms::handler('icms_data_privmessage');
		$file = "event_approved.tpl";
		$lang = "language/" . $icmsConfig['language'] . "/mail_template";
		$tpl = EVENT_ROOT_PATH . "$lang/$file";
		if (!file_exists($tpl)) {
			$lang = 'language/english/mail_template';
			$tpl = EVENT_ROOT_PATH . "$lang/$file";
		}
		$user = $this->getVar("event_submitter", "e");
		$message = file_get_contents($tpl);
		$message = str_replace("{EVENT_CAT}", $this->getCategory(TRUE), $message);
		$message = str_replace("{EVENT_TITLE}", $this->title(), $message);
		$uname = icms::handler('icms_member_user')->get($user)->getVar("uname");
		$message = str_replace("{X_UNAME}", $uname, $message);
		$pmObj = $pm_handler->create(TRUE);
		$pmObj->setVar("subject", _CO_EVENT_HAS_APPROVED);
		$pmObj->setVar("from_userid", 1);
		$pmObj->setVar("to_userid", (int)$user);
		$pmObj->setVar("msg_time", time());
		$pmObj->setVar("msg_text", $message);
		$pm_handler->insert($pmObj, TRUE);
	}
}