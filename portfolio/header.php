<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /header.php
 * 
 * header file included in frontend
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

include_once "../../mainfile.php";
include_once ICMS_ROOT_PATH . '/modules/'.icms::$module->getVar('dirname').'/include/common.php';

// Include the main language file of the module
icms_loadLanguageFile('portfolio', 'main');

$name = is_object(icms::$user) ? icms::$user->getVar("name") : "";
$mail = is_object(icms::$user) ? icms::$user->getVar("email") : "";

$form = new icms_form_Theme(_MD_PORTFOLIO_ADD_CONTACT, "addcontact", "submit.php", "post");
$form->addElement(new icms_form_elements_Text(_CO_PORTFOLIO_CONTACT_CONTACT_TITLE, "contact_title", 70, 255, ""), TRUE);
$form->addElement(new icms_form_elements_Text(_CO_PORTFOLIO_CONTACT_CONTACT_NAME, "contact_name", 70, 255, $name), TRUE);
$form->addElement(new icms_form_elements_Text(_CO_PORTFOLIO_CONTACT_CONTACT_MAIL, "contact_mail", 70, 255, $mail), TRUE);
$form->addElement(new icms_form_elements_Text(_CO_PORTFOLIO_CONTACT_CONTACT_PHONE, "contact_phone", 70, 255, ""), TRUE);
$form->addElement(new icms_form_elements_Textarea(_CO_PORTFOLIO_CONTACT_CONTACT_BODY, "contact_body"));
$form->addElement(new icms_form_elements_Captcha());
$form->addElement(new icms_form_elements_Hidden("op", "addcontact"));