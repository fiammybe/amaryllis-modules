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
	
	// call disclaimer for article-confirmation
	$(document).ready(function(){
		$(".down_disclaimer").click(function(e) {
			var $link = $(this);
			e.preventDefault();
			var targetUrl = $link.attr("href");
			$("#dialog-confirm-disclaimer").dialog('option', 'buttons', {
				"I Agree" : function() {
					window.location.href = targetUrl;
					$(this).dialog("close");
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
	
	var pager = new Imtech.Pager();
	$(document).ready(function(){
		// use pagination
	    pager.paragraphsPerPage = 1; // set amount elements per page
	    pager.pagingContainer = $('#article_body'); // set of main container
	    pager.paragraphs = $('div.z', pager.pagingContainer); // set of required containers
	    pager.showPage(1);
		// use colorbox for indeximage
		$('a.article_screens').colorbox({
			transition:'fade',
			speed:500,
			opacity: 0.9,
			slideshow: true,
			slideshowAuto: false
		});
		// use newsticker
		$("ul#articles_newsticker").liScroll({travelocity: 0.10});
		
		//initiate qtip for category description
		$('div.article_category').each(function(){
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
	
	
	// initiate tag form
	$(document).ready(function(){
		$(".tag_form").dialog({
			modal: true,
			width: 700,
			height: 600,
			autoOpen: false,
			resizable: true,
			draggable: true
		});
		$(".tag_link").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");
			$(".article_tag").dialog('option', 'buttons', {
				"Submit" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});
			$(".tag_form").dialog("open");
		});
	});

	//tag permission denied
	$(document).ready(function(){
		$("#dialog-confirm-perm-tag").dialog({
			modal: true,
			width: 500,
			height: 200,
			autoOpen: false,
			resizable: false,
			draggable: true
		});
		$(".perm_tag_link").click(function(e) {
			e.preventDefault();
			var targetUrl = $(this).attr("href");
			$("#dialog-confirm-perm-tag").dialog('option', 'buttons', {
				"Register Now" : function() {
					window.location.href = targetUrl;
				},
				"Cancel" : function() {
					$(this).dialog("close");
				}
			});
			$("#dialog-confirm-perm-tag").dialog("open");
		});
	});