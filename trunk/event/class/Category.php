<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
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
        $this->quickInitVar("category_approve", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
        $this->quickInitVar("category_submitter", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
        $this->quickInitVar("category_created_on", XOBJ_DTYPE_LTIME, TRUE);
        $this->quickInitVar("category_pubcal", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
        $this->initCommonVar("dohtml", FALSE, TRUE);
        
        $this->setControl('category_dsc', array("name" => "textarea"));
        $this->setControl("category_color", "color");
		$this->setControl("category_approve", "yesno");
        $this->setControl("category_pubcal", "yesno");
        
		$this->initiateSEO();
        
        $this->hideFieldFromForm(array("short_url", "meta_description", "meta_keywords", "category_approve", "category_submitter", "category_created_on", "category_pubcal"));
        $this->hideFieldFromSingleView(array("category_approve", "category_submitter", "category_created_on", "category_pubcal"));
	}

    public function getColor() {
        return $this->getVar("category_color");
    }
    
    public function accessGranted() {
        $user_grp = (is_object(icms::$user)) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
        $user_id = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
        
    }

	public function getItemLink($urlOnly = FALSE) {
		$url = EVENT_URL . 'category.php?cat=' . $this->short_url();
		if($urlOnly) return $url;
		return '<a href="' . $url . '" title="' . $this->title() . '">' . $this->title() . '</a>';
	}

	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->id();
        $ret['name'] = $this->title();
        $ret['dsc'] = $this->summary();
        $ret['color'] = $this->getColor();
        
        return $ret;
	}
}