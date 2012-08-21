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
		$this->quickInitVar("event_joiner", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 'X');
		$this->quickInitVar("event_submitter", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("event_created_on", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("event_approve", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
        $this->quickInitVar("event_comments", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
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
		
		$this->hideFieldFromForm(array("event_joiner", "short_url", "meta_description", "meta_keywords", "event_submitter", "event_created_on", "event_approve", "event_comments", "event_notif_sent"));
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

    public function getCategory($cattitle = TRUE) {
        $cid = $this->getVar("event_cid", "e");
        $category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
        $cat = $category_handler->get($cid);
        $title = $cat->title();
        $ret['title'] = $title;
        $ret['color'] = $cat->getColor();
		$ret['txtcolor'] = $cat->getTextColor();
		$ret['url'] = $cat->getItemLink(FALSE);
        unset($category_handler, $cat);
        return ($cattitle) ? $title : $ret;
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
		$contact = $this->getVar("event_contact", "e");
		$email = $this->getVar("event_cemail", "e");
		if($contact == "" || $contact == "0") return FALSE;
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("uname", trim($contact)));
		$member_handler = icms::handler('icms_member_user');
		$users = $member_handler->getObjects($criteria, TRUE);
		if($users) {
			$user = $member_handler->get($users);
			$ret['contact'] = '<a href="' . ICMS_URL . '/userinfo.php?uid=' . $user->getVar("uid") . '" title="' . $contact . '">' . ucfirst($contact) . '</a>';
			$ret['avatar'] = $user->gravatar();
			if(!$email == "" || !$email = "0") {
				$ret['email'] = icms_core_DataFilter::checkVar($email, "email", 1, 0);
			}
		} else {
			$ret['contact'] = ucfirst($contact);
			if(!$email == "" || !$email = "0") {
				$ret['avatar'] =  "http://www.gravatar.com/avatar/" . md5(strtolower($email)) . "?d=identicon";
				$ret['email'] = icms_core_DataFilter::checkVar($email, "email", 1, 0);
			} 
		}
		return $ret;
	}
	
	public function isApproved() {
		return ($this->getVar("event_approve", "e") == 1) ? TRUE : FALSE;
	}
	
	public function notifSent() {
		return ($this->getVar("event_notif_sent", "e") == 1) ? TRUE : FALSE;
	}
	
	public function getItemLink($urlOnly = FALSE) {
		$url = EVENT_URL . 'event.php?event=' . $this->short_url();
		if($urlOnly) return $url;
		return '<a href="' . $url . '" title="' . $this->title() . '">' . $this->title() . '</a>';
	}

	public function toArray() {
		$ret = parent::toArray();
        $ret['id'] = $this->id();
        $ret['name'] = $this->title();
        $ret['dsc'] = $this->summary();
        $ret['start'] = $this->getVar("event_startdate", "e");
		$ret['end'] = $this->getVar("event_enddate", "e");
		$ret['allDay'] = ($this->getVar("event_allday", "e") == 1) ? "true" : "false";
        $ret['canEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
        if(defined("EVENT_FOR_SINGLEVIEW")) {
            $ret['contact'] = $this->getContact();
			$ret['cat'] = $this->getCategory(FALSE);
			
        }
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