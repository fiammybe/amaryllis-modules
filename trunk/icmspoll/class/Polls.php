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
if(!defined("ICMSPOLL_DIRNAME")) define("ICMSPOLL_DIRNAME", basename(dirname(dirname(__FILE__))));

class IcmspollPolls extends icms_ipf_seo_Object {
	
	public $updating_expired = FALSE;
	
	/**
	 * constructor
	 * 
	 * @param IcmspollPolls $handler PollsHandler
	 */
	public function __construct(&$handler) {
	
		parent::__construct($handler);
		$this->quickInitVar("poll_id", XOBJ_DTYPE_INT, NULL, FALSE);
		$this->quickInitVar("question", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("description", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("delimeter", XOBJ_DTYPE_INT, FALSE);
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
		$this->quickInitVar("started", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("poll_comments", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("notification_sent", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("message_sent", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("total_init_value", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("dobr", FALSE);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("docxode", FALSE, 1);
		
		$this->setControl("description", array('name' => 'textarea', 'form_editor' => 'htmlarea'));
		$this->setControl("delimeter", array("name" => "select", "itemHandler" => "polls", "method" => "getDelimeters", "module" => "icmspoll"));
		$this->setControl("user_id", "user");
		$this->setControl("display", "yesno");
		$this->setControl("mail_status", "yesno");
		$this->setControl("multiple", "yesno");
		$this->setControl("expired", "yesno");
		$this->setControl("started", "yesno");
		
		$this->initiateSEO();
		
		$this->hideFieldFromForm(array("total_init_value", "message_sent", "notification_sent", "started", "expired", "created_on", "poll_comments", "user_id", "votes", "voters", "short_url",
										"meta_description", "meta_keywords"));
		$this->hideFieldFromSingleView(array("started", "expired"));

	}

	function getUser() {
		return icms_member_user_Handler::getUserLink($this->getVar('user_id', 'e'));
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

	public function getQuestion() {
		$question = $this->getVar("question", "s");
		$question = icms_core_DataFilter::checkVar($question, "html", "output");
		$question = icms_core_DataFilter::undoHtmlSpecialChars($question);
		return $question;
	}
	
	public function getDescription() {
		$description = $this->getVar("description", "s");
		$description = icms_core_DataFilter::checkVar($description, "html", "output");
		$description = icms_core_DataFilter::undoHtmlSpecialChars($description);
		return $description;
	}
	
	public function getDelimeter() {
		return ($this->getVar("delimeter", "e") == 1) ? "<br />" : "&nbsp;";
	}
	
	public function getWeightControl() {
		$control = new icms_form_elements_Text('', 'weight[]', 5, 7,$this->getVar('weight', 'e'));
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
    
	public function hasVoted() {
		$icmspoll_log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		$user_id = is_object(icms::$user) ? icms::$user->getVar("uid", "e") : 0;
		$voted = $icmspoll_log_handler->hasVoted($this->id(), $_SERVER['REMOTE_ADDR'], $user_id, $_SESSION['icms_fprint']);
		unset($icmspoll_log_handler);
		if(!$voted) return FALSE;
		return TRUE;
	}
	
	public function hasStarted() {
		if($this->getVar("started", "e") == 1) return TRUE;
		$end_time = $this->getVar("end_time", "e");
		$start_time = $this->getVar("start_time", "e");
		$time = time();
		if($start_time > $time) return FALSE;
		$this->handler->setStarted($this->id());
		return TRUE;
	}
	
	public function displayStarted() {
		if($this->hasStarted()) {
			return '<img src="' . ICMSPOLL_IMAGES_URL . 'approved.png" alt="Started" />';
		} else {
			return '<img src="' . ICMSPOLL_IMAGES_URL . 'denied.png" alt="Inactive" />';
		}
	}
	
	public function hasExpired() {
		if($this->getVar("expired", "e") == 1) {
			return TRUE;
		} elseif ( $this->getVar("end_time", "e") > time() ) {
			return FALSE;
		} else {
			$this->handler->setExpired($this->id());
			return TRUE;
		}
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
		if ($viewperm && $this->hasStarted()) return TRUE;
		return FALSE;
	}
	
	public function voteAccessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(ICMSPOLL_DIRNAME);
		$voteperm = $gperm_handler->checkRight('polls_vote', $this->id(), $groups, $module->getVar("mid"));
		if ($voteperm && !$this->hasVoted() && !$this->hasExpired() && $this->hasStarted()) return TRUE;
		return FALSE;
	}

	public function vote($options, $ip, $user_id = NULL, $sess_id) {
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
					$logObj->setVar("poll_id", $this->getVar("poll_id", "e"));
					$logObj->setVar("option_id", $option);
					$logObj->setVar("ip", $ip);
					$logObj->setVar("session_id", $sess_id);
					$logObj->setVar("user_id", $user_id);
					$logObj->setVar("time", time());
					if(!$icmspoll_log_handler->insert($logObj, TRUE)) {
					} else {
						$icmspoll_option_handler->updateCount($optionObj);
						$this->updating_expired = TRUE;
						$this->handler->updateCount($this->id());
					}
				}
			}
		} else {
			$optionObj = $icmspoll_option_handler->get($options);
			if ( $this->id() == $optionObj->getVar("poll_id", "e") ) {
				$logObj = $icmspoll_log_handler->create(TRUE);
				$logObj->setVar("poll_id", $this->id());
				$logObj->setVar("option_id", $options);
				$logObj->setVar("ip", $ip);
				$logObj->setVar("session_id", $sess_id);
				$logObj->setVar("user_id", $user_id);
				$logObj->setVar("time", time());
				$icmspoll_log_handler->insert($logObj, TRUE);
				if(!$icmspoll_log_handler->insert($logObj, TRUE)) {
				} else {
					$icmspoll_option_handler->updateCount($optionObj);
					$this->updating_expired = TRUE;
					$this->handler->updateCount($this->id());
				}
			}
		}
		
		return TRUE;
	}

	/**
	 * returns URL or link to a poll
	 */
	function getItemLink($onlyUrl = FALSE) {
		$url = ICMSPOLL_URL . 'index.php?poll=' . $this->short_url();
		if ($onlyUrl) return $url;
		$question = $this->getQuestion();
		return '<a href="' . $url . '" title="' . $question . ' ">' . $question . '</a>';
	}
	
	function getPreviewLink() {
		$url = ICMSPOLL_URL . 'index.php?poll_id=' . $this->id();
		$question = $this->getQuestion();
		return '<a href="' . $url . '" title="' . $question . '" target="_blank" >' . $question . '</a>';
	}
	
	public function getResetItemLink() {
		$ret = '<a href="' . ICMSPOLL_ADMIN_URL . 'polls.php?op=reset&amp;poll_id=' . $this->id() . '" title="' . _CO_ICMSPOLL_RESET . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/reload.png" /></a>';
		return $ret;
	}
	
	function getResultLink() {
		$url = ICMSPOLL_URL . 'results.php?poll_id=' . $this->id();
		$question = $this->getQuestion();
		return '<a href="' . $url . '" title="' . $question . '">' . $question . '</a>';
	}
	
	function getMorePollsByCreator() {
		$url = ICMSPOLL_URL . 'index.php?op=getPollsByCreator&uid=' . $this->getVar("user_id", "e");
		$uname = icms_member_user_Object::getUnameFromId($this->getVar("user_id", "e"));
		return '<a href="' . $url . '" title="' . _CO_ICMSPOLL_POLLS_GET_MORE_BY_USER . $uname . '">' . _CO_ICMSPOLL_POLLS_GET_MORE_BY_USER . $uname . '</a>';
	}
	
	function getMoreResultsByCreator() {
		$url = ICMSPOLL_URL . 'results.php?op=getPollsByCreator&uid=' . $this->getVar("user_id", "e");
		$uname = icms_member_user_Object::getUnameFromId($this->getVar("user_id", "e"));
		return '<a href="' . $url . '" title="' . _CO_ICMSPOLL_POLLS_GET_MORE_RESULTS_BY_USER . $uname . '" >' . _CO_ICMSPOLL_POLLS_GET_MORE_RESULTS_BY_USER . $uname . '</a>';
	}
	
	public function isMultiple() {
		return ($this->getVar("multiple")) ? TRUE : FALSE;
	}
	
	public function getInputType() {
		return ($this->isMultiple()) ? "checkbox" : "radio";
	}
	
	function userCanEditAndDelete() {
		global $icmspoll_isAdmin;
		if(!is_object(icms::$user)) return FALSE;
		if($icmspoll_isAdmin) return TRUE;
		return $this->getVar('user_id', 'e') == icms::$user->getVar("uid", "e");
	}
	
	/**
	 * send polls toArray
	 */
	function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->id();
		$ret['question'] = $this->getQuestion();
		$ret['dsc'] = $this->getDescription();
		$ret['user'] = $this->getUser();
		$ret['delimeter'] = $this->getDelimeter();
		
		$ret['start_time'] = $this->getStartDate();
		$ret['end_time'] = $this->getEndDate();
		$ret['created_on'] = $this->getCreatedDate();
		
		$ret['comments'] = $this->getVar("poll_comments", "e");
		$ret['inputtype'] = $this->getInputType();
		$ret['isMultiple'] = $this->isMultiple();
		
		$ret['viewAccessGranted'] = $this->viewAccessGranted();
		$ret['voteAccessGranted'] = $this->voteAccessGranted();
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['editItemLink'] = $this->getEditItemLink(FALSE, TRUE, TRUE);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(FALSE, TRUE, TRUE);
		$ret['hasExpired'] = $this->hasExpired();
		$ret['hasVoted'] = $this->hasVoted();
		$ret['hasStarted'] = $this->hasStarted();
		
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['resultLink'] = $this->getResultLink();
		$ret['more_polls_by_user'] = $this->getMorePollsByCreator();
		$ret['more_results_by_user'] = $this->getMoreResultsByCreator();
		return $ret;
	}

	function sendNotifPollPublished() {
		$module = icms::handler('icms_module')->getByDirname(ICMSPOLL_DIRNAME);
		$tags ['POLL_TITLE'] = $this->getQuestion();
		$tags ['POLL_URL'] = $this->getItemLink(TRUE);
		icms::handler('icms_data_notification')->triggerEvent('global', 0, 'poll_published', $tags, array(), $module->getVar('mid'));
	}
}