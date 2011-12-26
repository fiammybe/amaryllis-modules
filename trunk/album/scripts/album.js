/**
 * 'Album' is a light weight gallery module
 *
 * File: /scripts/album.js
 * 
 * script to initiate some jQuery Effekts for Downloads
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

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
		$('a.single_image').each(function(){
			
			$(this).colorbox({
				transition:'fade',
				speed:500,
				opacity: 0.9,
				slideshow: true,
				arrowKey: true,
				slideshowAuto: false,
				inline: true,
			});
		});
		
		//initiate qtip for category description
		$('div.album_album').each(function(){
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
					url: "ajax.php?op=vote_up&download_id="+ id ,
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