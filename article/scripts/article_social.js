/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /scripts/article.js
 * 
 * js file for social buttons in article module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.20
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

$(document).ready(function(){
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
});