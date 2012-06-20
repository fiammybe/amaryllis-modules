<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /language/english/icms_version.php
 * 
 * english modinfo language file
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

define("_MI_ICMSPOLL_MD_NAME", "Polls");
define("_MI_ICMSPOLL_MD_DSC", "'Icmspoll' is a poll module for ImpressCMS and iforum. This means, it can work as a standalone poll module or can be integrated in iforum to provide polls in forum.");

/**
 * module preferences
 */
define("_MI_ICMSPOLL_CONFIG_DATE_FORMAT", "Date Format");
define("_MI_ICMSPOLL_CONFIG_DATE_FORMAT_DSC", "");
define("_MI_ICMSPOLL_CONFIG_LIMITBYIP", "Restricted by IP");
define("_MI_ICMSPOLL_CONFIG_LIMITBYIP_DSC", "");
define("_MI_ICMSPOLL_CONFIG_LIMITBYUID", "Restricted by user");
define("_MI_ICMSPOLL_CONFIG_LIMITBYUID_DSC", "");
//define("", "");

/**
 * module Templates
 */
define("_MI_ICMSPOLL_TPL_INDEX", "Icmspoll indexview");
define("_MI_ICMSPOLL_TPL_HEADER", "Header file included in frontend");
define("_MI_ICMSPOLL_TPL_FOOTER", "Footer File Included in Frontend");
define("_MI_ICMSPOLL_TPL_POLLS", "Poll loop in index view");
define("_MI_ICMSPOLL_TPL_SINGLEPOLL", "Display a single poll");
define("_MI_ICMSPOLL_TPL_RESULTS", "Display Poll result");
define("_MI_ICMSPOLL_TPL_FORMS", "Forms for create/delete polls in frontend");
define("_MI_ICMSPOLL_TPL_ADMIN_FORM", "ACP Template");
define("_MI_ICMSPOLL_TPL_REQUIREMENTS", "Requirements check");

/**
 * module blocks
 */
define("_MI_ICMSPOLL_BLOCK_RECENT_POLLS", "Recent Polls");
define("_MI_ICMSPOLL_BLOCK_RECENT_POLLS_DSC", "Display a list of recent polls");
define("_MI_ICMSPOLL_BLOCK_SINGLE_POLL", "Single Poll");
define("_MI_ICMSPOLL_BLOCK_SINGLE_POLL_DSC", "Display a single poll");
define("_MI_ICMSPOLL_BLOCK_RECENT_RESULTS", "Recent Results");
define("_MI_ICMSPOLL_BLOCK_RECENT_RESULTS_DSC", "Display recent results");
define("_MI_ICMSPOLL_BLOCK_SINGLE_RESULT", "Single Result");
define("_MI_ICMSPOLL_BLOCK_SINGLE_RESULT_DSC", "Display single result");