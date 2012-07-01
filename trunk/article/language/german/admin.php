<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /language/english/admin.php
 * 
 * english language constants
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// Requirements
define("_AM_ARTICLE_REQUIREMENTS", "Article Voraussetzungen");
define("_AM_ARTICLE_REQUIREMENTS_INFO", "Eine Überprüfung Ihres Systems ergab, das leider nicht alle Vorraussetzungen für 'Articles' erfüllt sind, um ein Funktionieren zu garantieren. Unten stehen die benötigten Voraussetzungen.");
define("_AM_ARTICLE_REQUIREMENTS_ICMS_BUILD", "Article benötigt mindestens ImpressCMS 1.3.");
define("_AM_ARTICLE_REQUIREMENTS_SUPPORT", "Sollten sie Fragen oder Bedenken haben, besuchen Sie bitte unser Forum unter <a href='http://impresscms.de/modules/forum/'>ImpressCMS.DE Community</a>.");
// constants for /admin/article.php
define("_AM_ARTICLE_ARTICLE_ADD", "Artikel hinzufügen");
define("_AM_ARTICLE_ARTICLE_EDIT", "Artikel bearbeiten");
define("_AM_ARTICLE_ARTICLE_CREATE", "Erstelle einen neuen Artikel");
define("_AM_ARTICLE_ARTICLE_CREATED", "Artikel erfolgreich eingereicht");
define("_AM_ARTICLE_ARTICLE_MODIFIED", "Artikel erfolgreich bearbeitet");
define("_AM_ARTICLE_ARTICLE_OFFLINE", "Artikel offline");
define("_AM_ARTICLE_ARTICLE_ONLINE", "Artikel online");
define("_AM_ARTICLE_ARTICLE_INBLOCK_TRUE", "Artikel sichtbar in Blöcken");
define("_AM_ARTICLE_ARTICLE_INBLOCK_FALSE", "Artikel unsichtbar in Blöcken");
define("_AM_ARTICLE_ARTICLE_APPROVED", "Artikel genehmigt");
define("_AM_ARTICLE_ARTICLE_DENIED", "Article abgelehnt");
define("_AM_ARTICLE_ARTICLE_WEIGHTS_UPDATED", "Gewichtung wurde erfolgreich bearbeitet");
define("_AM_ARTICLE_NO_CAT_FOUND", "Keine Kategorie gefunden");
// constants for admin/category.php
define("_AM_ARTICLE_CATEGORY_ADD", "Kategorie hinzufügen");
define("_AM_ARTICLE_CATEGORY_EDIT", "Kategorie bearbeiten");
define("_AM_ARTICLE_CATEGORY_CREATE", "Erstelle eine neue Kategorie");
define("_AM_ARTICLE_CATEGORY_CREATED", "Kategorie erfolgreich eingereicht");
define("_AM_ARTICLE_CATEGORY_MODIFIED", "Kategorie erfolgreich bearbeitet");
define("_AM_ARTICLE_CATEGORY_OFFLINE", "Kategorie offline");
define("_AM_ARTICLE_CATEGORY_ONLINE", "Kategorie online");
define("_AM_ARTICLE_CATEGORY_INBLOCK_TRUE", "Kategorie sichtbar in Blöcken");
define("_AM_ARTICLE_CATEGORY_INBLOCK_FALSE", "Kategorie unsichtbar in Blöcken");
define("_AM_ARTICLE_CATEGORY_APPROVED", "Kategorie genehmigt");
define("_AM_ARTICLE_CATEGORY_DENIED", "Kategorie abgelehnt");
define("_AM_ARTICLE_CATEGORY_WEIGHTS_UPDATED", "Gewichtung wurde erfolgreich bearbeitet");

// constants for /admin/indexpage.php
define("_AM_ARTICLE_INDEXPAGE_EDIT", "Bearbeite die Indexpage");
define("_AM_ARTICLE_INDEXPAGE_MODIFIED", "Indexpage bearbeitet");

//constants for admin/index.php
define("_AM_ARTICLE_INDEX_WARNING", "Bitte lesen Sie die Anleitung, bevor sie Articles benutzen");
define("_AM_ARTICLE_INDEX_TOTAL", "Gesamt");
define("_AM_ARTICLE_FILES_IN", " Dateien in ");
define("_AM_ARTICLE_CATEGORIES", " Kategorien");
define("_AM_ARTICLE_INDEX_BROKEN_FILES", "Defekte Dateianhänge");
define("_AM_ARTICLE_INDEX_NEED_APPROVAL_FILES", "Dateien, welche genehmigt werden müssen");
define("_AM_ARTICLE_INDEX_NEED_APPROVAL_CATS", "Kategorien, welche genehmigt werden müssen");
define("_AM_ARTICLE_INDEX", "Article Index");
// constants for permission Form
define("_AM_ARTICLE_PREMISSION_ARTICLE_VIEW", "Zeige Artikel");
define("_AM_ARTICLE_PREMISSION_CATEGORY_VIEW", "Zeige Kategorien");
define("_AM_ARTICLE_PREMISSION_CATEGORY_SUBMIT", "Artikel einreichen");
// import site
define("_AM_ARTICLE_IMPORT_SMARTSECTION_WARNING", "Please handle carefully! You should have a clean updated ImpressCMS 1.3.x site.<br />
Please beware, that you don't have used 'Downloads'-Module before and you don't have created articles/files/categories!<br />
If you already have used old tags module, note that you first need to import tags to sprockets.");