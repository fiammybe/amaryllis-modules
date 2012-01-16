<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /include/onupdate.inc.php
 * 
 * File holding functions used by the module installation
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

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");
icms_loadLanguageFile('downloads', 'common');
// this needs to be the latest db version
define('DOWNLOADS_DB_VERSION', 1);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// AUTHORIZING MOST NEEDED FILETYPES IN SYSTEM
function downloads_authorise_mimetypes() {
	$dirname = icms::$module -> getVar( 'dirname' );
	$extension_list = array(
		"png",
		"gif",
		"jpg",
		"zip",
		"jpeg",
		"pdf",
		"bmp"
		
	);
	$system_mimetype_handler = icms_getModuleHandler('mimetype', 'system');
	foreach ($extension_list as $extension) {
		$allowed_modules = array();
		$mimetypeObj = '';

		$criteria = new icms_db_criteria_Compo();
		$criteria->add( new icms_db_criteria_Item('extension', $extension));
		$mimetypeObj = array_shift($system_mimetype_handler->getObjects($criteria));

		if ($mimetypeObj) {
			$allowed_modules = $mimetypeObj->getVar('dirname');
			if (empty($allowed_modules)) {
				$mimetypeObj->setVar('dirname', $dirname);
				$mimetypeObj->store();
			} else {
				if (!in_array($dirname, $allowed_modules)) {
					$allowed_modules[] = $dirname;
					$mimetypeObj->setVar('dirname', $allowed_modules);
					$mimetypeObj->store();
				}
			}
		}
	}
}

function full_copy( $source, $target )
    {
        if ( is_dir( $source ) )
        {
            @mkdir( $target );
           
            $d = dir( $source );
           
            while ( FALSE !== ( $entry = $d->read() ) )
            {
                if ( $entry == '.' || $entry == '..' )
                {
                    continue;
                }
               
                $Entry = $source . '/' . $entry;           
                if ( is_dir( $Entry ) )
                {
                    full_copy( $Entry, $target . '/' . $entry );
                    continue;
                }
                copy( $Entry, $target . '/' . $entry );
            }
           
            $d->close();
        }else
        {
            copy( $source, $target );
        }
    }  

function downloads_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$path = ICMS_ROOT_PATH . '/uploads/downloads';
		icms_core_Filesystem::mkdir($path . '/categoryimages');
		$categoryimages = array();
		$categoryimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/modules/downloads/images/folders/', '', array('gif', 'jpg', 'png'));
		foreach($categoryimages as $image) {
			icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/folders/' . $image, $path . '/categoryimages/' . $image);
		}
		icms_core_Filesystem::mkdir($path . '/indeximages');
		$image = 'downloads_indeximage.png';
		icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/' . $image, $path . '/indeximages/' . $image);
		return TRUE;
}

function downloads_indexpage() {
	$downloads_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'downloads' );
	$indexpageObj = $downloads_indexpage_handler -> create(true);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'Shared Files');
	$indexpageObj->setVar('index_heading', 'Here you can search our shared files.');
	$indexpageObj->setVar('index_footer', '&copy; 2011 | Downloads module footer');
	$indexpageObj->setVar('index_image', 'downloads_indeximage.png');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
	$downloads_indexpage_handler -> insert( $indexpageObj, true );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully imported!<br />';
	echo '</code>';
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// UPDATE DOWNLOADS MODULE ///////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function icms_module_update_downloads($module) {
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_downloads($module) {
	// check if upload directories exist and make them if not
	downloads_upload_paths();
	
	// authorise some audio mimetypes for convenience
	downloads_authorise_mimetypes();
	
	//prepare indexpage
	downloads_indexpage();

	return TRUE;
}