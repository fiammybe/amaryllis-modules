/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /scripts/downloads.js
 * 
 * Class representing Downloads download objects
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
	
	//report broken Link
	$(document).ready(function(){

		$("#dialog-confirm-broken").dialog({
			modal: true,
			width: 500,
			height: 200,
			autoOpen: false,
			resizable: false,
			draggable: true
		});

		$(".broken_link").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");


			$("#dialog-confirm-broken").dialog('option', 'buttons', {
				"Yes" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});

			$("#dialog-confirm-broken").dialog("open");

		});

	});
	
	// call disclaimer for download-confirmation
	$(document).ready(function(){

		$("#dialog-confirm-disclaimer").dialog({
			modal: true,
			width: 800,
			height: 600,
			autoOpen: false,
			resizable: true,
			draggable: true
		});

		$(".down_disclaimer").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");


			$("#dialog-confirm-disclaimer").dialog('option', 'buttons', {
				"I Agree" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});

			$("#dialog-confirm-disclaimer").dialog("open");

		});

	});
	
	// call disclaimer for upload-confirmation
	$(document).ready(function(){

		$("#dialog-confirm-upl-disclaimer").dialog({
			modal: true,
			width: 800,
			height: 600,
			autoOpen: false,
			resizable: true,
			draggable: true
		});

		$(".upl_disclaimer").click(function(e) {
			pos = this.id,
			e.preventDefault();
			var targetUrl = $(pos).attr("href");


			$("#dialog-confirm-upl-disclaimer").dialog('option', 'buttons', {
				"I Agree" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});

			$("#dialog-confirm-upl-disclaimer").dialog("open");

		});

	});
	
	
	// use colorbox for screenshots
	$(document).ready(function(){
		$('a.file_screens').colorbox({transition:'fade', speed:500});
	});