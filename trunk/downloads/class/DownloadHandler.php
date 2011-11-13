<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /class/DownloadHandler.php
 * 
 * Classes responsible for managing Downloads download objects
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

class mod_downloads_DownloadHandler extends icms_ipf_Object {

	private $_download_grpperm = array();

	public function __construct(&$db) {
		parent::__construct($db, "download", "download_id", "download_title", "download_description", "downloads");
		$this->addPermission('download_grpperm', _CO_ALBUM_ALBUM_ALBUM_GRPPERM, _CO_ALBUM_ALBUM_ALBUM_GRPPERM_DSC);

		/**
		 *
		 * use icms mimetype handler to check, if the requested filetype is allowed
		 *
		 * @TODO if handler is finished, adjust function to this module
		 *
		 */
		$mimetypes = $this-> checkMimeType();
		$filesize = $downloads_category_handler -> $categoryObj -> getVar('category_allowed_filesize');
		$this->enableUpload($mimetypes,	$filesize);
	}
	
	
	/**
	 *
	 * use icms mimetype handler to check, if the requested filetype is allowed
	 *
	 * @TODO if category handler is finished, adjust function to this module
	 *
	 */

	public function checkMimeType() {
		global $icmsModule;
		$mimetypeHandler = icms_getModulehandler('mimetype', 'system');
		$modulename = (isset($icmsModule) && is_object($icmsModule)) ? $icmsModule->getVar('dirname') : 'system';
		if (empty($this->mediaRealType) && empty($this->allowUnknownTypes)) {
			self::setErrors(_ER_UP_UNKNOWNFILETYPEREJECTED);
			return false;
		}
		$AllowedMimeTypes = $mimetypeHandler->AllowedModules($this->mediaRealType, $modulename);
		if ((!empty($this->allowedMimeTypes) && !in_array($this->mediaRealType, $this->allowedMimeTypes))
				|| (!empty($this->deniedMimeTypes) && in_array($this->mediaRealType, $this->deniedMimeTypes))
				|| (empty($this->allowedMimeTypes) && !$AllowedMimeTypes))
			{
			self::setErrors(sprintf(_ER_UP_MIMETYPENOTALLOWED, $this->mediaType));
			return false;
		}
		return true;
	}





}