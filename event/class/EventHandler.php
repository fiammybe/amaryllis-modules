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

}