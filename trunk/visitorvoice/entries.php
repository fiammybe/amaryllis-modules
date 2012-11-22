<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /entries.php
 * 
 * fetch entries
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.10
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

include '../../mainfile.php';
include ICMS_MODULES_PATH.'/'.basename(dirname(__FILE__)).'/include/common.php';
icms::$logger->disableLogger();

$clean_uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
$clean_start = isset($_POST['start']) ? filter_input(INPUT_POST, "start", FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_limit = $visitorvoiceConfig['show_entries'];

$visitorvoice_handler = icms_getModuleHandler("visitorvoice", VISITORVOICE_DIRNAME, "visitorvoice");

$entries = $visitorvoice_handler->getEntries(TRUE, 0, $clean_start, $clean_limit, 'visitorvoice_published_date', 'DESC');
$count = count($entries);
$need_reload = (($count-1) % $visitorvoiceConfig['show_entries'] === 0) ? "true" : "false"; 
if(!$entries) echo json_encode(array("reload" => $need_reload, "entries" => '<p>'._MD_VISITORVOICE_NO_ENTRIES.'</p>'));
$reply = array();
foreach($entries as $key => $value) {
	$userinfo = $value['published_by'];
	$file = VISITORVOICE_ROOT_PATH.'templates/visitorvoice_singleentry.html';
	$content = file_get_contents($file);
	$content = str_replace("{ENTRY_TITLE}", $value['title'], $content);
	if($value['visitorvoice_uid'] > 0) {
		$string1 = '<a class="visitorvoice_ulink" href="'.$userinfo["link"].'">'.$value['visitorvoice_name'].'</a>';
	} else {
		$string1 = $value['visitorvoice_name'];
	}
	$content = str_replace("{ENTRY_NAME}", $string1, $content);
	if($visitorvoiceConfig['show_avatar']) {
		if($value['visitorvoice_uid'] > 0) {
			$string = '<a class="visitorvoice_ulink" href="'.$userinfo["link"].'"><img src="'.$userinfo["avatar"].'" width="'.$visitorvoiceConfig['avatar_dimensions'].'px" height="'.$visitorvoiceConfig['avatar_dimensions'].'px" alt="avatar" /></a>';
		} else {
			$string = '<img src="'.$userinfo["avatar"].'" width="'.$visitorvoiceConfig['avatar_dimensions'].'px" height="'.$visitorvoiceConfig['avatar_dimensions'].'px" alt="avatar" />';
		}
		$content = str_replace("{ENTRY_AVATAR}", $string, $content);
	} else {
		$content = str_replace("{ENTRY_AVATAR}", "", $content);
	}
	$content = str_replace("{ENTRY_ULINK}", $userinfo["link"], $content);
	$content = str_replace("{ENTRY_ENTRY}", $value['message'], $content);
	if($value['homepage'] !== "") {
		$content = str_replace("{ENTRY_URL}", '<a class="visitorvoice_url" href="'.$value['homepage'].'?&campaign=impresscms_visitorvoice" title="'.$value['homepage'].'">'.$value['homepage'].'</a> |', $content);
	} else {
		$content = str_replace("{ENTRY_URL}", '', $content);
	}
	if($value['approved'] !== "") {
		$admin_string = ($visitorvoice_isAdmin) ? '<a class="approve_link" original-id="'.$value['id'].'" title="'._MD_VISITORVOICE_APPROVE_NOW.'" href="'.VISITORVOICE_URL.'submit.php"><img class="icon_middle" src="'
						.VISITORVOICE_IMAGES_URL.'approved.png" alt="approve" /></a>' : '';
		$content = str_replace("{ENTRY_APPROVED}", '<div class="'.$value['approved'].'">'._MD_VISITORVOICE_AWAITING_APPROVAL.$admin_string.'</div>' , $content);
	} else {
		$content = str_replace("{ENTRY_APPROVED}", '' , $content);
	}
	if($visitorvoice_isAdmin) {
		$content = str_replace("{ENTRY_IP}", '<span class="visitorvoice_ip">'.$value['ip'].'</span>', $content);
	} else {
		$content = str_replace("{ENTRY_IP}", '', $content);
	}
	if($value['email']) {
		$content = str_replace("{ENTRY_MAIL}", '<div class="visitorvoice_email"><span>'.$value['email'].'</span></div>', $content);
	} else {
		$content = str_replace("{ENTRY_MAIL}", '', $content);
	}
	if($value['has_image']) {
		$content = str_replace("{ENTRY_IMG}", '<div class="visitorvoice_image"><span><a href="'.$value['img'].'" class="entry_img" rel="lightbox" title="'.$value['homepage'].'"><img class="visitorvoice_thumb" src="'
					.$value['thumb'].'" /></a></span></div>', $content);
	} else {
		$content = str_replace("{ENTRY_IMG}", "", $content);
	}
	$content = str_replace("{ENTRY_ID}", $value['id'], $content);
	$content = str_replace("{ENTRY_PDATE}", $value['published_on'], $content);
	$content = str_replace("{ENTRY_CLASS}", "parent_class", $content);
	
	if($value['hassub']) {
		$content .= '<div class="visitorvoice_replies">' ;
		foreach($value['sub'] as $key => $value) {
			$userinfo = $value['published_by'];
			$file = VISITORVOICE_ROOT_PATH.'templates/visitorvoice_singleentry.html';
			$content_rep = file_get_contents($file);
			$content_rep = str_replace("{ENTRY_TITLE}", $value['title'], $content_rep);
			if($value['visitorvoice_uid'] > 0) {
				$string1 = '<a class="visitorvoice_ulink" href="'.$userinfo["link"].'">'.$value['visitorvoice_name'].'</a>';
			} else {
				$string1 = $value['visitorvoice_name'];
			}
			$content_rep = str_replace("{ENTRY_NAME}", $string1, $content_rep);
			$content_rep = str_replace("{ENTRY_URL}", $value['homepage'], $content_rep);
			$content_rep = str_replace("{ENTRY_ULINK}", $userinfo["link"], $content_rep);
			$content_rep = str_replace("{ENTRY_ENTRY}", $value['message'], $content_rep);
			if($visitorvoice_isAdmin) {
				$content_rep = str_replace("{ENTRY_IP}", '<span class="visitorvoice_ip">'.$value['ip'].'</span>', $content_rep);
			} else {
				$content_rep = str_replace("{ENTRY_IP}", '', $content_rep);
			}
			if($value['email']) {
				$content_rep = str_replace("{ENTRY_MAIL}", '<div class="visitorvoice_email"><span>'.$value['email'].'</span></div>', $content_rep);
			} else {
				$content_rep = str_replace("{ENTRY_MAIL}", '', $content_rep);
			}
			if($value['has_image']) {
				$content_rep = str_replace("{ENTRY_IMG}", '<div class="visitorvoice_image"><span><a href="'.$value['img'].'" class="entry_img" rel="lightbox" title="'.$value['homepage'].'"><img class="visitorvoice_thumb" src="'
							.$value['thumb'].'" /></a></span></div>', $content_rep);
			} else {
				$content_rep = str_replace("{ENTRY_IMG}", "", $content_rep);
			}
			if($value['approved'] !== "") {
				$content_rep = str_replace("{ENTRY_APPROVED}", '<div class="'.$value['approved'].'"><p>'._MD_VISITORVOICE_AWAITING_APPROVAL.'</p></div>' , $content_rep);
			} else {
				$content_rep = str_replace("{ENTRY_APPROVED}", '' , $content_rep);
			}
			if($visitorvoiceConfig['show_avatar']) {
				if($value['visitorvoice_uid'] > 0) {
					$string = '<a class="visitorvoice_ulink" href="'.$userinfo["link"].'"><img src="'.$userinfo["avatar"].'" width="'.$visitorvoiceConfig['avatar_dimensions'].'px" height="'.$visitorvoiceConfig['avatar_dimensions'].'px" alt="avatar" /></a>';
				} else {
					$string = '<img src="'.$userinfo["avatar"].'" width="'.$visitorvoiceConfig['avatar_dimensions'].'px" height="'.$visitorvoiceConfig['avatar_dimensions'].'px" alt="avatar" />';
				}
				$content_rep = str_replace("{ENTRY_AVATAR}", $string, $content_rep);
			} else {
				$content_rep = str_replace("{ENTRY_AVATAR}", "", $content_rep);
			}
			$content_rep = str_replace("{ENTRY_ID}", $value['id'], $content_rep);
			$content_rep = str_replace("{ENTRY_PDATE}", $value['published_on'], $content_rep);
			$content_rep = str_replace("{ENTRY_CLASS}", "sub_class", $content_rep);
			$content .= $content_rep;
		}
		$content .= '</div>';
	}
	if($visitorvoice_handler->canModerate()) {
		$content .= '<div class="gb_reply_link"><a class="reply_link" original-id="'.$value['id'].'" href="'.VISITORVOICE_URL.'submit.php">'._MD_VISITORVOICE_REPLY.'</a></div>';
	}
	$reply[$key] = $content;
}
echo json_encode(array("reload" => $need_reload, "entries" => implode("&nbsp;", $reply)));