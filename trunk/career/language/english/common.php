<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /language/english/common.php
 * 
 * common language constants
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

// constants used throughout the module
define("_CO_CAREER_PREVIEW", "preview");
define("_CO_CAREER_EDIT", "edit");
if(!defined("_CO_SUBMIT")) define("_CO_SUBMIT", "submit");
define("_CO_CAREER_DELETE", "delete");
define("_CO_CAREER_VIEW", "view");
if(!defined("_NO_PERM")) define("_NO_PERM", "Sorry, you don't have permissions to access this area");
if(!defined("_ER_UP_UNKNOWNFILETYPEREJECTED")) define("_ER_UP_UNKNOWNFILETYPEREJECTED", "unknown Filetype");
define("_CO_CAREER_MESSAGE_REPLY", "Reply");
// constants used in career form
define("_CO_CAREER_CAREER_CAREER_TITLE", "Title");
define("_CO_CAREER_CAREER_CAREER_TITLE_DSC", "");
define("_CO_CAREER_CAREER_CAREER_DID", "Select the department");
define("_CO_CAREER_CAREER_CAREER_DID_DSC", "");
define("_CO_CAREER_CAREER_CAREER_SUMMARY", "Short Summary");
define("_CO_CAREER_CAREER_CAREER_SUMMARY_DSC", "Describe the Job using one or two sentences. This will be displayed in index view.");
define("_CO_CAREER_CAREER_CAREER_DESCRIPTION", "Description");
define("_CO_CAREER_CAREER_CAREER_DESCRIPTION_DSC", "Describe your job offering");
define("_CO_CAREER_CAREER_CAREER_REV_NUM", "Reference Number");
define("_CO_CAREER_CAREER_CAREER_REV_NUM_DSC", "This is your internal Reference number for this Job offering");
define("_CO_CAREER_CAREER_CAREER_CNAME", "Contact Name");
define("_CO_CAREER_CAREER_CAREER_CNAME_DSC", "Name of the contact person");
define("_CO_CAREER_CAREER_CAREER_UID", "Contact Users");
define("_CO_CAREER_CAREER_CAREER_UID_DSC", "Select the users to be notificated about new messages");
define("_CO_CAREER_CAREER_CAREER_CPOS", "Position");
define("_CO_CAREER_CAREER_CAREER_CPOS_DSC", "Position of the contact person");
define("_CO_CAREER_CAREER_CAREER_CTEL", "Phone number");
define("_CO_CAREER_CAREER_CAREER_CTEL_DSC", "Contact phone number");
define("_CO_CAREER_CAREER_CAREER_CFAX", "FAX");
define("_CO_CAREER_CAREER_CAREER_CFAX_DSC", "FAX number");
define("_CO_CAREER_CAREER_CAREER_CEMAIL", "Contact Mail");
define("_CO_CAREER_CAREER_CAREER_CEMAIL_DSC", "");
define("_CO_CAREER_CAREER_CAREER_KANTON", "Contact County");
define("_CO_CAREER_CAREER_CAREER_KANTON_DSC", "");
define("_CO_CAREER_CAREER_CAREER_CZIP", "ZIP Code");
define("_CO_CAREER_CAREER_CAREER_CZIP_DSC", "");
define("_CO_CAREER_CAREER_CAREER_CCITY", "City");
define("_CO_CAREER_CAREER_CAREER_CCITY_DSC", "");
define("_CO_CAREER_CAREER_CAREER_CADDRESS", "Address");
define("_CO_CAREER_CAREER_CAREER_CADDRESS_DSC", "Address");
define("_CO_CAREER_CAREER_CAREER_P_DATE", "Published on");
define("_CO_CAREER_CAREER_CAREER_P_DATE_DSC", "");
define("_CO_CAREER_CAREER_CAREER_U_DATE", "Updated on");
define("_CO_CAREER_CAREER_CAREER_U_DATE_DSC", "");
define("_CO_CAREER_CAREER_CAREER_SUBMITTER", "Submitted by");
define("_CO_CAREER_CAREER_CAREER_SUBMITTER_DSC", "");
define("_CO_CAREER_CAREER_CAREER_UPDATER", "Last updated by");
define("_CO_CAREER_CAREER_CAREER_UPDATER_DSC", "");
define("_CO_CAREER_CAREER_CAREER_ACTIVE", "Active?");
define("_CO_CAREER_CAREER_CAREER_ACTIVE_DSC", "");
define("_CO_CAREER_CAREER_WEIGHT", "Weight");

// PM for recieved Messages for any career
define("_CO_CAREER_CAREER_MESSAGE_BDY", "You have recieved a new message for the career/department below:");
define("_CO_CAREER_CAREER_MESSAGE_SBJ", "New Message awaiting for you");

// constants used in departments form
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_TITLE", "Title");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_TITLE_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_LOGO", "Logo");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_LOGO_DSC", "Select a department logo OR upload a new one");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_LOGO_UPL", "Logo upload");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_LOGO_UPL_DSC", "Upload a new Logo");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_SUMMARY", "Short Summary");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_SUMMARY_DSC", "Short Summary of the department. This will be shown in the index");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_DESCRIPTION", "Description");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_DESCRIPTION_DSC", "The Department Description will be shown in single Department view AND in single job offering view");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_LEADER", "Head of Department");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_LEADER_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_PHONE", "Phone");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_PHONE_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_FAX", "FAX");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_FAX_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_MAIL", "E-Mail");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_MAIL_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_ADDRESS", "Address");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_ADDRESS_DSC", "");

define("_CO_CAREER_DEPARTMENT_DEPARTMENT_KANTON", "County");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_KANTON_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_ZIPCODE", "Zip code");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_ZIPCODE_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_CITY", "City");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_CITY_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_SUBMITTER", "Submitted by");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_SUBMITTER_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_UPDATER", "Updated by");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_UPDATER_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_P_DATE", "Published on");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_P_DATE_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_U_DATE", "Last updated on");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_U_DATE_DSC", "");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_ACTIVE", "Active?");
define("_CO_CAREER_DEPARTMENT_DEPARTMENT_ACTIVE_DSC", "");
define("_CO_CAREER_DEPARTMENT_WEIGHT", "Weight");
// constants for editing indexpage
define("_CO_CAREER_INDEXPAGE_INDEX_HEADER", "Title");
define("_CO_CAREER_INDEXPAGE_INDEX_HEADER_DSC", " Set Title displayed in the index at frontend ");
define("_CO_CAREER_INDEXPAGE_INDEX_HEADING", "Description for Indexpage");
define("_CO_CAREER_INDEXPAGE_INDEX_HEADING_DSC", "  ");
define("_CO_CAREER_INDEXPAGE_INDEX_IMAGE", "Indeximage");
define("_CO_CAREER_INDEXPAGE_INDEX_IMAGE_DSC", " Set indeximage ");
define("_CO_CAREER_INDEXPAGE_INDEX_IMG_UPLOAD", " Upload new indeximage ");
define("_CO_CAREER_INDEXPAGE_INDEX_FOOTER", "footer on indexpage");
define("_CO_CAREER_INDEXPAGE_INDEX_FOOTER_DSC", " Set the footer displayed on Indexpage ");

// constants for message forms
define("_CO_CAREER_MESSAGE_MESSAGE_TITLE", "Title");
define("_CO_CAREER_MESSAGE_MESSAGE_TITLE_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_NAME", "Name");
define("_CO_CAREER_MESSAGE_MESSAGE_NAME_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_MAIL", "Mail");
define("_CO_CAREER_MESSAGE_MESSAGE_MAIL_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_PHONE", "Phone");
define("_CO_CAREER_MESSAGE_MESSAGE_PHONE_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_BODY", "Message");
define("_CO_CAREER_MESSAGE_MESSAGE_BODY_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_FILE", "Attach your Application");
define("_CO_CAREER_MESSAGE_MESSAGE_FILE_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_SUBMITTER", "Submitter");
define("_CO_CAREER_MESSAGE_MESSAGE_SUBMITTER_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_DATE", "Date");
define("_CO_CAREER_MESSAGE_MESSAGE_DATE_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_CID", "Career title");
define("_CO_CAREER_MESSAGE_MESSAGE_CID_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_DID", "Department");
define("_CO_CAREER_MESSAGE_MESSAGE_DID_DSC", "");
define("_CO_CAREER_MESSAGE_MESSAGE_APPROVE", "Possible?");
define("_CO_CAREER_MESSAGE_MESSAGE_FAVORITE", "Favorite?");
define("_CO_CAREER_MESSAGE_WEIGHT", "Weight");
// constants for /admin/message.php and /message.php
define("_CO_CAREER_MESSAGE_REJECTED", "Rejected");
define("_CO_CAREER_MESSAGE_POSSIBLE", "Possible");
define("_CO_CAREER_MESSAGE_NEUTRAL", "Neutral");
define("_CO_CAREER_MESSAGE_FAVORITE", "Favorite");