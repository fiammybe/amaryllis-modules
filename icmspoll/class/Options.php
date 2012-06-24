<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /class/Options.php
 * 
 * Class representing icmspoll options objects
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

class IcmspollOptions extends icms_ipf_Object {

	/**
	 * constructor
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);
		$this->quickInitVar("option_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("poll_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("option_text", XOBJ_DTYPE_TXTBOX, TRUE, FALSE, FALSE);
		$this->quickInitVar("option_count", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("option_color", XOBJ_DTYPE_OTHER, FALSE, FALSE, FALSE, "");
		$this->initCommonVar("weight");
		
		$this->setControl("poll_id", array("name" => "select", "itemHandler" => "polls", "method" => "getList", "module" => "icmspoll"));
		$this->setControl("option_color", array("name" => "select", "itemHandler" => "options", "method" => "getOptionColors", "module" => "icmspoll"));
		
		$this->hideFieldFromForm("option_count");
	}
	
	public function getPollName() {
		$icmspoll_polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
		$pollObj = $icmspoll_polls_handler->get($this->getVar("poll_id", "e"));
		return $pollObj->getQuestion();
	}
	
	public function getPollIdControl() {
		$icmspoll_polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
		$options = $icmspoll_polls_handler->getList();
		$control = new icms_form_elements_Select('', 'poll_id[]', $this->getVar('poll_id', 'e'));
		$control->addOptionArray($options);
		return $control->render();
	}
	
	public function getOptionTextControl() {
		$control = new icms_form_elements_Text('', 'option_text[]', 50, 255,$this->getVar('option_text', 'e'));
		return $control->render();
	}
	
	public function getOptionColorControl() {
		$options = $this->handler->getOptionColors();
		$control = new icms_form_elements_Select('', 'option_color[]', $this->getVar('option_color', 'e'));
		$control->addOptionArray($options);
		return $control->render();
	}
	
	public function getWeightControl() {
		$control = new icms_form_elements_Text('', 'weight[]', 5, 7,$this->getVar('weight', 'e'));
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	public function getOptionText() {
		$optionText = $this->getVar("option_text", "s");
		$optionText = icms_core_DataFilter::checkVar($optionText, "html", "output");
		return $optionText;
	}

	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("option_id", "e");
		$ret['poll_id'] = $this->getVar("poll_id", "e");
		$ret['text'] = $this->getOptionText();
		$ret['color'] = $this->getVar("option_color", "e");
		return $ret;
	}
}
