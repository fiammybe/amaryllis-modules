<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /class/EventHandler.php
 * 
 * Classes responsible for managing event event objects
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

class mod_event_EventHandler extends icms_ipf_Handler {
    
    private $_catArray;
	private $_recurArray;
	private $_recFreq;
	private $_recDays;
	private $_recEndArray;
	
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "event", "event_id", "event_name", "event_dsc", "event");
	}
    
    public function getCategoryList() {
        if(!count($this->_catArray)) {
            $category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
			$criteria = $category_handler->getCategoryCriterias();
            $cats = $category_handler->getObjects($criteria, TRUE, FALSE);
            foreach ($cats as $key => $value) {
                $this->_catArray[$key] = $value['name'];
            }
        } return $this->_catArray;
    }
    
    public function getRecurs() {
        if(!count($this->_recurArray)) {
        	$this->_recurArray['dayly'] = _CO_EVENT_DAILY;
			$this->_recurArray['everyweekday'] = _CO_EVENT_EVERY_WEEKDAY;
			$this->_recurArray['everyweekend'] = _CO_EVENT_EVERY_WEEKEND;
			
			$this->_recurArray['weekly'] = _CO_EVENT_WEEKLY;
			$this->_recurArray['monthly'] = _CO_EVENT_MONTHLY;
			$this->_recurArray['yearly'] = _CO_EVENT_YEARLY;
        } return $this->_recurArray;
    }
	
	public function getRecurFreq() {
		if(!count($this->_recFreq)) {
			for($x=0; $x<31; $x++) {
				$this->_recFreq[$x] = $x;
			}
		} return $this->_recFreq;
	}
	
	public function getRecurDays() {
		if(!count($this->_recDays)) {
			$this->_recDays[1] = _CO_EVENT_MO;
			$this->_recDays[2] = _CO_EVENT_TU;
			$this->_recDays[3] = _CO_EVENT_WE;
			$this->_recDays[4] = _CO_EVENT_TH;
			$this->_recDays[5] = _CO_EVENT_FR;
			$this->_recDays[6] = _CO_EVENT_SA;
			$this->_recDays[7] = _CO_EVENT_SU;
		} return $this->_recDays;
	}
	
	public function getRecurEndArray() {
		if(!count($this->_recEndArray)) {
			$ele_after = new icms_form_elements_Text("", "ends_after", 7, 10, EVENT_RECUR_ENDVALUE, FALSE);
			$ele_on = new icms_form_elements_Date("", "ends_date", "", time() + 86400000 );
			$this->_recEndArray['never'] = _CO_EVENT_NEVER;
			$this->_recEndArray[''] = _CO_EVENT_ENDSAFTER . ' ' . $ele->render() . ' ' . _CO_EVENT_OCCURRENCES;
		} return $this->_recEndArray;
	}

	/**
	 * event criterias
	 * @param $cat_id can be int cid or an array of cids
	 * @param $perm => string "cat_view" or "cat_submit"
	 * @param $start => int UNIX Timestamp
	 * @param $end => int UNIX Timestamp
	 */
	public function getEventCriterias( $cat_id, $perm = 'cat_view',$start = 0, $end = "month", $private = TRUE) {
		$criteria = new icms_db_criteria_Compo();
		if($cat_id !== FALSE) {
			$perm_handler = new icms_ipf_permission_Handler($this);
			$grantedItems = $perm_handler->getGrantedItems($perm);
			if(!is_array($cat_id)) {
				$criteria->add(new icms_db_criteria_Item("event_cid", $cat_id));
				$criteria->add(new icms_db_criteria_Item($cat_id, '(' . implode(', ', $grantedItems) . ')', 'IN'));
			} else {
				foreach ($cat_id as $key => $value) {
					$criteria->add(new icms_db_criteria_Item("event_cid", $value), 'OR');
					$criteria->add(new icms_db_criteria_Item($value, '(' . implode(', ', $grantedItems) . ')', 'IN'));
				}
			}
		}
		if($private) {
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("event_public", 1), 'OR');
			$critTray->add(new icms_db_criteria_Item("event_submitter", $uid), 'OR');
			$criteria->add($critTray);
		}
		$criteria->add(new icms_db_criteria_Item("event_startdate", time(), '>='));
		if($end == "month") {
			$criteria->add(new icms_db_criteria_Item("event_enddate", time() + 60*60*24*31, '<=' ));
		} elseif ($end == "week") {
			$criteria->add(new icms_db_criteria_Item("event_enddate", time() + 60*60*24*7, '<=' ));
		} elseif($end == "year") {
			$criteria->add(new icms_db_criteria_Item("event_enddate", time() + 60*60*24*30*12, '<=' ));
		}
		return $criteria;
	}

	public function getEvents($cat_ids = FALSE, $perm = 'cat_view', $end = "month") {
		$criteria = $this->getEventCriterias($cat_ids, $perm, $end);
		$events = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($events as $event) {
			$ret[$event['id']] = $event;
		}
		return $ret;
	}
	
	public function getEventBySeo($seo) {
		$event = FALSE;
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", trim($seo)));
		$events = $this->getObjects($criteria, FALSE, FALSE);
		if($events) $event = $this->get($events[0]['event_id']);
		return $event;
	}

	/**
	 * handling some functions to easily switch some fields
	 */
	public function changeField($event_id, $field) {
		$eventObj = $this->get($event_id);
		if ($eventObj->getVar("$field", 'e') == TRUE) {
			$eventObj->setVar("$field", 0);
			$value = 0;
		} else {
			$eventObj->setVar("$field", 1);
			$value = 1;
		}
		$eventObj->updating_counter = TRUE;
		$this->insert($eventObj, TRUE);
		return $value;
	}

	public function filterApprove() {
		return array(0 => 'Denied', 1 => 'Approved');
	}
	
	public function filterCid() {
		return $this->getCategoryList();
	}
	
	public function updateComments($event_id, $total_num) {
		$eventObj = $this->get($event_id);
		if ($eventObj && !$eventObj->isNew()) {
			$eventObj->setVar('event_comments', $total_num);
			$this->insert($eventObj, TRUE);
		}
	}

	protected function beforeInsert(&$obj) {
		if($obj->_updating)
		return TRUE;
		$start = $obj->getVar("event_startdate", "e");
		if($start < time()) {
			$obj->setErrors(_CO_EVENT_CANNOT_BOOK_PAST);
			return FALSE;
		}
		$seo = $obj->short_url();
		if($seo == "") $seo = icms_ipf_Metagen::generateSeoTitle($obj->title(), FALSE);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seo));
		if($this->getCount($criteria)) {
			$seo = $seo . '_' . time();
			$obj->setVar("short_url", $seo);
		}
		return TRUE;
	}
	
	protected function beforeSave(&$obj) {
		$tags = trim($obj->getVar("event_tags"));
		if($tags != "" && $tags != "0" && icms_get_module_status("index")) {
			$indexModule = icms_getModuleInfo("index");
			$tag_handler = icms_getModuleHandler("tag", $indexModule->getVar("dirname"), "index");
			$tagarray = explode(",", $tags);
			$tagarray = array_map('strtolower', $tagarray);
			$newArray = array();
			foreach ($tagarray as $key => $tag) {
				$intersection = array_intersect($tagarray, array($tag));
				$count = count($intersection);
				if($count > 1) {
					unset($tagarray[$key]);
				} else {
					$tag_id = $tag_handler->addTag($tag, FALSE, $obj, $obj->getVar("event_created_on", "e"), $obj->getVar("event_submitter", "e"), "event_dsc", FALSE);
					$newArray[] = $tag_id;
				}
				unset($intersection, $count);
			}
			$obj->setVar("event_tags", implode(",", $newArray));
			unset($tags, $indexModule, $tag_handler, $tags, $tagarray);
		}
		return TRUE;
	}
	
	public function afterSave(&$obj) {
		if (!$obj->notifSent() && $obj->isApproved()) {
			if($obj->isNew()) {
				$obj->sendNotification('event_published');
			} else {
				$obj->sendNotification('event_modified');
			}
			$obj->setVar('event_notif_sent', TRUE);
			$obj->updating = TRUE;
			$this->insert($obj, TRUE);
		}
		return TRUE;
	}
	
	protected function afterDelete(& $obj) {
		$notification_handler = icms::handler( 'icms_data_notification' );
		$module_handler = icms::handler('icms_module');
		$module = $module_handler->getByDirname(EVENT_DIRNAME);
		$module_id = $module->getVar('mid');
		$category = 'global';
		$event_id = $obj->id();
		// delete global notifications
		$notification_handler->unsubscribeByItem($module_id, $category, $event_id);
		if(icms_get_module_status("index")) {
			//delete all linked tags
			$link_handler = icms_getModuleHandler("link", "index");
			$link_handler->deleteAllByCriteria(FALSE, FALSE, $module_id, $this->_itemname, $obj->id());
			unset($link_handler);
		}
		unset($notification_handler, $module_handler, $module);
		return TRUE;
	}
}