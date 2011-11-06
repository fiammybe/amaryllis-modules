<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /include/functions.php
 *
 * several functions used by album module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 * 
 */

//generates the Album admin menu in ACP
function album_adminmenu( $currentoption = 0, $header = '', $menu = '', $extra = '', $scount = 5 ) {
	icms::$module -> displayAdminMenu( $currentoption, icms::$module -> getVar( 'name' ) . ' | ' . $header );
	echo '<h3 style="color: #2F5376;">' . $header . '</h3>';
}

function album_getModuleName($withLink = true, $forBreadCrumb = false, $moduleName = false) {
	$albumModule = icms_getModuleInfo( basename(dirname(dirname(__FILE__))) );
	$albumname = $albumModule -> getVar( "name" );
	if (!$moduleName) {
		$albumModule = icms_getModuleInfo( icms::$module -> getVar( 'dirname' ) );
		$moduleName = $albumModule -> getVar( 'dirname' );
	}
	$icmsModuleConfig = icms_getModuleConfig($moduleName);
	if (!isset ($albumModule)) {
		return '';
	}
	if (!$withLink) {
		return $albumModule->name();
	} else {
		$ret = ICMS_URL . '/modules/' . $moduleName . '/';
		return '<a href="' . $ret . '" title="' . $albumname .  '">' . $albumname . '</a>';
	}
}

function prepareIndexpageForDisplay($indexpageObj, $with_overrides = true) {
	global $albumConfig;
	$indexpageArray = array();
	if ($with_overrides) {
		$indexpageArray = $indexpageObj->toArray();
	} else {
		$indexpageArray = $indexpageObj->toArrayWithoutOverrides();
	}
	// create an image tag for the indeximage
	$indexpageArray['indeximage'] = $indexpageObj->get_indeximage_tag();
	return $indexpageArray;
}

