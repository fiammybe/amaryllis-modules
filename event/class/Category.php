<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /class/Category.php
 * 
 * Class representing event category objects
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

class mod_event_Category extends icms_ipf_seo_Object {
	/**
	 * Constructor
	 *
	 * @param mod_event_Category $handler Object handler
	 */
	public function __construct(&$handler) {
		icms_ipf_object::__construct($handler);

		$this->quickInitVar("category_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("category_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("category_dsc", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("category_color", XOBJ_DTYPE_OTHER, TRUE);
		$this->quickInitVar("category_txtcolor", XOBJ_DTYPE_OTHER, TRUE, FALSE, FALSE, "#000000");
        $this->quickInitVar("category_approve", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
        $this->quickInitVar("category_submitter", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
        $this->quickInitVar("category_created_on", XOBJ_DTYPE_LTIME, TRUE);
        $this->quickInitVar("category_pubcal", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
        $this->initCommonVar("dohtml", FALSE, TRUE);
		$this->initCommonVar("dobr", FALSE, TRUE);
        
        $this->setControl('category_dsc', array("name" => "textarea"));
        $this->setControl("category_color", "color");
		$this->setControl("category_txtcolor", "color");
		$this->setControl("category_approve", "yesno");
        $this->setControl("category_pubcal", "yesno");
        
		$this->initiateSEO();
        
        $this->hideFieldFromForm(array("short_url", "meta_description", "meta_keywords", "category_approve", "category_submitter", "category_created_on", "category_pubcal"));
        $this->hideFieldFromSingleView(array("category_approve", "category_submitter", "category_created_on", "category_pubcal"));
	}

	public function category_approve() {
		$active = $this->getVar('category_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . EVENT_ADMIN_URL . 'category.php?category_id=' . $this->id() . '&amp;op=changeApprove">
				<img src="' . EVENT_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . EVENT_ADMIN_URL . 'category.php?category_id=' . $this->id() . '&amp;op=changeApprove">
				<img src="' . EVENT_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	function category_color() {
		return "<div style='background-color:" . $this->getColor() . "; border: 1px solid black; width:30px; height:20px;'>&nbsp;</div>";
	}
	
	function category_txtcolor() {
		return "<div style='background-color:" . $this->getTextColor() . "; border: 1px solid black; width:30px; height:20px;'>&nbsp;</div>";
	}
    
    public function getCatDsc() {
		$dsc = $this->getVar("category_dsc", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "output");
		$filtered = strpos($dsc, '<!-- input filtered -->');
		if($filtered) {
			$dsc = str_replace('<!-- input filtered -->', '', $dsc);
			$dsc = str_replace('<!-- warning! output filtered only -->', '', $dsc);
		}
		return $dsc;
	}

	public function getColor() {
        return $this->getVar("category_color");
    }
	
	public function getTextColor() {
        return $this->getVar("category_txtcolor");
    }
	
    function submitAccessGranted() {
		global $event_isAdmin;
		if($event_isAdmin) return TRUE;
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(EVENT_DIRNAME);
		$viewperm = $gperm_handler->checkRight('cat_submit', $this->id(), $groups, $module->getVar("mid", "e"));
		if($viewperm && $this->isApproved()) return TRUE;
		return FALSE;
	}

	function accessGranted($userid = FALSE) {
		if ($this->userCanEditAndDelete()) return TRUE;
		$gperm_handler = icms::handler('icms_member_groupperm');
		if($userid) {
			$member_handler = icms::handler('icms_member_user');
			$groups = ($userid > 0) ? $member_handler->get($userid)->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		} else {
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		}
		$module = icms::handler('icms_module')->getByDirname(EVENT_DIRNAME);
		$viewperm = $gperm_handler->checkRight('cat_view', $this->id(), $groups, $module->getVar("mid", "e"));
		if ($viewperm && $this->isApproved()) return TRUE;
		return FALSE;
	}

	public function userCanEditAndDelete() {
		global $event_isAdmin;
		if($event_isAdmin) return TRUE;
		if(!is_object(icms::$user)) return FALSE;
		return (icms::$user->getVar("uid")) == ($this->getVar("category_submitter", "e"));
	}
	
	public function isApproved() {
		return ($this->getVar("category_approve", "e") == 1) ? TRUE : FALSE;
	}

	public function getItemLink($urlOnly = FALSE) {
		$url = EVENT_URL.'index.php?cat='.$this->short_url();
		if($urlOnly) return $url;
		return '<a href="'.$url.'"title="'.$this->title().'">'.$this->title().'</a>';
	}

	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->id();
        $ret['name'] = $this->title();
        $ret['dsc'] = $this->getCatDsc();
        $ret['color'] = $this->getColor();
        $ret['txtcolor'] = $this->getTextColor();
		$ret['itemLink'] = $this->getItemLink();
        return $ret;
	}
}