<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /class/Category.php
 * 
 * Class representing Download category objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

class mod_download_Category extends icms_ipf_category_Object {

	public function __construct(&$handler) {
		icms_ipf_category_object::__construct($handler);
		
		$this->quickInitVar('category_cid', XOBJ_DTYPE_INT, true);
		$this->quickInitVar('category_title', XOBJ_DTYPE_TXTBOX, true);
		$this->quickInitVar('category_pid', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('category_img', XOBJ_DTYPE_TXTBOX);
		
		$this->initVar('category_upload_section', XOBJ_DTYPE_SECTIONOPEN);
		$this->quickInitVar('category_img_upload', XOBJ_DTYPE_FILE);
		
		$this->quickInitVar('category_description', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('category_active', XOBJ_DTYPE_INT);
		$this->quickInitVar('category_inblocks',XOBJ_DTYPE_INT);
		$this->quickInitVar('category_grpperm', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_uplperm', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_published_on', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('category_updated_on', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('category_publisher', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_direct_downl', XOBJ_DTYPE_INT);
		$this->initCommonVar('weight');
		$this->initCommonVar('counter');
		$this->initCommonVar('dohtml', false, 1);
		$this->initCommonVar('dobr', true, 1);
		$this->initCommonVar('doimage', true, 1);
		$this->initCommonVar('dosmiley', true, 1);
		$this->initCommonVar('docxode', true, 1);
		// set controls
		$this->setControl('category_pid', array( 'name' => 'select', 'itemhandler' => 'category', 'method' => 'getCategoryListForPid', 'module' => 'downloads'));
		$this->setControl('category_description', 'dhtmltextarea');
		$this->setControl('category_active', 'yesno');
		$this->setControl('category_inblocks', 'yesno');
		$this->setControl('category_grpperm', array('name' => 'select_multi', 'itemhandler' => $this->_handler, 'method' => 'getGroups', 'module' => 'downloads'));
		$this->setControl('category_uplperm', array('name' => 'select_multi', 'itemhandler' => $this->_handler, 'method' => 'getGroups', 'module' => 'downloads'));
		$this->setControl('category_publisher', 'user');
		// hide static fields from form
		$this->hideFieldFromForm(array('counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		// hide fields from single view
		$this->hideFieldFromSingleView(array('counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
	}

}
		