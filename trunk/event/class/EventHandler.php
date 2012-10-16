<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
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
	
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "event", "event_id", "event_name", "event_dsc", "event");
	}
    
    public function getCategoryList($showNull = FALSE) {
        if(!count($this->_catArray)) {
            $category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
			$criteria = $category_handler->getCategoryCriterias();
            $cats = $category_handler->getObjects($criteria, TRUE, FALSE);
            if($showNull) $this->_catArray[0] = "-------------------";
            foreach ($cats as $key => $value) {
                $this->_catArray[$key] = $value['name'];
            }
        } return $this->_catArray;
    }
    
	/**
	 * event criterias
	 * @param $cat_id can be int cid or an array of cids
	 * @param $perm => string "cat_view" or "cat_submit"
	 * @param $start => int UNIX Timestamp
	 * @param $end => int UNIX Timestamp
	 */
	public function getEventCriterias( $cat_id, $start = 0, $end = 0, $uid = 0, $order = "event_name", $sort = "ASC", $limit = FALSE, $public = TRUE) {
		global $event_isAdmin;
		$criteria = new icms_db_criteria_Compo();
		if($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($cat_id && !is_array($cat_id)){
			$criteria->add(new icms_db_criteria_Item("event_cid", $cat_id));
		} elseif ($cat_id && is_array($cat_id)) {
			$tray = new icms_db_criteria_Compo();
			foreach($cat_id as $key => $value) {
				$tray->add(new icms_db_criteria_Item("event_cid", $value), 'OR');
			}
			$criteria->add($tray);
		}
		
		if($public) {
			if(is_null($uid)) $uid = 0;
			$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item("event_public", 1));
			$crit->add(new icms_db_criteria_Item("event_submitter", $uid), 'OR');
			$criteria->add($crit);
		}
		
		if(!$event_isAdmin) {
			$critTray = new icms_db_criteria_Compo(new icms_db_criteria_Item("event_approve", 1));
			if(is_object(icms::$user)) $critTray->add(new icms_db_criteria_Item("event_submitter", $uid), 'OR');
			$criteria->add($critTray);
		}
		
		if($start > 0) $criteria->add(new icms_db_criteria_Item("event_startdate", $start, '>='));
		if($end > 0) $criteria->add(new icms_db_criteria_Item("event_enddate", $end, '<='));
		return $criteria;
	}

	public function getEvents($cat_id = FALSE, $start = 0, $end = 0, $uid = 0, $order = "event_name", $sort = "ASC", $limit = FALSE) {
		$criteria = $this->getEventCriterias($cat_id, $start, $end, $uid, $order, $sort, $limit);
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

	public function deleteOldEvents($range) {
		if($range > 0) {
			$time = time();
			$del_range = 60*60*24*30*(int)$range;
			$end_date = $time-$del_range;
			$criteria = $this->getEventCriterias(FALSE, 0 , $end_date, FALSE, FALSE, FALSE, FALSE, FALSE);
			$count = $this->getCount($criteria);
			$this->deleteAll($criteria);
			return $count;
		}
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
		$eventObj->_updating = TRUE;
		$this->insert($eventObj, TRUE);
		return $value;
	}

	public function filterApprove() {
		return array(0 => 'Denied', 1 => 'Approved');
	}
	
	public function filterCid() {
		return $this->getCategoryList();
	}
	
	public function filterUser(){
		$sql = "SELECT DISTINCT event_submitter FROM " . $this->table;
		if ($result = icms::$xoopsDB->query($sql)) {
			$bids = array();
			if($showNull) $bids[0] = '--------------';
			while ($myrow = icms::$xoopsDB->fetchArray($result)) {
				$bids[$myrow['event_submitter']] = icms_member_user_Object::getUnameFromId((int)$myrow['event_submitter']);
			}
			return $bids;
		}
	}
	
	protected function beforeInsert(&$obj) {
		if($obj->_updating)
		return TRUE;
		$start = $obj->getVar("event_startdate", "e");
		$end = $obj->getVar("event_enddate", "e");
		if($start < time()) {
			$obj->setErrors(_CO_EVENT_CANNOT_BOOK_PAST);
			return FALSE;
		}
		if($end < $start) {
			$obj->setErrors(_CO_EVENT_CANNOT_BOOK_PASTEND);
			return FALSE;
		}
		$seo = $obj->short_url();
		if($seo == "") $seo = icms_ipf_Metagen::generateSeoTitle($obj->title(), FALSE);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seo));
		if($this->getCount($criteria)) {
			$seo = $seo . '_' . time();
			$obj->setVar("short_url", $seo);
		}
		$dsc = $obj->getVar("event_dsc", "e");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$dsc = str_replace("'",'"', $dsc);
		$obj->setVar("event_dsc", $dsc);
		return TRUE;
	}
	
	protected function afterInsert(&$obj) {
		if($obj->_updating) return TRUE;
		if($obj->isApproved() && !$obj->notifSent()) {
			$obj->sendNotification();
			$obj->setVar('event_notif_sent', TRUE);
			$obj->_updating = TRUE;
			$this->insert($obj, TRUE);
		}
		return TRUE;
	}
	
	protected function afterUpdate(&$obj) {
		if($obj->isApproved()) {
			
			$obj->sendModNotification();
		}
		return TRUE;
	}
	
	protected function beforeSave(&$obj) {
		if($obj->_updating)
		return TRUE;
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