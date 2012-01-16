/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /scripts/career.js
 * 
 * js file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

// initiate message form
	$(document).ready(function(){
		$(".message_form").dialog({
			modal: true,
			width: 700,
			height: 700,
			autoOpen: false,
			resizable: true,
			draggable: true
		});
		$(".message_link").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");
			$(".file_message").dialog('option', 'buttons', {
				"Submit" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});
			$(".message_form").dialog("open");
		});
	});

	//message permission denied
	$(document).ready(function(){
		$("#dialog-confirm-perm").dialog({
			modal: true,
			width: 500,
			height: 200,
			autoOpen: false,
			resizable: false,
			draggable: true
		});
		$(".perm_message_link").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");
			$("#dialog-confirm-perm").dialog('option', 'buttons', {
				"Register Now" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});
			$("#dialog-confirm-perm").dialog("open");
		});
	});