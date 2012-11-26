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
define("_AM_ALBUM_BATCHUPLOAD_ADD", "Stapelverarbeitung");
define("_AM_ALBUM_BATCHUPLOAD_SEL_IMAGES", "Wähle die hinzuzufügenden Bilder");
define("_AM_ALBUM_BATCHUPLOAD_IMG_DSC", "Setze eine allgemeine Beschreibung der gewählten Bilder");
define("_AM_ALBUM_BATCHUPLOAD_NOALBUM", "Kein Album ausgewählt. Bitte wählen Sie ein Album als Ziel");
define("_AM_ALBUM_BATCHUPLOAD_URL_CAP", "Beschriftung");
define("_AM_ALBUM_BATCHUPLOAD_URL_URL", "URL");
define("_AM_ALBUM_BATCHUPLOAD_URL_DSC", "Beschreibung");
define("_AM_ALBUM_BATCHUPLOAD_URL_TARGET", "Ziel");
define("_AM_ALBUM_BATCHUPLOAD_IMAGES", "Bilder aus dem Ordner 'batch'");
define("_AM_ALBUM_BATCHUPLOAD_SELECT_SOURCE", "Wählen Sie die quelle der Stapelverarbeitung");
define("_AM_ALBUM_BATCHUPLOAD_ZIPUPL", "Füge Bilder von einem Zip hinzu");
define("_AM_ALBUM_BATCHUPLOAD_UPLOAD_ZIP", "Wählen Sie das Zip");
// admin/images.php
define("_AM_ALBUM_IMAGES_FIELDS_UPDATED", "Felder erfolgreich aktualisiert");
//index.php
define("_AM_ALBUM_INDEX", "Album Modul - Übersicht");
define("_AM_ALBUM_INDEX_TOTAL", "Alben insgesamt");
define("_AM_ALBUM_INDEX_INACTIVE_ALBUMS", "Inaktive Alben");
define("_AM_ALBUM_INDEX_DENIED_ALBUMS", "auf Genehmigung wartende Alben");
define("_AM_ALBUM_INDEX_TOTAL_IMAGES", "Bilder insgesamt");
define("_AM_ALBUM_INDEX_INACTIVE_IMAGES", "Inaktive Bilder");
define("_AM_ALBUM_INDEX_DENIED_IMAGES", "auf Genehmigung wartende Bilder");
define("_AM_ALBUM_INDEX_TOTAL_MESSAGES", "Bild-Kommentare insgesamt");
define("_AM_ALBUM_INDEX_DENIED_MESSAGES", "auf Genehmigung wartende Bild-Kommentare");
define("_AM_ALBUM_INDEX_BATCHFILES", "Dateien insgesamt im 'batch' Ordner");
define("_AM_ALBUM_ADDITIONAL", "Zusätzliche Informationen");
define("_AM_ALBUM_SITEMAP_MODULE", "Sitemap Modul");
define("_AM_ALBUM_SITEMAP_INSTALLED", "Sitemap Module ist installiert");
define("_AM_ALBUM_SITEMAP_NOTINSTALLED", "Sitemap Modul ist nicht installiert");
define("_AM_ALBUM_SITEMAP_PLUGIN_FOUND", "und Album Plugin wurde gefunden");
define("_AM_ALBUM_SITEMAP_PLUGIN_NOTFOUND", "und Album Plugin wurde nicht gefunden. Bitte aktualisieren Sie das Modul oder kopieren Sie das Plugin von Hand von '/modules/icmspoll/extras/modules/sitemap/' nach '/modules/sitemap/plugins'");
define("_AM_ALBUM_INDEX_GDLIB", "GD-Library");
define("_AM_ALBUM_INDEX_GDLIB_FOUND", "Es sieht so aus als wäre die GD-Library installiert");
define("_AM_ALBUM_INDEX_GDLIB_NOT_FOUND", "Es sieht so aus als wäre die GD-Library nicht installiert. Bitte überprüfen Sie das vor der Nutzung des Moduls");