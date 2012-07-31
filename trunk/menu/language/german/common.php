<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /language/english/common.php
 * 
 * english common language file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Menu
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		menu
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// menu
define("_CO_MENU_MENU_MENU_NAME", "Titel");
define("_CO_MENU_MENU_MENU_NAME_DSC", "");
define("_CO_MENU_MENU_MENU_DSC", "Beschreibung");
define("_CO_MENU_MENU_MENU_DSC_DSC", "Die Beschreibung wird nicht angezeigt.");
define("_CO_MENU_MENU_MENU_KIND", "Art des Men�s");
define("_CO_MENU_MENU_MENU_KIND_DSC", "Wichtig: Dies wird m�glicherweise nicht benutzt. Der Wert ist lediglich f�r einige scripte, welche horizontale und verticale Men�s unterst�tzen.");
define("_CO_MENU_MENU_MENU_HOME", "&quot;Startseiten&quot;-Link anzeigen?");
define("_CO_MENU_MENU_MENU_HOME_DSC", "");
define("_CO_MENU_MENU_MENU_IMAGES", "Bilder anzeigen?");
define("_CO_MENU_MENU_MENU_IMAGES_DSC", "");
define("_CO_MENU_MENU_MENU_HOME_TXT", "Text des &quot;Startseiten&quot;-Links?");
define("_CO_MENU_MENU_MENU_HOME_TXT_DSC", "");
define("_CO_MENU_MENU_MENU_HOME_IMG", "Startseiten-Bild");
define("_CO_MENU_MENU_MENU_HOME_IMG_DSC", "");
define("_CO_MENU_MENU_MENU_IMAGES_WIDTH", "Darstellungsbreite der Anzeigebilder");
define("_CO_MENU_MENU_MENU_IMAGES_WIDTH_DSC", "Legen Sie die Breite des Icons fest.");
define("_CO_MENU_MENU_MENU_ITEMS_DSC", "Display item Description");
define("_CO_MENU_MENU_MENU_ITEMS_DSC_DSC", "");
define("_CO_MENU_MENU_MENU_ULID", "ID des ul-tag");
define("_CO_MENU_MENU_MENU_ULID_DSC", "Legen sie die id des ul-Tags f�r das Men� fest. Momentan gibt es folgende M�glichkeit: <br />'horiznav' f�r eine horizontale Navigation<br />'accordion' f�r eine vertikale 'Akkordeon-Navigation' <br />
										'sf-v-menu' f�r das 'vertikale-superfish-Men�' und 'sf-h-menu' f�r das 'horizontale-superfish-Men�'.<br />Das Megamenu verwendet eine eigene id");

define("_CO_MENU_MENU_KIND_HORIZONTAL", "Horizontal");
define("_CO_MENU_MENU_KIND_VERTICAL", "Vertikal");
define("_CO_MENU_MENU_KIND_DYNAMIC", "Dynamisch");

define("_CO_MENU_MENU_DISPLAY_WITH_IMGS", "Bildbreite");
define("_CO_MENU_MENU_DISPLAY_WITHOUT_IMGS", "Ohne Bilder");
define("_CO_MENU_MENU_DISPLAY_ONLY_IMGS", "Nur Bilder");
// items
define("_CO_MENU_ITEM_ITEM_NAME", "Titel des Links");
define("_CO_MENU_ITEM_ITEM_NAME_DSC", "");
define("_CO_MENU_ITEM_ITEM_DSC", "Beschreibung des Links");
define("_CO_MENU_ITEM_ITEM_DSC_DSC", "");
define("_CO_MENU_ITEM_ITEM_MENU", "Men�");
define("_CO_MENU_ITEM_ITEM_MENU_DSC", "W�hlen Sie ein Me�");
define("_CO_MENU_ITEM_ITEM_URL", "Url des Links");
define("_CO_MENU_ITEM_ITEM_URL_DSC", "Sie k�nnen eine vollst�ndige URL angeben, oder <br /> {ICMS_URL} f�r die Hauptdomain <br /> {MOD_URL} f�r das Modulverzeichnis /modules/ oder <br /> {UID} f�r die User-id");
define("_CO_MENU_ITEM_ITEM_IMAGE", "Bild");
define("_CO_MENU_ITEM_ITEM_TARGET", "Ziel");
define("_CO_MENU_ITEM_ITEM_IMAGE_DSC", "");
define("_CO_MENU_ITEM_ITEM_PID", "Übergeordneter Link");
define("_CO_MENU_ITEM_ITEM_PID_DSC", "W�hlen Sie den Link, der diesem �bergeordnet ist.");
define("_CO_MENU_ITEM_ITEM_ACTIVE", "Aktive?");
define("_CO_MENU_ITEM_ITEM_ACTIVE_DSC", "");
define("_CO_MENU_ITEM_ITEM_HASSUB", "Hat Untermen�s?");
define("_CO_MENU_ITEM_ITEM_HASSUB_DSC", "");
define("_CO_MENU_ITEM_PERM_VIEW", "Benutzerberechtigungen");
define("_CO_MENU_ITEM_PERM_VIEW_DSC", "");
define("_CO_MENU_ITEM_WRONG_MENU", "Der ausgew�hlte �bergeordnete Link wird in einem anderen Men� verwendet. Bitte w�hlen Sie einen anderen Link aus!");