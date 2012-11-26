<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /language/german/admin.php
 *
 * German language constants used in admin section of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 * 
 */

// general usage
define("_AM_ALBUM_ONLINE", "Online");
define("_AM_ALBUM_OFFLINE", "Offline");
define("_AM_ALBUM_ADD", "Neu");
define("_AM_ALBUM_CREATE", "Ersteele neu");
// Requirements
define("_AM_ALBUM_REQUIREMENTS", "'Album' Requirements");
define("_AM_ALBUM_REQUIREMENTS_INFO", "We've reviewed your system, unfortunately it doesn't meet all the requirements needed for 'Album' to function. Below are the requirements needed.");
define("_AM_ALBUM_REQUIREMENTS_ICMS_BUILD", "'Album' requires at least ImpressCMS 1.3 final.");
define("_AM_ALBUM_REQUIREMENTS_SUPPORT", "Should you have any question or concerns, please visit our forums at <a href='http://community.impresscms.org/modules/newbb/viewforum.php?forum=9'>ImpressCMS Community</a>.");

// constants used in ACP
define("_AM_ALBUM_ALBUM_ADD", "Album hinzufügen");
define("_AM_ALBUM_ALBUM_CREATE", "Neues Album");
define("_AM_ALBUM_ALBUM_EDIT", "Bearbeite Album");
define("_AM_ALBUM_ALBUM_CLONE", "Klone Album");
define("_AM_ALBUM_ALBUM_CREATED", "Neues Album erfolgreich erstellt");
define("_AM_ALBUM_ALBUM_MODIFIED", "Album erfolgreich modifiziert");
define("_AM_ALBUM_ALBUM_WEIGHTS_UPDATED", "Gewichtung erfolgreich aktualisiert");
define("_AM_ALBUM_APPROVE_TRUE", "Album genehmigt");
define("_AM_ALBUM_APPROVE_FALSE", "Album abgelehnt");
define("_AM_ALBUM_INDEXPAGE_EDIT", "Bearbeite die Frontend-Indexseite");
define("_AM_ALBUM_INDEXPAGE_MODIFIED", "Indexseite erfolgreich modifiziert");
define("_AM_ALBUM_IMAGE_ADD", "Bild hinzufügen");
define("_AM_ALBUM_IMAGES_WEIGHTS_UPDATED", "Gewichtung der Bilder wurde erfolgreich aktualisiert");
define("_AM_ALBUM_IMAGES_ADDED", "Bild wurde erfolgreich zugefügt");
define("_AM_ALBUM_IMAGES_CREATED", "Image successfully submitted");
define("_AM_ALBUM_PREVIEW", "Vorschau");
define("_AM_ALBUM_ALBUM_VIEW", "Anschauen");
define("_AM_ALBUM_IMAGES_EDIT", "Bearbeiten");
define("_AM_ALBUM_IMAGES_MODIFIED", "Bilder erfolgreich bearbeitet");
define("_AM_ALBUM_ALBUM_INBLOCK_TRUE", "Album wird in Blöcken angezeigt");
define("_AM_ALBUM_ALBUM_INBLOCK_FALSE", "Album wird in Blöcken nicht angezeigt");
/**
 * added in 1.1
 */
define("_AM_ALBUM_PREMISSION_ALBUM_VIEW", "Berechtigung zum Sehen des Albums");
define("_AM_ALBUM_PREMISSION_IMAGES_SUBMIT", "Berechtigung, Bilder in das Album zu übermitteln");
define("_AM_ALBUM_WEIGHT_UPDATED", "Gewichtung wurde aktualisiert");
define("_AM_ALBUM_IMAGE_ONLINE", "Online");
define("_AM_ALBUM_IMAGE_OFFLINE", "Offline");
/**
 * added in 1.2
 */
// admin/batchupload.php
define("_AM_ALBUM_BATCHUPLOAD_ADD", "Batchupload");
define("_AM_ALBUM_BATCHUPLOAD_SEL_IMAGES", "Select images to add to the selected Album");
define("_AM_ALBUM_BATCHUPLOAD_IMG_DSC", "Set an image description for all images of the selected set.");
define("_AM_ALBUM_BATCHUPLOAD_NOALBUM", "No Album selected. Please select Album first.");
define("_AM_ALBUM_BATCHUPLOAD_URL_CAP", "Caption");
define("_AM_ALBUM_BATCHUPLOAD_URL_URL", "URL");
define("_AM_ALBUM_BATCHUPLOAD_URL_DSC", "Description");
define("_AM_ALBUM_BATCHUPLOAD_URL_TARGET", "Target");
define("_AM_ALBUM_BATCHUPLOAD_IMAGES", "Add images from batch folder");
define("_AM_ALBUM_BATCHUPLOAD_SELECT_SOURCE", "Select the source of your batchupload");
define("_AM_ALBUM_BATCHUPLOAD_ZIPUPL", "Add images from an zipfile to upload");
define("_AM_ALBUM_BATCHUPLOAD_UPLOAD_ZIP", "Upload a new zip file");
// admin/images.php
define("_AM_ALBUM_IMAGES_FIELDS_UPDATED", "Fields successfully updated.");
define("_AM_NO_ALBUM_FOUND", "Sorry, no Album found. Please create Album first.");
//index.php
define("_AM_ALBUM_INDEX", "Album Module - Overview");
define("_AM_ALBUM_INDEX_TOTAL", "Total Albums");
define("_AM_ALBUM_INDEX_INACTIVE_ALBUMS", "Inactive Albums");
define("_AM_ALBUM_INDEX_DENIED_ALBUMS", "Albums awaiting approval");
define("_AM_ALBUM_INDEX_TOTAL_IMAGES", "Total Images");
define("_AM_ALBUM_INDEX_INACTIVE_IMAGES", "Inactive Images");
define("_AM_ALBUM_INDEX_DENIED_IMAGES", "Images awaiting approval");
define("_AM_ALBUM_INDEX_TOTAL_MESSAGES", "Total image Comments");
define("_AM_ALBUM_INDEX_DENIED_MESSAGES", "Image comments awaiting approval");
define("_AM_ALBUM_INDEX_BATCHFILES", "Total files in Batch folder");
define("_AM_ALBUM_ADDITIONAL", "Additional Informations");
define("_AM_ALBUM_SITEMAP_MODULE", "Sitemap Module");
define("_AM_ALBUM_SITEMAP_INSTALLED", "Sitemap Module installed");
define("_AM_ALBUM_SITEMAP_NOTINSTALLED", "Sitemap Module not installed");
define("_AM_ALBUM_SITEMAP_PLUGIN_FOUND", "and album plugin found");
define("_AM_ALBUM_SITEMAP_PLUGIN_NOTFOUND", "and album plugin not found. Please update module or copy manually from '/modules/album/extras/modules/sitemap/' to '/modules/sitemap/plugins'");
define("_AM_ALBUM_INDEX_GDLIB", "GD-Library");
define("_AM_ALBUM_INDEX_GDLIB_FOUND", "It looks like GD lib is installed");
define("_AM_ALBUM_INDEX_GDLIB_NOT_FOUND", "It looks like GD is not installed. Please check this before using the module");