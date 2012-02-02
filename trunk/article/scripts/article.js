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


	/**
	 * jQuery imtech pager plugin
	 *
	 * Copyright (c) 2011 www.script tutorials.com
	 *
	 */

	var Imtech = {};
	Imtech.Pager = function() {
	    this.paragraphsPerPage = 1;
	    this.currentPage = 1;
	    this.pagingControlsContainer = '#pagingControls';
	    this.pagingContainerPath = '#article_body';
	
	    this.numPages = function() {
	        var numPages = 0;
	        if (this.paragraphs != null && this.paragraphsPerPage != null) {
	            numPages = Math.ceil(this.paragraphs.length / this.paragraphsPerPage);
	        }
	
	        return numPages;
	    };
	
	    this.showPage = function(page) {
	        this.currentPage = page;
	        var html = '';
	
	        this.paragraphs.slice((page-1) * this.paragraphsPerPage,
	            ((page-1)*this.paragraphsPerPage) + this.paragraphsPerPage).each(function() {
	            html += '<div>' + $(this).html() + '</div>';
	        });
	
	        $(this.pagingContainerPath).html(html);
	
	        renderControls(this.pagingControlsContainer, this.currentPage, this.numPages());
	    }
	
	    var renderControls = function(container, currentPage, numPages) {
	        var pagingControls = '<ul>';
	        for (var i = 1; i <= numPages; i++) {
	            if (i != currentPage) {
	                pagingControls += '<li><a href="#" onclick="pager.showPage(' + i + '); return false;">' + i + '</a></li>';
	            } else {
	                pagingControls += '<li>' + i + '</li>';
	            }
	        }
	
	        pagingControls += '</ul>';
	
	        $(container).html(pagingControls);
	    }
	}
	/**
	 * E N D jquery imTech pager plugin
	 */
	/*!
	 * liScroll 1.0
	 * Examples and documentation at: 
	 * http://www.gcmingati.net/wordpress/wp-content/lab/jquery/newsticker/jq-liscroll/scrollanimate.html
	 * 2007-2010 Gian Carlo Mingati
	 * Version: 1.0.2.1 (22-APRIL-2011)
	 * Dual licensed under the MIT and GPL licenses:
	 * http://www.opensource.org/licenses/mit-license.php
	 * http://www.gnu.org/licenses/gpl.html
	 * Requires:
	 * jQuery v1.2.x or later
	 * 
	 */
	jQuery.fn.liScroll = function(settings) {
			settings = jQuery.extend({
			travelocity: 0.07
			}, settings);		
			return this.each(function(){
					var $strip = jQuery(this);
					$strip.addClass("article_newsticker")
					var stripWidth = 1;
					$strip.find("li").each(function(i){
					stripWidth += jQuery(this, i).outerWidth(true);
					});
					var $mask = $strip.wrap("<div class='mask'></div>");
					var $tickercontainer = $strip.parent().wrap("<div class='tickercontainer'></div>");								
					var containerWidth = $strip.parent().parent().width();
					$strip.width(stripWidth);			
					var totalTravel = stripWidth+containerWidth;
					var defTiming = totalTravel/settings.travelocity;
					function scrollnews(spazio, tempo){
					$strip.animate({left: '-='+ spazio}, tempo, "linear", function(){$strip.css("left", containerWidth); scrollnews(totalTravel, defTiming);});
					}
					scrollnews(totalTravel, defTiming);				
					$strip.hover(function(){
					jQuery(this).stop();
					},
					function(){
					var offset = jQuery(this).offset();
					var residualSpace = offset.left + stripWidth;
					var residualTime = residualSpace/settings.travelocity;
					scrollnews(residualSpace, residualTime);
					});			
			});	
	};
	
	var pager = new Imtech.Pager();
	$(document).ready(function(){
		//report broken Link
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
		//call disclaimer for article-confirmation
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
		// call disclaimer for upload-confirmation
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
		// related to initiate g+
		(function() {
		    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		    po.src = 'https://apis.google.com/js/plusone.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();
		// related to fb-like
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = '//connect.facebook.net/en_US/all.js#xfbml=1';
			fjs.parentNode.insertBefore(js, fjs);
		  }
		  (document, 'script', 'facebook-jssdk'));
		if($('#socialshareprivacy').length > 0){ $('#socialshareprivacy').socialSharePrivacy(); }
		// initiate tag form
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
		//tag permission denied
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