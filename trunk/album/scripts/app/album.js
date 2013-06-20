/**
 * 'Album' is a light weight gallery module
 *
 * File: /scripts/album.js
 *
 * script to initiate some jQuery Effekts for Downloads
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: album.js 967 2012-11-26 12:44:28Z st.flohrer $
 * @package		album
 *
 */

// call disclaimer for upload-confirmation
	$(document).ready(function() {
		$(".upl_disclaimer").click(function(e) {
			e.preventDefault();
			var link = $(this), targetUrl = link.attr("href"), dlg = $("#dialog-confirm-upl-disclaimer"), dialog_buttons = {};
			dialog_buttons[album_messages.agree] = function(){ window.location.href = targetUrl; };
			dialog_buttons[album_messages.cancel] = function(){ $(this).dialog('close'); };
			dlg.dialog({ buttons: dialog_buttons }).dialog("open");
			return false;
		});

		$("#dialog-confirm-upl-disclaimer").dialog({
			modal: true,
			width: "90%",
			height: "auto",
			autoOpen: false,
			resizable: true,
			draggable: true
		});

		// use colorbox for screenshots
		$('a.single_image').each(function(){
			var link = $(this), maxH = link.data("maxheight"), maxW = link.data("maxwidth"), innerH = link.data("innerheight"),innerW = link.data("innerwidth");
			link.colorbox({
				transition:'fade',
				speed:500,
				opacity: 0.9,
				photo: true,
				scalePhotos: false,
				slideshow: true,
				arrowKey: true,
				slideshowAuto: false,
				inline: true,
				arrowKey: false,
				maxWidth: maxW,
				maxHeight: maxH,
				innerWidth: innerW,
				innerHeight: innerH
			});
		});
	});