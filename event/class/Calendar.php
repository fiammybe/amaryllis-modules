<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /class/Calendar.php
 * 
 * Class representing event calendar objects
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

class mod_event_Calendar extends icms_ipf_seo_Object {
	/**
	 * Constructor
	 *
	 * @param mod_event_Calendar $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("calendar_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("calendar_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("calendar_url", XOBJ_DTYPE_TXTBOX, TRUE, FALSE, FALSE, 'https://www.google.com/calendar/feeds/' );
		$this->quickInitVar("calendar_dsc", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("calendar_color", XOBJ_DTYPE_OTHER, TRUE);
		$this->quickInitVar("calendar_txtcolor", XOBJ_DTYPE_OTHER, TRUE, FALSE, FALSE, "#00000");
		$this->quickInitVar("calendar_tz", XOBJ_DTYPE_TXTBOX, TRUE, FALSE, FALSE);
		$this->initCommonVar("dohtml", FALSE, TRUE);
		$this->initCommonVar("dobr", FALSE, TRUE);
		$this->setControl("calendar_color", "color");
		$this->setControl("calendar_txtcolor", "color");
		
		$this->initiateSEO();
		
		$this->hideFieldFromForm(array("short_url", "meta_description", "meta_keywords"));
	}
	
	function calendar_color() {
		return "<div style='background-color:" . $this->getColor() . "; border: 1px solid black; width:30px; height:20px;'>&nbsp;</div>";
	}
	
	function calendar_txtcolor() {
		return "<div style='background-color:" . $this->getTextColor() . "; border: 1px solid black; width:30px; height:20px;'>&nbsp;</div>";
	}
	
	public function getCalendarDsc() {
		$dsc = $this->getVar("calendar_dsc", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "output");
		$filtered = strpos($dsc, '<!-- input filtered -->');
		if($filtered) {
			$dsc = str_replace('%<!-- input filtered -->', '', $dsc);
			$dsc = str_replace('%<!-- warning! output filtered only -->', '', $dsc);
		}
		return $dsc;
	}
	
	public function getColor() {
        return $this->getVar("calendar_color");
    }
	
	public function getTextColor() {
        return $this->getVar("calendar_txtcolor");
    }
	
	public function getItemLink($urlOnly = FALSE) {
		$url = EVENT_URL.'index.php?cal='.$this->short_url();
		if($urlOnly) return $url;
		return '<a href="'.$url.'"title="'.$this->title().'">'.$this->title().'</a>';
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->id();
		$ret['name'] = $this->title();
		$ret['dsc'] = $this->getCalendarDsc();
		$ret['url'] = $this->getVar("calendar_url", "e");
		$ret['color'] = $this->getColor();
		$ret['txtcolor'] = $this->getTextColor();
		$ret['default_tz'] = $this->getVar("calendar_tz", "e");
		$ret['itemLink'] = $this->getItemLink();
		return $ret;
	}
}