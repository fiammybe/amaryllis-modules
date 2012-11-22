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

	$(document).ready(function(){
		var settings = {
				tl:{ radius:10 },
				tr:{ radius:10 },
				bl:{ radius:10 },
				br:{ radius:10 },
				antiAlias:true,
				autoPad:true,
				validTags:["div"]
			}
		$('div.bubble').corner(settings);
		$('a.entry_img').colorbox({
			transition:'fade',
			speed:500,
			opacity: 0.9,
			slideshow: true,
			slideshowAuto: false
		});
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