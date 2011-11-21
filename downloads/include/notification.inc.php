<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /include/notification.inc.php
 * 
 * File holding functions used by the module to hook with the search system of ImpressCMS
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

function downloads_notify_iteminfo($category, $item_id){
    global $icmsModule, $icmsModuleConfig, $icmsConfig;

    if ($category == 'global') {
        $item['name'] = '';
        $item['url'] = '';
        return $item;
    }
}