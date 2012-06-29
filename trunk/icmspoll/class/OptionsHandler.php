<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /class/IcmspolloptionHandler.php
 * 
 * Classes responsible for managing icmspoll option objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */
 
defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

icms_loadLanguageFile("icmspoll", "common");

class IcmspollOptionsHandler extends icms_ipf_Handler {
	
	private $_optionColors;
	
	public function __construct(&$db) {
		parent::__construct($db, "options", "option_id", "option_text", "poll_id", "icmspoll");
	}
	
	public function getOptionColors() {
		if(!$this->_optionColors) {
			$this->_optionColors['aqua'] = _CO_ICMSPOLL_OPTIONS_COLORS_AQUA;
			$this->_optionColors['blank'] = _CO_ICMSPOLL_OPTIONS_COLORS_BLANK;
			$this->_optionColors['blue'] = _CO_ICMSPOLL_OPTIONS_COLORS_BLUE;
			$this->_optionColors['brown'] = _CO_ICMSPOLL_OPTIONS_COLORS_BROWN;
			$this->_optionColors['darkgreen'] = _CO_ICMSPOLL_OPTIONS_COLORS_DARKGREEN;
			$this->_optionColors['gold'] = _CO_ICMSPOLL_OPTIONS_COLORS_GOLD;
			$this->_optionColors['green'] = _CO_ICMSPOLL_OPTIONS_COLORS_GREEN;
			$this->_optionColors['grey'] = _CO_ICMSPOLL_OPTIONS_COLORS_GREY;
			$this->_optionColors['orange'] = _CO_ICMSPOLL_OPTIONS_COLORS_ORANGE;
			$this->_optionColors['pink'] = _CO_ICMSPOLL_OPTIONS_COLORS_PINK;
			$this->_optionColors['purple'] = _CO_ICMSPOLL_OPTIONS_COLORS_PURPLE;
			$this->_optionColors['red'] = _CO_ICMSPOLL_OPTIONS_COLORS_RED;
			$this->_optionColors['yellow'] = _CO_ICMSPOLL_OPTIONS_COLORS_YELLOW;
			$this->_optionColors['transparent'] = _CO_ICMSPOLL_OPTIONS_COLORS_TRANSPARENT;
			asort($this->_optionColors);
		}
		return $this->_optionColors;
	}
	
	// public static
	public function getAllByPollId($poll_id, $order = "option_id", $sort = "DESC") {
		$criteria = new icms_db_criteria_Compo();
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		$criteria->add(new icms_db_criteria_Item("poll_id", $poll_id));
		$options = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($options as $option) {
			$ret[$option['option_id']] = $option;
		}
		return $ret;
	}
	
	public function getOptionsCountByPollId($poll_id) {
		$crit = new icms_db_criteria_Compo();
		$crit->add(new icms_db_criteria_Element("poll_id", $poll_id));
		return $this->getCount($crit);
	}

	// public static
	function deleteByPollId($poll_id) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("poll_id", $poll_id));
		return $this->deleteAll($criteria);
	}

	function resetCountByPollId($poll_id) {
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("poll_id", $poll_id));
		$options = $this->getObjects($criteria, TRUE, FALSE);
		foreach ($options as $option) {
			$obj = $this->get($option['option_id']);
			$obj->setVar("option_count", 0);
			$this->insert($obj, TRUE);
		}
		return TRUE;
	}
	
	public function updateCount(& $obj) {
		$icmspoll_log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		$votes = $icmspoll_log_handler->getTotalVotesByOptionId($obj->id());
		$obj->setVar("option_count", $votes);
		$this->insert($obj, TRUE);
		return TRUE;
	}
	
	/**
	 * filter for ACP
	 */
	public function filterPolls() {
		$icmspoll_polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
		$polls = $icmspoll_polls_handler->getList();
		return $polls;
	}
	
	/**
	 * related for storing
	 */
	protected function beforeInsert(&$obj) {
		$option_text = $obj->getVar("option_text", "s");
		$option_text = icms_core_DataFilter::checkVar($option_text, "html", "input");
		$obj->setVar("option_text", $option_text);
		return TRUE;
	}
}