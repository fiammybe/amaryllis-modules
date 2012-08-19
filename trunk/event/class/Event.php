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
		$this->quickInitVar("event_cemail", XOBJ_DTYPE_EMAIL, FALSE);
		$this->quickInitVar("event_url", XOBJ_DTYPE_URLLINK, FALSE);
		$this->quickInitVar("event_phone", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("event_street", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("event_zip", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("event_city", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("event_allday", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("event_startdate", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("event_enddate", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("event_public", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("event_isrecur", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		
		$this->quickInitVar("event_recur_rules", XOBJ_DTYPE_TXTBOX, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("event_recur_freq", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar("event_recur_days", XOBJ_DTYPE_SIMPLE_ARRAY, FALSE, FALSE, FALSE);
		$this->quickInitVar("event_recur_start", XOBJ_DTYPE_STIME, FALSE);
		$this->quickInitVar("event_recur_end", XOBJ_DTYPE_SIMPLE_ARRAY, FALSE);
		
		$this->quickInitVar("event_disable_recur", XOBJ_DTYPE_SIMPLE_ARRAY, FALSE, FALSE, FALSE);
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
		$this->setControl("event_isrecur", array("name" => "yesno", "onSelect" => "submit"));
		$this->setControl("event_recur_rules", array("name" => "select", "itemHandler" => "event", "method" => "getRecurs", "module" => "event"));
		$this->setControl("event_recur_freq", array("name" => "select", "itemHandler" => "event", "method" => "getRecurFreq", "module" => "event"));
		$this->setControl("event_recur_days", array("name" => "select", "itemHandler" => "event", "method" => "getRecurDays", "module" => "event"));
		
		$this->setControl("event_submitter", "user");
		$this->setControl("event_approve", "yesno");
		
		$this->initiateSEO();
		
		$this->hideFieldFromForm(array("short_url", "meta_description", "meta_keywords", "event_submitter", "event_created_on", "event_approve", "event_comments", "event_notif_sent",
										"event_isrecur", "event_recur_rules", "event_disable_recur", "event_recur_freq", "event_recur_days", "event_recur_start", "event_recur_end"));
	}

    public function getCategory($cattitle = TRUE) {
        $cid = $this->getVar("event_cid", "e");
        $category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
        $cat = $category_handler->get($cid);
        $title = $cat->title();
        $color = $cat->getColor();
        unset($category_handler, $cat);
        return ($cattitle) ? $title : $color;
    }
    
    function userCanEditAndDelete() {
		global $event_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($event_isAdmin) return TRUE;
		return $this->getVar("event_submitter", "e") == icms::$user->getVar("uid", "e");
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
        $ret['cid'] = $this->getCategory(TRUE);
        $ret['color'] = $this->getCategory(FALSE);
        $ret['start'] = $this->getVar("event_startdate", "e");
		$ret['end'] = $this->getVar("event_enddate", "e");
		$ret['allDay'] = ($this->getVar("event_allday", "e") == 1) ? "true" : "false";
        $ret['canEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
        if(defined("EVENT_FOR_SINGLEVIEW")) {
            
        }
        return $ret;
	}
}