<?php
/**
 * English language constants related to module information
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		guestbook
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_GUESTBOOK_NAME", "G&auml;stebuch");
define("_MI_GUESTBOOK_DSC", "Einfaches G&auml;stebuchmodul f&Uuml;r ImpressCMS ");
// Templates
define("_MI_GUESTBOOK_GUESTBOOK_TPL", "G&auml;stebuch Index Seite");
define("_MI_GUESTBOOK_ADMIN_TPL", "G&auml;stebuch admin Template");
define("_MI_GUESTBOOK_REQUIREMENTS_TPL", "G&auml;stebuch Anforderungen");
// Blocks
define("_MI_GUESTBOOK_BLOCK_RECENT_ENTRIES", "Letzte Eintr&auml;ge");
define("_MI_GUESTBOOK_BLOCK_RECENT_ENTRIES_DSC", "Letzte Eintr&auml;ge im Block anzeigen");
// Config
define("_MI_GUESTBOOK_DATE_FORMAT", "Datumsformat");
define("_MI_GUESTBOOK_DATE_FORMAT_DSC", "Sie k&ouml;nnen das Datumsformat einstellen wie Sie es w&uuml;nschen. z.B. d/m/Y H:i");
define("_MI_GUESTBOOK_SHOW_BREADCRUMBS", "Zeige Breadcrumb Navigation");
define("_MI_GUESTBOOK_SHOW_BREADCRUMBS_DSC", "zeigen/ausblenden der Breadcrumb Navigation im Frontend");
define("_MI_GUESTBOOK_SHOW_ENTRIES", "Anzahl der Eintr&auml;ge im Frontend");
define("_MI_GUESTBOOK_SHOW_ENTRIES_DSC", "Wie viele Eintr&auml;ge sollen im Frontend angezeicgt werden?");
define("_MI_GUESTBOOK_USE_MODERATION", "Eintr&auml;ge kommentieren");
define("_MI_GUESTBOOK_USE_MODERATION_DSC", "M&ouml;chten Sie Eintr&auml;ge kommentieren?");
define("_MI_GUESTBOOK_CAN_MODERATE", "Welche Grupppen d&uuml;rfen kommentieren?");
define("_MI_GUESTBOOK_CAN_MODERATE_DSC", "");
define("_MI_GUESTBOOK_AVATAR_DIMENSIONS", "Bildgr&ouml;sse Avatar in px");
define("_MI_GUESTBOOK_AVATAR_DIMENSIONS_DSC", "");
define("_MI_GUESTBOOK_SHOW_AVATAR", "Zeige Avatar in Frontend");
define("_MI_GUESTBOOK_SHOW_AVATAR_DSC", "");
define("_MI_GUESTBOOK_NEEDS_APPROVAL", "G&auml;stebuch moderieren?");
define("_MI_GUESTBOOK_NEEDS_APPROVAL_DSC", "Eintr&auml;ge vor dem Ver&ouml;ffentlichen freischalten");
define("_MI_GUESTBOOK_ALLOW_IMAGEUPLOAD", "Bilderupload erlauben?");
define("_MI_GUESTBOOK_ALLOW_IMAGEUPLOAD_DSC", "");
define("_MI_GUESTBOOK_CAN_UPLOAD", "Welche Gruppen d&uuml;rfen Bilder hochladen?");
define("_MI_GUESTBOOK_CAN_UPLOAD_DSC", "");
define("_MI_GUESTBOOK_IMAGE_UPLOAD_WIDTH", "Maximale zul&auml;ssige Bildbreite f&uuml;r Upload");
define("_MI_GUESTBOOK_IMAGE_UPLOAD_WIDTH_DSC", "");
define("_MI_GUESTBOOK_IMAGE_UPLOAD_HEIGHT", "Maximale zul&auml;ssige Bildh&ouml;he f&uuml;r Upload");
define("_MI_GUESTBOOK_IMAGE_UPLOAD_HEIGHT_DSC", "");
define("_MI_GUESTBOOK_IMAGE_FILE_SIZE", "Maximal zul&auml;ssige Dateigr&ouml;sse");
define("_MI_GUESTBOOK_IMAGE_FILE_SIZE_DSC", "");
define("_MI_GUESTBOOK_THUMBNAIL_WIDTH", "Breite des Vorschaubildes");
define("_MI_GUESTBOOK_THUMBNAIL_WIDTH_DSC", "");
define("_MI_GUESTBOOK_THUMBNAIL_HEIGHT", "H&ouml;he des Vorschaubildes");
define("_MI_GUESTBOOK_THUMBNAIL_HEIGHT_DSC", "");
define("_MI_GUESTBOOK_DISPLAY_WIDTH", "Breite der Lightbox");
define("_MI_GUESTBOOK_DISPLAY_WIDTH_DSC", "");
define("_MI_GUESTBOOK_DISPLAY_HEIGHT", "H&ouml;he der Lightbox");
define("_MI_GUESTBOOK_DISPLAY_HEIGHT_DSC", "");
define("_MI_GUESTBOOK_GUEST_CAN_SUBMIT", "G&auml;ste k&ouml;nnen Einträge schreiben");
define("_MI_GUESTBOOK_GUEST_CAN_SUBMIT_DSC", "");
define("_MI_GUESTBOOK_SHOW_EMAIL", "Anzeige der E-Mail Adresse im Frontend?");
define("_MI_GUESTBOOK_SHOW_EMAIL_DSC", "zeigen/ausblenden der E-Mail Adresse im Fronted");
define("_MI_GUESTBOOK_DISPLAY_EMAIL", "E-Mail Spamschutz");
define("_MI_GUESTBOOK_DISPLAY_EMAIL_DSC", "Die Pr&uuml;fung gegen die Sperrliste wird nicht empfohlen.. filtert fast alles raus.");
define("_MI_GUESTBOOK_DISPLAY_MAIL_SPAMPROT", "E-Mail direkt - keine Pr&uuml;fung der Blacklist");
define("_MI_GUESTBOOK_DISPLAY_MAIL_IMGPROT", "E-Mail direkt - mit Pr&uuml;fung der Sperrliste");
define("_MI_GUESTBOOK_DISPLAY_MAIL_SPAMPROT_BANNED", "E-Mail als example at e-mail dot com - keine Pr&uuml;fung der Sperrliste");
define("_MI_GUESTBOOK_DISPLAY_MAIL_IMGPROT_BANNED", "E-Mail als example at e-mail dot com - mit Pr&uuml;fung der Sperrliste");
define("_MI_GUESTBOOK_USE_RSS", "RSS Feeds");
define("_MI_GUESTBOOK_USE_RSS_DSC", "ein/ausschalten RSS Feeds für das G&auml;stebuch");
define("_MI_GUESTBOOK_RSSLIMIT", "RSS Limit");
define("_MI_GUESTBOOK_RSSLIMIT_DSC", "Limit für RSS Eintr&auml;ge");
// ACP menu
define("_MI_GUESTBOOK_MENU_GUESTBOOK", "G&auml;stebuch");
define("_MI_GUESTBOOK_MENU_INDEXPAGE", "Edit Indexpage");
define("_MI_GUESTBOOK_MENU_TEMPLATES", "Templates");
define("_MI_VISITORVOIVE_MENU_IMPORT", "Import");