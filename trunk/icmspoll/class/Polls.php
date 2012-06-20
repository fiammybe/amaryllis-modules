<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /class/Polls.php
 * 
 * Class representing icmspoll poll objects
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

class IcmspollPolls extends icms_ipf_Object {
	
	/**
	 * constructor
	 * 
	 * @param IcmspollPolls $handler PollsHandler
	 */
	public function __construct(&$handler) {
	
		parent::__construct($handler);
		$this->quickInitVar("poll_id", XOBJ_DTYPE_INT, NULL, FALSE);
		$this->quickInitVar("question", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("description", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("user_id", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("start_time", XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar("end_time", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("votes", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("voters", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("display", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->initCommonVar("weight");
		$this->quickInitVar("multiple", XOBJ_DTYPE_INT, 0, FALSE);
		$this->quickInitVar("mail_status", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("created_on", XOBJ_DTYPE_LTIME, TRUE, FALSE);
		$this->quickInitVar("expired", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("poll_comments", XOBJ_DTYPE_INT, FALSE);
		
		$this->setControl("display", "yesno");
		$this->setControl("mail_status", "yesno");
		$this->setControl("multiple", "yesno");
		
		$this->hideFieldFromForm(array("expired", "created_on", "poll_comments"));
		$this->hideFieldFromSingleView(array("expired"));

	}

	public function getCreatedDate() {
		global $icmspollConfig;
		$date = $this->getVar('created_on', 'e');
		return date($icmspollConfig['icmspoll_dateformat'], $date);
	}
	
	public function getStartDate() {
		global $icmspollConfig;
		$date = $this->getVar('start_time', 'e');
		return date($icmspollConfig['icmspoll_dateformat'], $date);
	}
	
	public function getEndDate() {
		global $icmspollConfig;
		$date = $this->getVar('end_time', 'e');
		return date($icmspollConfig['icmspoll_dateformat'], $date);
	}

	public function hasVoted() {
		$icmspoll_log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		$user_id = is_object(icms::$user) ? icms::$user->getVar("uid", "e") : 0;
		$voted = $icmspoll_log_handler->hasVoted($this->id(), xoops_getenv('REMOTE_ADDR'), $user_id);
		unset($icmspoll_log_handler);
		if(!$voted) return FALSE;
		return TRUE;
	}
	
	public function hasExpired() {
		if($this->getVar("expired", "e") == 1) return TRUE;
		if ( $this->getVar("end_time") > time() ) return FALSE;
		$this->handler->setExpired();
		return TRUE;
	}
	
	public function displayExpired() {
		if($this->hasExpired()) {
			return '<img src="' . ICMSPOLL_IMAGES_URL . 'hidden.png" alt="Expired" />';
		} else {
			return '<img src="' . ICMSPOLL_IMAGES_URL . 'visible.png" alt="Active" />';
		}
	}

	public function viewAccessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(ICMSPOLL_DIRNAME);
		$viewperm = $gperm_handler->checkRight('polls_view', $this->getVar('poll_id', 'e'), $groups, $module->getVar("mid"));
		if (is_object(icms::$user) && icms::$user->getVar("uid") == $this->getVar('user_id', 'e')) return TRUE;
		if ($viewperm) return TRUE;
		return FALSE;
	}
	
	public function voteAccessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(ICMSPOLL_DIRNAME);
		$voteperm = $gperm_handler->checkRight('polls_vote', $this->getVar('poll_id', 'e'), $groups, $module->getVar("mid"));
		if (is_object(icms::$user) && icms::$user->getVar("uid") == $this->getVar('user_id', 'e')) return TRUE;
		if ($voteperm && !$this->hasVoted() && !$this->hasExpired()) return TRUE;
		return FALSE;
	}

	public function vote($options, $ip, $user_id = NULL) {
		if(!$this->voteAccessGranted()) return FALSE;
		if(empty($options)) return FALSE;
		if(is_null($user_id)) $user_id = 0;
		$icmspoll_option_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");
		$icmspoll_log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		if (is_array($options)) {
			foreach ($options as $option) {
				$optionObj = $icmspoll_option_handler->get($option);
				if ( $this->id() == $optionObj->getVar("poll_id") ) {
					$logObj = $icmspoll_log_handler->create(TRUE);
					$logObj->setVar("poll_id", $this->getVar("poll_id"));
					$logObj->setVar("option_id", $vote);
					$logObj->setVar("ip", $ip);
					$logObj->setVar("user_id", $user_id);
					if(!$icmspoll_log_handler->insert($logObj, TRUE)) {
					} else {
						$icmspoll_option_handler->updateCount($optionObj);
					}
				}
			}
		} else {
			$optionObj = $icmspoll_option_handler->get($options);
			if ( $this->id() == $optionObj->getVar("poll_id") ) {
				$logObj = $icmspoll_log_handler->create(TRUE);
				$logObj->setVar("poll_id", $this->id());
				$logObj->setVar("option_id", $options);
				$logObj->setVar("ip", $ip);
				$logObj->setVar("user_id", $user_id);
				$icmspoll_log_handler->insert($logObj, TRUE);
				$icmspoll_option_handler->updateCount($optionObj);
			}
		}
		$this->handler->updateCount($this->id());
		return TRUE;
	}

	public function getPollForm() {
		if(!$this->viewAccessGranted()) return FALSE;
		$icmspoll_options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");
		$options = $icmspoll_options_handler->getAllByPollId($this->id());
		$user_id = is_object(icms::$user) ? icms::$user->getVar("uid", "e") : 0;
		
		$form = new icms_form_Theme(_MD_ICMSPOLL_POLL_FORM, "submit", "submitpoll.php?op=submit&poll_id=" . $this->id(), "post", TRUE);
		if($this->getVar("multiple", "e") == 1) {
			$optionsEle = new icms_form_elements_Checkbox("", "poll_options", NULL, "<br />");
		} else {
			$optionsEle = new icms_form_elements_Radio("", "poll_options", NULL, "<br />");
		}
		foreach ($options as $option) {
			$optionsEle->addOption($option->id(), $option->getOptionText());
		}
		$form->addElement($optionsEle, TRUE);
		$form->addElement(new icms_form_elements_Hidden("poll_ip", xoops_getenv("REMOTE_ADDR")));
		$form->addElement(new icms_form_elements_Hidden("user_id", $user_id));
		if($this->voteAccessGranted()) {
			$form->addElement(new icms_form_elements_Button("", "submit", _MD_ICMSPOLL_VOTE, "button"));
		} else {
			if($this->hasVoted()) $voteDenied = _MD_ICMSPOLL_ALREADY_VOTED;
			if(!$this->voteAccessGranted()) $voteDenied = _MD_ICMSPOLL_VOTE_DENIED;
			$form->addElement(new icms_form_elements_Label("", $voteDenied, "button"));
		}
		return $form->render();
		
	}
	
	/**
	 * get the ammount of comments for a poll
	 */
	public function getComments($poll_id) {
		$icmspollModule = icms_getModuleInfo(ICMSPOLL_DIRNAME);
		$comment_handler = icms::handler('icms_data_comment');
        $criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("com_modid", $icmspollModule->getVar("mid")));
		$criteria->add(new icms_db_criteria_Item("com_itemid", $poll_id));
		$count = $comment_handler->getCount($criteria);
		unset($comment_handler, $icmspollModule);
		return $count;
    }
	
	/**
	 * send polls toArray
	 */
	function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->id();
		$ret['question'];
	}
}