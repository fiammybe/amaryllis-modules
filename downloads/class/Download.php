<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /class/Download.php
 * 
 * Class representing Downloads download objects
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

class mod_downloads_Downloads extends icms_ipf_seo_Object {

	public function __construct(&$handler) {
		icms_ipf_object::__construct($handler);

		$this->quickInitVar('download_id', XOBJ_DTYPE_INT, true);
		$this->quickInitVar('download_title', XOBJ_DTYPE_TXTBOX, true);
		$this->initCommonVar('short_url');
		$this->quickInitVar('download_cid', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('download_description', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_file', XOBJ_DTYPE_FILE);
		$this->quickInitVar('download_img_1',XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('download_img_2',XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('download_img_3',XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('download_img_4',XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('download_mirror',XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_grpperm', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_active', XOBJ_DTYPE_INT);
		$this->quickInitVar('download_inblocks', XOBJ_DTYPE_INT);
		$this->quickInitVar('download_disclaimer', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_published_by', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_published_on', XOBJ_DTYPE_MTIME);
		$this->quickInitVar('download_updated_on', XOBJ_DTYPE_MTIME);
		$this->initCommonVar('weight');
		$this->initCommonVar('counter');
		$this->initCommonVar('dohtml', false, 1);
		$this->initCommonVar('dobr', true, 1);
		$this->initCommonVar('doimage', true, 1);
		$this->initCommonVar('dosmiley', true, 1);
		$this->initCommonVar('docxode', true, 1);
		// set controls
		$this->setControl('download_cid', array('name' => 'select_multi', 'itemhandler' => 'category', 'method' => 'getCategoryList', 'module' => 'downloadcenter');
		$this->setControl('download_description', 'dhtmltextarea');
		$this->setControl('download_download', 'textarea');
		$this->setControl('download_fields', 'textarea');
		$this->setControl('download_img_1','image');
		$this->setControl('download_img_2','image');
		$this->setControl('download_img_3','image');
		$this->setControl('download_img_4','image');
		$this->setControl('download_cgroup', 'group_multi');
		$this->setControl('download_cuser','user_multi');
		$this->setControl('download_grpperm', array('name' => 'select_multi', 'itemHandler' => 'downloads', 'method' => 'getGroups', 'module' => 'downloadcenter'));
		$this->setControl('download_active', 'yesno');
		$this->setControl('download_inblocks', 'yesno');
		$this->setControl('download_redirect', 'url');
		$this->setControl('download_store', array('name' => 'select', 'itemhandler' => 'downloads', 'method' => 'getdownloadsStore', 'module' => 'downloadcenter'));
		$this->setControl('download_publisched_by', 'user');
		// hide static fields from form
		$this->hideFieldFromForm(array('counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		// hide fields from single view
		$this->hideFieldFromSingleView(array('counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		// set some fields as requiered
		
		//make use of seo
		$this->initiateSEO();
	}
	
	public function getVar() {
		
	}
	
	public function getPublishedDate() {}
	
	public function getUpdatedDate() {}
	
	public function getPublisher() {}
	
	public function getImageTag() {}
	
	public function getDownloadTag() {}
	
	public function download_active() {}
	
	public function download_inblocks() {}
	
	public function download_uid() {}
	
	public function toArray() {}
	
	

}