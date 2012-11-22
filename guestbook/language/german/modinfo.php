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
define("_MI_GUESTBOOK_DATE_FORMAT_DSC", "Sie k&ouml;nnen das Datumsformat einstellen wie Sie es w&uuml;nschen");
define("_MI_GUESTBOOK_SHOW_BREADCRUMBS", "Zeige die Breadcrumb Navigation");
define("_MI_GUESTBOOK_SHOW_BREADCRUMBS_DSC", "zeigen/ausblenden der Breadcrumb Navigation in der Useransicht");
define("_MI_GUESTBOOK_SHOW_ENTRIES", "Wie viele Eintr&auml;ge sollten in Useransicht angezeigt werden?");
define("_MI_GUESTBOOK_SHOW_ENTRIES_DSC", "");
define("_MI_GUESTBOOK_USE_MODERATION", "Verwenden Moderation?");
define("_MI_GUESTBOOK_USE_MODERATION_DSC", "M&ouml;chten Sie die Eintr&auml;ge moderieren?");
define("_MI_GUESTBOOK_SHOW_AVATAR", "Zeige Avatar in Frontend");
define("_MI_GUESTBOOK_SHOW_AVATAR_DSC", "Dadurch werden die Benutzer Avatare");
define("_MI_GUESTBOOK_NEEDS_APPROVAL", "Genehmigen Eintr&auml;ge, bevor sie ver&ouml;ffentlicht sind?");
define("_MI_GUESTBOOK_NEEDS_APPROVAL_DSC", "");
define("_MI_GUESTBOOK_ALLOW_IMAGEUPLOAD", "M&ouml;chten Sie erm&ouml;glichen Bild hochladen?");
define("_MI_GUESTBOOK_ALLOW_IMAGEUPLOAD_DSC", "");
define("_MI_GUESTBOOK_IMAGE_UPLOAD_WIDTH", "Max Image Upload Breite");
define("_MI_GUESTBOOK_IMAGE_UPLOAD_WIDTH_DSC", "");
define("_MI_GUESTBOOK_IMAGE_UPLOAD_HEIGHT", "Max Image Upload H&ouml;he");
define("_MI_GUESTBOOK_IMAGE_UPLOAD_HEIGHT_DSC", "");
define("_MI_GUESTBOOK_IMAGE_FILE_SIZE", "Maximal zul&auml;ssige Upload Gr&ouml;�e");
define("_MI_GUESTBOOK_IMAGE_FILE_SIZE_DSC", "");
define("_MI_GUESTBOOK_THUMBNAIL_WIDTH", "Miniaturbild Breite");
define("_MI_GUESTBOOK_THUMBNAIL_WIDTH_DSC", "Breite des Miniaturbild zur Anzeige hochgeladenen Bilder");
define("_MI_GUESTBOOK_THUMBNAIL_HEIGHT", "Miniaturbild H&ouml;he");
define("_MI_GUESTBOOK_THUMBNAIL_HEIGHT_DSC", "H&ouml;he des Miniaturbild zur Anzeige hochgeladenen Bilder");
define("_MI_GUESTBOOK_GUEST_CAN_SUBMIT", "Die G&auml;ste k&ouml;nnen einzureichen neue Eintr&auml;ge?");
define("_MI_GUESTBOOK_GUEST_CAN_SUBMIT_DSC", "M&ouml;gen Sie, damit die G&auml;ste, um neue Eintr&auml;ge einreichen, set'YES '");
define("_MI_GUESTBOOK_SHOW_EMAIL", "Anzeigen der E-Mail Adresse im Frontend?");
define("_MI_GUESTBOOK_SHOW_EMAIL_DSC", "zeigen/ausblenden der E-Mail Adresse im fronted");
define("_MI_GUESTBOOK_DISPLAY_EMAIL", "Wie die E-Mail-Adresse im Frontend angezeigt werden?");
define("_MI_GUESTBOOK_DISPLAY_EMAIL_DSC", "");
define("_MI_GUESTBOOK_DISPLAY_MAIL_SPAMPROT", "ext Spam ohne &uuml;berpr&uuml;fung Liste der verbotenen gesch&uuml;tzt");
define("_MI_GUESTBOOK_DISPLAY_MAIL_IMGPROT", "gewohnten E-Mail ohne Pr&uuml;fung Sperrlst");
define("_MI_GUESTBOOK_DISPLAY_MAIL_SPAMPROT_BANNED", "Text-Spam mit der &uuml;berpr&uuml;fung Liste der verbotenen gesch&uuml;tzt");
define("_MI_GUESTBOOK_DISPLAY_MAIL_IMGPROT_BANNED", "gewohnten E-Mail mit der &uuml;berpr&uuml;fung Liste der verbotenen");
define("_MI_GUESTBOOK_USE_RSS", "Use RSS feeds?");
define("_MI_GUESTBOOK_USE_RSS_DSC", "Enable/disable RSS feeds for guestbook");
define("_MI_GUESTBOOK_RSSLIMIT", "RSS Limit");
define("_MI_GUESTBOOK_RSSLIMIT_DSC", "Set limit of Entries for RSS feeds");
// ACP menu
define("_MI_GUESTBOOK_MENU_GUESTBOOK", "G&auml;stebuch");
define("_MI_GUESTBOOK_MENU_INDEXPAGE", "Edit Indexpage");
define("_MI_GUESTBOOK_MENU_TEMPLATES", "Templates");
define("_MI_VISITORVOIVE_MENU_IMPORT", "Import");
/**
 * added in 1.1
 */
// config
define("_MI_GUESTBOOK_CAN_MODERATE", "Select the groups, which can moderate entries");
define("_MI_GUESTBOOK_CAN_MODERATE_DSC", "");
define("_MI_GUESTBOOK_DISPLAY_WIDTH", "Image Display Width");
define("_MI_GUESTBOOK_DISPLAY_WIDTH_DSC", "");
define("_MI_GUESTBOOK_DISPLAY_HEIGHT", "Image Display height");
define("_MI_GUESTBOOK_DISPLAY_HEIGHT_DSC", "");
define("_MI_GUESTBOOK_AVATAR_DIMENSIONS", "Avatar Dimensions");
define("_MI_GUESTBOOK_AVATAR_DIMENSIONS_DSC", "Avatar Dimensions in px");
define("_MI_GUESTBOOK_CAN_UPLOAD", "Groups to be allowed uploading images");
define("_MI_GUESTBOOK_CAN_UPLOAD_DSC", "");