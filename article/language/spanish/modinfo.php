<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /language/spanish/modinfo.php
 * 
 * modinfo language file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @translator	debianus
 * @version		$Id$
 * @package	article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_ARTICLE_MD_NAME", "Article");
define("_MI_ARTICLE_MD_DSC", "'Article' es un módulo para la gestión de artículos para ImpressCMS. Admite categorías, adjuntar archivos e incluir artículos relacionados, entre otras muchas características.");
// templates
define("_MI_ARTICLE_INDEX_TPL", "Página principal");
define("_MI_ARTICLE_ARTICLE_TPL", "Lista de artículos en la página principal");
define("_MI_ARTICLE_CATEGORY_TPL", "Lista de categorís en la página principal");
define("_MI_ARTICLE_FORMS_TPL", "Formulario de envío de artículos y categorías desde la página");
define("_MI_ARTICLE_SINGLEARTICLE_TPL", "Muestra un artículo concreto");
define("_MI_ARTICLE_ADMIN_TPL", "Plantilla para ACP -Administración-");
define("_MI_ARTICLE_REQUIREMENTS_TPL", "Comprueba requisitos");
define("_MI_ARTICLE_HEADER_TPL", "Header y footer incluidos en todas las plantillas.");
define("_MI_ARTICLE_PRINT_TPL", "Impresión de un artículo concreto");
// blocks
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE", "Artículos recientes");
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE_DSC", "Bloque que contiene una lista de los artículos recientes");
define("_MI_ARTICLE_BLOCK_RECENT_UPDATED", "Artículos actualizados recientemente");
define("_MI_ARTICLE_BLOCK_RECENT_UPDATED_DSC", "Bloque que contiene una lista de los artículos actualizados");
define("_MI_ARTICLE_BLOCK_MOST_POPULAR", "Artículos más leídos");
define("_MI_ARTICLE_BLOCK_MOST_POPULAR_DSC", "Bloque que contiene una lista de los artículos con más lecturas");
define("_MI_ARTICLE_BLOCK_CATEGORY_MENU", "Menú de categorías");
define("_MI_ARTICLE_BLOCK_CATEGORY_MENU_DSC", "Bloque con la lista de las categorías");
define("_MI_ARTICLE_BLOCK_SPOTLIGHT", "Titular");
define("_MI_ARTICLE_BLOCK_SPOTLIGHT_DSC", "Bloque con el artículo más importante");
define("_MI_ARTICLE_BLOCK_RANDOM_ARTICLES", "Artículos aleatorios");
define("_MI_ARTICLE_BLOCK_RANDOM_ARTICLES_DSC", "Bloque con artículos seleccionados aleatoriamente");
define("_MI_ARTICLE_BLOCK_SPOTLIGHT_IMAGE", "Galería");
define("_MI_ARTICLE_BLOCK_SPOTLIGHT_IMAGE_DSC", "Bloque con las imágenes de los artículos");
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE_LIST", "Lista de artículos");
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE_LIST_DSC", "Bloque con una lista de los artículos");
define("_MI_ARTICLE_BLOCK_MOST_COMMENTED", "Más comentados");
define("_MI_ARTICLE_BLOCK_MOST_COMMENTED_DSC", "Muestra una lista de los artículos con más comentarios ordenados según las categorías");
define("_MI_ARTICLE_BLOCK_NEWSTICKER", "Newsticker");
define("_MI_ARTICLE_BLOCK_NEWSTICKER_DSC", "Bloque con Newsticker para mostrar títulos de artículos");
// preferences
define("_MI_ARTICLE_AUTHORIZED_GROUPS", "Grupos autorizados para crear categorías");
define("_MI_ARTICLE_AUTHORIZED_GROUPS_DSC", "Seleccione los grupos que pueden crear o solicitar la creación de categorías desde la página principal del módulo");
define("_MI_ARTICLE_DATE_FORMAT", "Formato de fecha");
define("_MI_ARTICLE_DATE_FORMAT_DSC", "Más información en <a href=\"http://php.net/manual/es/function.date.php\" target=\"blank\">Manual de PHP</a>");
define("_MI_ARTICLE_SHOW_BREADCRUMBS", "Mostrar breadcrumb");
define("_MI_ARTICLE_SHOW_BREADCRUMBS_DSC", "Seleccione 'Sí' para mostrarlo en la página");
define("_MI_ARTICLE_SHOW_CATEGORIES", "Mostrar categorías");
define("_MI_ARTICLE_SHOW_CATEGORIES_DSC", "Determine el número de categorías que se mostrarán en cada página");
define("_MI_ARTICLE_SHOW_CATEGORY_COLUMNS", "Número de columnas para las categorías");
define("_MI_ARTICLE_SHOW_CATEGORY_COLUMNS_DSC", "Determine el número de columnas que se mostrarán en la página principal para ordenar las categorías existentes");
define("_MI_ARTICLE_SHOW_ARTICLE", "Artículos a mostrar");
define("_MI_ARTICLE_SHOW_ARTICLE_DSC", "Establezca el número de artículos que se mostrarán en cada página; a partir del mismo se utilizará la paginación");
define("_MI_ARTICLE_THUMBNAIL_WIDTH", "Ancho de miniaturas");
define("_MI_ARTICLE_THUMBNAIL_WIDTH_DSC", "");
define("_MI_ARTICLE_THUMBNAIL_HEIGHT", "Altura de miniaturas");
define("_MI_ARTICLE_THUMBNAIL_HEIGHT_DSC", "");
define("_MI_ARTICLE_DISPLAY_WIDTH", "Ancho de imágenes");
define("_MI_ARTICLE_DISPLAY_WIDTH_DSC", "");
define("_MI_ARTICLE_DISPLAY_HEIGHT", "Altura de imágenes");
define("_MI_ARTICLE_DISPLAY_HEIGHT_DSC", "");
define("_MI_ARTICLE_IMAGE_UPLOAD_WIDTH", "Ancho máximo de imágenes para ser añadidas al servidor");
define("_MI_ARTICLE_IMAGE_UPLOAD_WIDTH_DSC", "");
define("_MI_ARTICLE_IMAGE_UPLOAD_HEIGHT", "Altura máximo de imágenes para ser añadidas al servidor");
define("_MI_ARTICLE_IMAGE_UPLOAD_HEIGHT_DSC", "");
define("_MI_ARTICLE_UPLOAD_ARTICLE_SIZE", "Tamaño máximo de archivo");
define("_MI_ARTICLE_UPLOAD_ARTICLE_SIZE_DSC", "Establezca el tamaño máximo de los archivos que pueden ser añadidos al servidor");
define("_MI_ARTICLE_SHOWDISCLAIMER", "Mostrar reglas a los usuarios que pueden enviar nuevos artículos");
define("_MI_ARTICLE_SHOWDISCLAIMER_DSC", "Antes del envío serán las mismas mostradas y deberán ser aceptadas por quien envíe nuevos artículos");
define("_MI_ARTICLE_DISCLAIMER", "Reglas para el envío de artículos");
define("_MI_ARTICLE_UPL_DISCLAIMER_TEXT", "<h1>Terms of Service for {X_SITENAME}:</h1>
												<p>{X_SITENAME} reserves the right to remove any image or file for any reason what ever. Specifically, any image/file uploaded that infringes upon copyrights not held by the uploader, is illegal or violates any laws, will be immediately deleted and the IP address of the uploaded reported to authorities. Violating these terms will result in termination of your ability to upload further images/files.
												Do not link or embed images hosted on this service into a large-scale, non- forum website. You may link or embed images hosted on this service in personal sites, message boards, and individual online auctions.</p>
												<p>By uploading images to {X_SITENAME} you give permission for the owners of {X_SITENAME} to publish your images in any way or form, meaning websites, print, etc. You will not be compensated by {X_SITENAME} for any loss what ever!</p>
												<p>We reserve the right to ban any individual uploader or website from using our services for any reason.</p>
												<p>All images uploaded are copyright © their respective owners.</p>
												<h2>Privacy Policy :</h2> 
												<p>{X_SITENAME} collects user's IP address, the time at which user uploaded a file, and the file's URL. This data is not shared with any third party companies or individuals (unless the file in question is deemed to be in violation of these Terms of Service, in which case this data may be shared with law enforcement entities), and is used to enforce these Terms of Service as well as to resolve any legal matters that may arise due to violations of the Terms of Service. </p>
												<h2>Legal Policy:</h2> 
												<p>These Terms of Service are subject to change without prior warning to its users. By using {X_SITENAME}, user agrees not to involve {X_SITENAME} in any type of legal action. {X_SITENAME} directs full legal responsibility of the contents of the files that are uploaded to {X_SITENAME} to individual users, and will cooperate with law enforcement entities in the case that uploaded files are deemed to be in violation of these Terms of Service. </p>
												<p>All files are © to their respective owners · All other content © {X_SITENAME}. {X_SITENAME} is not responsible for the content any uploaded files, nor is it in affiliation with any entities that may be represented in the uploaded files.</p>");
define("_MI_ARTICLE_SHOW_DOWN_DISCL", "Mostrar reglas antes de que los usuarios puedan descargar los archivos");
define("_MI_ARTICLE_SHOW_DOWN_DISCL_DSC", "");
define("_MI_ARTICLE_DOWN_DISCLAIMER", "Reglas para la descarga de archivos");
define("_MI_ARTICLE_DOWN_DISCLAIMER_TEXT", "<h1>TERMS OF USE</h1>
												<p>All products available for download through this site are provided by third party software/scripts publishers pursuant to license agreements or other arrangements between such publishers and the end user. We disclaim any responsibility for or liability related to the software/scripts. Any questions complaints or claims related to the software should be directed to the appropriate Author or Company responsible for developing the software. We make no representations or warranties of any kind concerning the quality, safety or suitability of the software/script, either expressed or implied, including without limitation any implied warranties of merchantability, fitness for a particular purpose, or non-infringement. We make no representation or warrantie as to the truth, accuracy or completeness of any statements, information or materials concerning the software/script that is contained on and within any of the websites owned and operated by us. In no event will we be liable for any indirect, punitive, special, incidental or consequential damages however they may arise and even if we have been previously advised of the possibility of such damages. There are inherent dangers in the use of any software/script available for download on the Internet, and we caution you to make sure that you completely understand the potential risks before downloading any of the software/scripts. You are solely responsible for adequate protection and backup of the data and equipment used in connection with any of the software, and we will not be liable for any damages that you may suffer in connection with using, modifying or distributing any of the software.</p>
												<h2>PRIVACY STATEMENT</h2>
												<p>We record visits to this web site and logs the following information for statistical purposes: the user's server or proxy address, the date/time of the visit and the files requested. The information is used to analyse our server traffic. No attempt will be made to identify users or their browsing activities except where authorized by law. For example in the event of an investigation, a law enforcement agency may exercise their legal authority to inspect the internet service provider's logs. If you send us an email message or contact as via contact form, we will record your contact details. This information will only be used for the purpose for which you have provided it. We will not use your email for any other purpose and will not disclose it without your consent except where such use or disclosure is permitted under an exception provided in the Privacy Act. When users choose to join a mailing list their details are added to that specific mailing list and used for the stated purpose of that list only.</p>
												<h2>LINKING</h2>
												<p>Links to external web sites are inserted for convenience and do not constitute endorsement of material at those sites, or any associated organization, product or service.</p>");
define("_MI_ARTICLE_USE_RSS", "Usar RSS");
define("_MI_ARTICLE_USE_RSS_DSC", "");
define("_MI_ARTICLE_USE_SPROCKETS", "Usar el módulo 'Sprockets'");
define("_MI_ARTICLE_USE_SPROCKETS_DSC", "Es necesario si pretende usar etiquetas en los artículos");
define("_MI_ARTICLE_NEED_RELATED", "Mostrar artículos relacionados");
define("_MI_ARTICLE_NEED_RELATED_DSC", "Si selecciona 'Sí' puede elegir artículos relacionados con el que esté redactando de la lista que aparecerá. Los mismos se mostrarán al final del artículo cuando se visualize.");
define("_MI_ARTICLE_NEED_ATTACHMENTS", "Permitir adjuntar archivos a los artículos");
define("_MI_ARTICLE_NEED_ATTACHMENTS_DSC", "");
define("_MI_ARTICLE_ARTICLE_APPROVE", "Aprobar archivos");
define("_MI_ARTICLE_ARTICLE_APPROVE_DSC", "Determine si prefiere aprobar los archivos adjuntados antes de permitir su descarga");
define("_MI_ARTICLE_CATEGORY_APPROVE", "Aprobación de las nuevas categorías");
define("_MI_ARTICLE_CATEGORY_APPROVE_DSC", "Seleccione 'Sí' si prefiere aprobar las nuevas categorías creadas desde la administración del módulo.");
define("_MI_ARTICLE_DISPLAY_ARTICLE_SIZE", "Cómo mostrar el tamaño de los archivos?");
define("_MI_ARTICLE_DISPLAY_ARTICLE_SIZE_DSC", "Las posibilidades son 'byte', 'mb' -megabyte-, 'gb' -gigabyte-");
define("_MI_ARTICLE_POPULAR", "Número de lecturas para considerar un artículo como popular");
define("_MI_ARTICLE_DAYSNEW", "Días para considerar un artículo como 'Nuevo'");
define("_MI_ARTICLE_DAYSUPDATED", "Días para considerar un artículo como 'Actualizado' después de ser modificado");
define("_MI_ARTICLE_DEFAULT", "Predeterminado");
define("_MI_ARTICLE_HORIZONTAL", "Contador horizontal");
define("_MI_ARTICLE_VERTICAL", "Contador vertical");
define("_MI_ARTICLE_DISPLAY_TWITTER", "Mostrar botón de Twitter");
define("_MI_ARTICLE_DISPLAY_TWITTER_DSC", "");
define("_MI_ARTICLE_DISPLAY_FBLIKE", "Mostrar botón de Facebook");
define("_MI_ARTICLE_DISPLAY_FBLIKE_DSC", "");
define("_MI_ARTICLE_DISPLAY_GPLUS", "Mostrar botón de G+");
define("_MI_ARTICLE_DISPLAY_GPLUS_DSC", "");
define("_MI_ARTICLE_PRINT_FOOTER", "Pie de página de impresión");
define("_MI_ARTICLE_PRINT_FOOTER_DSC", "");
define("_MI_ARTICLE_PRINT_LOGO", "Logo de impresión");
define("_MI_ARTICLE_PRINT_LOGO_DSC", "Establezca la ruta a la imagen que se utilizará como logo. Ejemplo: /themes/example/images/logo.gif");
define("_MI_ARTICLE_DISPLAY_NEWSTICKER", "Mostrar Newsticker");
define("_MI_ARTICLE_DISPLAY_NEWSTICKER_DSC", "Permite utilizar dicha característica en cada artículo; tenga en cuanta que también puede usarse la misma con un bloque especial.");
define("_MI_ARTICLE_NEED_DEMO", "Mostrar enlace a una demo");
define("_MI_ARTICLE_NEED_DEMO_DSC", "");
define("_MI_ARTICLE_NEED_CONCLUSION", "Conclusiones");
define("_MI_ARTICLE_NEED_CONCLUSION_DSC", "");
// Notifications
define('_MI_ARTICLE_GLOBAL_NOTIFY', 'Global');
define('_MI_ARTICLE_GLOBAL_NOTIFY_DSC', 'Opciones para las notificaciones a los usuarios.');
define('_MI_ARTICLE_CATEGORY_NOTIFY', 'Categoría');
define('_MI_ARTICLE_CATEGORY_NOTIFY_DSC', 'Opciones para las notificaciones relacionadas con la categoría actual.');
define('_MI_ARTICLE_ARTICLE_NOTIFY', 'Artículo');
define('_MI_ARTICLE_ARTICLE_NOTIFY_DSC', 'Opciones para las notificaciones relacionadas con el artículo actual');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY', 'Nueva categoría');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_CAP', 'Notificar la creación de una nueva categoría.');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_DSC', 'Recibir notificación cuando una nueva categoría es creada.');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Autonotificación: Nueva categoría creada');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY', 'Categoría modificada');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_CAP', 'Notificar cuando una categoría sea modificada.');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_DSC', 'Recibir notificación cuando una categoría sea modificada.');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Autonotificación: categoría modificada');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY', 'Nuevo artículo');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_CAP', 'Notificar la publicación de un nuevo artículo.');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_DSC', 'Recibir notificación cuando un nuevo artículo sea publicado.');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Autonotificación: New file');
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY', 'New artículo en la categoría');
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_CAP', 'Notificar cuando un nuevo artículo sea publicado en esta categoría.');   
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_DSC', 'Recibir notificación cuando un nuevo artículo sea publicado en esta categoría.');      
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Autonotificación: Nuevo artículo publicado'); 
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY', 'Artículo modificado');
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_CAP', 'Notificar la modificación de este artículo.');
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_DSC', 'Recibir notificación cuando este artículo sea modificado.');
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Autonotificación: artículo modificado');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY', 'Artículo modificado');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_CAP', 'Notifar cuando se modifique un artículo de esta categoría.');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_DSC', 'Recibir notificación cuando un artículo de esta categoría sea modificado.');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Autonotificación: artículo modificado');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY', 'Artículo modificado');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_CAP', 'Notificar la modificación de cualquier artículo de esta página.');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_DSC', 'Recibir notificación cuando cualquier artículo sea modificado.');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Autonotificación: artículo modificado');

// ACP menu
define("_MI_ARTICLE_MENU_INDEX", "Índice");
define("_MI_ARTICLE_MENU_ARTICLE", "Artículos");
define("_MI_ARTICLE_MENU_CATEGORY", "Categorías");
define("_MI_ARTICLE_MENU_INDEXPAGE", "Página principal");
define("_MI_ARTICLE_MENU_PERMISSIONS", "Permisos");
define("_MI_ARTICLE_MENU_TEMPLATES", "Plantillas");
define("_MI_ARTICLE_MENU_MANUAL", "Manual");
define("_MI_ARTICLE_MENU_IMPORT", "Importar");
// Submenu while calling a tab
define("_MI_ARTICLE_ARTICLE_EDIT", "Modificar artículo");
define("_MI_ARTICLE_ARTICLE_CREATINGNEW", "Enviar artículo");
define("_MI_ARTICLE_CATEGORY_EDIT", "Modificar categoría");
define("_MI_ARTICLE_CATEGORY_CREATINGNEW", "Crear categoría");
/**
 * added in 1.1
 */
//preferences
define("_MI_ARTICLE_RSSLIMIT", "Límite de RSS");
define("_MI_ARTICLE_RSSLIMIT_DSC", "Número de artículos a mostrar en RSS");