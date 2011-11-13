<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /class/CategoryHandler.php
 * 
 * Classes responsible for managing Downloads category objects
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


class mod_downloads_CategoryHandler extends icms_ipf_category_Handler {

	private $_category_grpperm = array();

	public function __construct($db) {
		parent::__construct($db, 'category', 'category_id', 'category_title', 'category_description', 'download');
		$this->addPermission('category_grpperm', _CO_DOWNLOADS_CATEGORY_CATEGORY_GRPPERM, _CO_DOWNLOADS_CATEGORY_CATEGORY_GRPPERM_DSC);
		
	}
	
	public function getCategoryListForPid($groups = array(), $perm = 'category_grpperm', $status = null, $category_id = null, $showNull = true) {
	
		$criteria = new icms_db_criteria_Compo();
		if (is_array($groups) && !empty($groups)) {
			$criteriaTray = new icms_db_criteria_Compo();
			foreach($groups as $gid) {
				$criteriaTray->add(new icms_db_criteria_Item('gperm_groupid', $gid), 'OR');
			}
			$criteria->add($criteriaTray);
			if ($perm == 'category_grpperm' || $perm == 'downloads_admin') {
				$criteria->add(new icms_db_criteria_Item('gperm_name', $perm));
				$criteria->add(new icms_db_criteria_Item('gperm_modid', 1));
			}
		}
		if (isset($status)) {
			$criteria->add(new icms_db_criteria_Item('category_active', true));
		}
		if (is_null($category_id)) $category_id = 0;
		$criteria->add(new icms_db_criteria_Item('category_pid', $category_id));
		$categories = & $this->getObjects($criteria, true);
		$ret = array();
		if ($showNull) {
			$ret[0] = '-----------------------';
		}
		foreach(array_keys($categories) as $i) {
			$ret[$i] = $categories[$i]->getVar('category_title');
			$subcategories = $this->getCategoryListForPid($groups, $perm, $status, $categories[$i]->getVar('category_id'), $showNull);
			foreach(array_keys($subcategories) as $j) {
				$ret[$j] = '-' . $subcategories[$j];
			}
		}
		return $ret;
	}
	
	public function getLatestCategoryForBlocks($start = 0, $limit = 0, $order = 'weight', $sort = 'ASC') {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('category_active', true));
		$criteria->add(new icms_db_criteria_Item('category_inblocks', true));
	
		$criteria->setStart(0);
		$criteria->setLimit($limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		$categories = $this->getObjects($criteria, true, false);
		$ret = array();
		foreach ($categories as $key => &$category){
			if ($category['accessgranted']){
				$ret[$category['category_id']] = $category;
			}
		}
		return $ret;
	}
	
	//set category online/offline
	public function changeVisible($category_id) {
		$visibility = '';
		$categoryObj = $this->get($category_id);
		if ($categoryObj->getVar('category_active', 'e') == true) {
			$categoryObj->setVar('category_active', 0);
			$visibility = 0;
		} else {
			$categoryObj->setVar('category_active', 1);
			$visibility = 1;
		}
		$this->insert($categoryObj, true);
		return $visibility;
	}
	
	// show/hide category in Block
	public function changeShow($category_id) {
		$show = '';
		$categoryObj = $this->get($category_id);
		if ($categoryObj->getVar('category_inblocks', 'e') == true) {
			$categoryObj->setVar('category_inblocks', 0);
			$show = 0;
		} else {
			$categoryObj->setVar('category_inblocks', 1);
			$show = 1;
		}
		$this->insert($categoryObj, true);
		return $show;
	}
	
	// count sub-categories
	public function getCategorySubCount($category_id = 0) {
		$criteria = $this->getCategoryCriteria();
		$criteria->add(new icms_db_criteria_Item('category_pid', $category_id));
		return $this->getCount($criteria);
	}
	
	// call sub-categories
	public function getCategorySub($category_id = 0, $toarray=false) {
		$criteria = $this->getcategoriesCriteria();
		$criteria->add(new icms_db_criteria_Item('category_pid', $category_id));
		$criteria->add(new icms_db_criteria_Item('category_active', true ) );
		$categories = $this->getObjects($criteria);
		if (!$toarray) return $categories;
		$ret = array();
		foreach(array_keys($categories) as $i) {
			if ($categories[$i]->accessGranted()){
				$ret[$i] = $categories[$i]->toArray();
				$ret[$i]['category_description'] = icms_core_DataFilter::icms_substr(icms_cleanTags($categories[$i]->getVar('category_description','n'),array()),0,300);
			}
		}
		return $ret;
	}
	
	public function category_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	
	public function category_inblocks_filter() {
		return array(0 => 'Hidden', 1 => 'Visible');
	}
	
	static public function getImageList() {
		$categoryimages = array();
		$categoryimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/uploads/' . icms::$module -> getVar( 'dirname' ) . '/categoryimages/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($categoryimages) as $i ) {
			$ret[$i] = $categoryimages[$i];
		}
		return $ret;
	}

	public function getGroups($criteria = null) {
		if (!$this->_category_grpperm) {
			$member_handler =& icms::handler('icms_member');
			$groups = $member_handler->getGroupList($criteria, true);
			return $groups;
		}
		return $this->_category_grpperm;
	}

}
	