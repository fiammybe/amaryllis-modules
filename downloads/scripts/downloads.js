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
 
	/**
	 * jQuery Cookie plugin
	 *
	 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
	 * Dual licensed under the MIT and GPL licenses:
	 * http://www.opensource.org/licenses/mit-license.php
	 * http://www.gnu.org/licenses/gpl.html
	 *
	 */
	jQuery.cookie = function (key, value, options) {
	    // key and at least value given, set cookie...
	    if (arguments.length > 1 && String(value) !== "[object Object]") {
	        options = jQuery.extend({}, options);
	
	        if (value === null || value === undefined) {
	            options.expires = -1;
	        }
	
	        if (typeof options.expires === 'number') {
	            var days = options.expires, t = options.expires = new Date();
	            t.setDate(t.getDate() + days);
	        }
	
	        value = String(value);
	
	        return (document.cookie = [
	            encodeURIComponent(key), '=',
	            options.raw ? value : encodeURIComponent(value),
	            options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
	            options.path ? '; path=' + options.path : '',
	            options.domain ? '; domain=' + options.domain : '',
	            options.secure ? '; secure' : ''
	        ].join(''));
	    }
	    // key and possibly options given, get cookie...
	    options = value || {};
	    var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
	    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
	};
	
	/**
	 * E N D jquery cookie plugin
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
	
	// initiate review form
	$(document).ready(function(){
		$(".review_form").dialog({
			modal: true,
			width: 700,
			height: 400,
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

	//review permission denied
	$(document).ready(function(){
		$("#dialog-confirm-perm").dialog({
			modal: true,
			width: 500,
			height: 200,
			autoOpen: false,
			resizable: false,
			draggable: true
		});
		$(".perm_review_link").click(function(e) {
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
	
	//rate permission denied
	$(document).ready(function(){
		$("#dialog-vote-perm").dialog({
			modal: true,
			width: 500,
			height: 200,
			autoOpen: false,
			resizable: false,
			draggable: true
		});
		$(".file_vote_perm").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");
			$("#dialog-vote-perm").dialog('option', 'buttons', {
				"Register Now" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});
			$("#dialog-vote-perm").dialog("open");
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

	$(document).ready(function(){
		// use colorbox for screenshots
		$('a.file_screens').colorbox({transition:'fade', speed:500});
		// initiate the tabs for single file view
		$("#file_tabs").tabs({ cookie: { expires: 7 } });
		//initiate qtip for category description
		$('div.downloads_category').each(function(){
			$(this).qtip({
				content: {
					text: $(this).next('div.popup').html(),
					title: $(this).attr('original-title')
				},
				style: {
					width:500,
					viewport: $(window), // Keep it on-screen at all times if possible
					textAlign:'left',
					tip:'bottomLeft',
					classes: 'ui-tooltip-light ui-tooltip-rounded ui-tooltip-shadow',
				},
				position:   {
					target: 'mouse',
					my:'bottomLeft',
					adjust: {
						x: 10,  y: 10
					}
				},
			});
		});
		// file votings
		$("a.file_vote").click(function() {
			var id = $(this).attr("download_id");
			var name = $(this).attr("name");
			var dataString = 'download_id='+ id ;
			var parent = $(this);
			if (name=='up') {
				$.ajax({
					type: "POST",
					url: "ajax.php?op=vote_up",
					data: dataString,
					cache: false,
				});
			} else {
				$.ajax({
					type: "POST",
					url: "ajax.php?op=vote_down",
					data: dataString,
					cache: false,
					
				});
			}
			$("#file_voting").load(location.href + " #file_voting > *");
			return false;
		});
	});