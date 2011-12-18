/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /scripts/guestbook.js
 * 
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

// guestbook submit form
	$(document).ready(function(){
		$(".guestbook_form").dialog({
			modal: true,
			width: 700,
			height: 800,
			autoOpen: false,
			resizable: true,
			draggable: true
		});
		$(".submit_link").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");
			$(".guestbook_link").dialog('option', 'buttons', {
				"Submit" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});
			$(".guestbook_form").dialog("open");
		});
	});

	//guestbook permission denied
	$(document).ready(function(){
		$("#dialog-confirm-perm").dialog({
			modal: true,
			width: 500,
			height: 200,
			autoOpen: false,
			resizable: false,
			draggable: true
		});
		$(".register_link").click(function(e) {
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