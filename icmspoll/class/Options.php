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
if(!defined("ICMSPOLL_DIRNAME")) define("ICMSPOLL_DIRNAME", basename(dirname(dirname(__FILE__))));

class IcmspollOptions extends icms_ipf_Object {
	
	public $_updating = FALSE;

	/**
	 * constructor
	 */
	public function __construct(&$handler) {
		global $icmspollConfig;
		parent::__construct($handler);
		$this->quickInitVar("option_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("poll_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("option_text", XOBJ_DTYPE_TXTBOX, TRUE, FALSE, FALSE);
		$this->quickInitVar("option_count", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("option_color", XOBJ_DTYPE_OTHER, FALSE, FALSE, FALSE, "");
		$this->quickInitVar("option_init", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("user_id", XOBJ_DTYPE_INT);
		$this->initCommonVar("weight");
		
		$this->setControl("poll_id", array("name" => "select", "itemHandler" => "polls", "method" => "getList", "module" => "icmspoll"));
		$this->setControl("option_color", array("name" => "select", "itemHandler" => "options", "method" => "getOptionColors", "module" => "icmspoll"));
		
		if($icmspollConfig['allow_init_value'] == 0) {
			$this->hideFieldFromForm("option_init");
		}
		
		$this->hideFieldFromForm(array("option_count", "user_id"));
	}
	
	public function getPollName() {
		$icmspoll_polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
		$pollObj = $icmspoll_polls_handler->get($this->getVar("poll_id", "e"));
		return $pollObj->getQuestion();
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
	
	public function getOptionEndresult() {
		global $icmspoll_isAdmin;
		$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
		$pollObj = $polls_handler->get($this->getVar("poll_id", "e"));
		$total_votes = $pollObj->getVar("votes", "e");
		$total_opt_votes = $this->getVar("option_count", "e");
		$option_result =  @round((($total_opt_votes / $total_votes) * 100),2) . "%";
		unset($log_handler);
		return $option_result;
	}
	
	public function getOptionResult() {
		$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
		$pollObj = $polls_handler->get($this->getVar("poll_id", "e"));
		$total_votes = $pollObj->getVar("total_init_value", "e") + $pollObj->getVar("votes", "e");
		$total_opt_votes = $this->getVar("option_init", "e") + $this->getVar("option_count", "e");
		$option_endresult =  @round((($total_opt_votes / $total_votes) * 100),2) . "%";
		return $option_endresult;
	}
	
	public function getOptionAnonVotes() {
		$log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		$option_id = $this->id();
		$option_anons = $log_handler->getAnonVotesByOptionId($option_id);
		return $option_anons;
	}
	
	public function getOptionUserVotes() {
		$log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		$option_id = $this->id();
		$option_users = $log_handler->getUserVotesByOptionId($option_id);
		return $option_users;
	}
	
	public function getTotalOptionVotes() {
		$anons = $this->getOptionAnonVotes();
		$users = $this->getOptionUserVotes();
		return $anons+$users;
	}
	
	function userCanEditAndDelete() {
		global $icmspoll_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($icmspoll_isAdmin) return TRUE;
		return $this->getVar('user_id', 'e') == icms::$user->getVar("uid", "e");
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("option_id", "e");
		$ret['poll_id'] = $this->getVar("poll_id", "e");
		$ret['text'] = $this->getOptionText();
		$ret['color'] = $this->getVar("option_color", "e");
		$ret['result'] = $this->getOptionResult();
		$ret['endresult'] = $this->getOptionEndresult();
		$ret['anon_votes'] = $this->getOptionAnonVotes();
		$ret['user_votes'] = $this->getOptionUserVotes();
		$ret['total_votes'] = $this->getTotalOptionVotes();
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		return $ret;
	}
}
