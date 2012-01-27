/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /scripts/article.js
 * 
 * js file for article module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

	$(document).ready(function(){
		// use colorbox for indeximage
		$('a.portfolio_image').colorbox({
			transition:'fade',
			speed:500,
			opacity: 0.9,
			slideshow: true,
			slideshowAuto: false
		});
		// use colorbox for screenshots
		$('a.portfolio_image2').colorbox({
			transition:'fade',
			speed:500,
			opacity: 0.9,
			slideshow: true,
			slideshowAuto: false
		});
		
		//initiate qtip for category description
		$('div.portfolio').each(function(){
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
						x: 0,  y: -5
					}
				},
			});
		});
		// initiate qtips for tags
		$('span.article_tag').each(function(){
			$(this).qtip({
				content: {
					text: $(this).next('span.popup_tag').html(),
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
						x: 0,  y: -5
					}
				},
			});
		});
		(function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/plusone.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = '//connect.facebook.net/en_US/all.js#xfbml=1';
			fjs.parentNode.insertBefore(js, fjs);
		  }
		  (document, 'script', 'facebook-jssdk'));
		if($('#socialshareprivacy').length > 0){ $('#socialshareprivacy').socialSharePrivacy(); }
		
	});

	// initiate contact form
	$(document).ready(function(){
		$(".portfolio_form").dialog({
			modal: true,
			width: 700,
			height: 400,
			autoOpen: false,
			resizable: false,
			draggable: true
		});
		$(".contact_link").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");
			$(".portfolio_contact").dialog('option', 'buttons', {
				"Submit" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});
			$(".portfolio_form").dialog("open");
		});
	});

	//contact permission denied
	$(document).ready(function(){
		$("#dialog-confirm-perm").dialog({
			modal: true,
			width: 500,
			height: 200,
			autoOpen: false,
			resizable: false,
			draggable: true
		});
		$(".perm_contact_link").click(function(e) {
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