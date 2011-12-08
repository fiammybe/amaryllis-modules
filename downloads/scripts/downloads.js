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
		
		$(".down_disclaimer").click(function(e) {
			var $link = $(this);
			e.preventDefault();
			var targetUrl = $link.attr("href");
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
		
		
		$("#dialog-confirm-disclaimer").dialog({
			modal: true,
			width: 800,
			height: 600,
			autoOpen: false,
			resizable: true,
			draggable: true
		});
	});
	
	// call disclaimer for upload-confirmation
	$(document).ready(function(){
	
		$(".upl_disclaimer").click(function(e) {
			var $link = $(this);
			
			e.preventDefault();
			var targetUrl = $link.attr("href");
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
		
		
		$("#dialog-confirm-upl-disclaimer").dialog({
			modal: true,
			width: 800,
			height: 600,
			autoOpen: false,
			resizable: true,
			draggable: true
		});
		
		
	});
	
	// use colorbox for screenshots
	$(document).ready(function(){
		$('a.file_screens').colorbox({transition:'fade', speed:500});
	});
	
	// initiate the tabs for single file view
	$(document).ready(function(){
		$("#file_tabs").tabs();
	});
	
	// initiate review form
	$(document).ready(function(){
		$(".review_form").dialog({
			modal: true,
			width: 700,
			height: 350,
			autoOpen: false,
			resizable: false,
			draggable: true
		});
		$(".review_link").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");
			$(".file_review").dialog('option', 'buttons', {
				"Submit" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});
			$(".review_form").dialog("open");
		});
	});
