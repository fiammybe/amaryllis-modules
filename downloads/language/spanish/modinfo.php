<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /language/spanish/modinfo.php
 *
 * Spanish language constants related to module information
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 			Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @translator	debianus
 * @version		$Id$
 * @package	downloads
 * 
 */

// general informations
define("_MI_DOWNLOADS_NAME", "Downloads");
define("_MI_DOWNLOADS_DSC", "'Downloads' es un módulo de gestión de descargas con organización de las mismas por categorías y etiquetas.");

// templates
define("_MI_DOWNLOADS_INDEX_TPL", "'Downloads': Página principal del módulo");
define("_MI_DOWNLOADS_HEADER_TPL", "'Downloads': header y breadcrumb");
define("_MI_DOWNLOADS_ADMIN_FORM_TPL", "'Downloads': formulario de la administración");
define("_AM_DOWNLOADS_REQUIREMENTS_TPL", "'Downloads': Comprobación de los requisitos");
define("_MI_DOWNLOADS_FOOTER_TPL", "'Downloads': footer (incluye las notificaciones y comentarios)");
define("_MI_DOWNLOADS_CATEGORY_TPL", "'Downloads': vista de categorías en la página principal");
define("_MI_DOWNLOADS_DOWNLOAD_TPL", "'Downloads': vista de archivo en la página principal");

// blocks
define("_MI_DOWNLOADS_BLOCK_RECENT_DOWNLOADS", "Últimas descargas");
define("_MI_DOWNLOADS_BLOCK_RECENT_DOWNLOADS_DSC", "Contiene las últimas descargas publicadas");
define("_MI_DOWNLOADS_BLOCK_RECENT_UPDATED", "Descargas acualizadas");
define("_MI_DOWNLOADS_BLOCK_RECENT_UPDATED_DSC", "Contiene una relación de las descargas actualizadas");
define("_MI_DOWNLOADS_BLOCK_MOST_POPULAR", "Más populares");
define("_MI_DOWNLOADS_BLOCK_MOST_POPULAR_DSC", "Descargas con más visitas");
define("_MI_DOWNLOADS_BLOCK_CATEGORY_MENU", "Categorías");
define("_MI_DOWNLOADS_BLOCK_CATEGORY_MENU_DSC", "Muestra todas las categorías o bien permite seleccionar una para mostrar las subcategorías");
/**
 * Added in 1.1
 */
define("_MI_DOWNLOADS_BLOCK_SPOTLIGHT_IMAGE", "Galería");
define("_MI_DOWNLOADS_BLOCK_SPOTLIGHT_IMAGE_DSC", "Muestra las descargas recientes con sus imágenes. Sólo se mostrarán aquellas que las tengan.");
/**
 * E N D added in 1.1
 */
// config
define("_MI_DOWNLOADS_AUTHORIZED_GROUPS", "Grupos que pueden crear categorías");
define("_MI_DOWNLOADS_AUTHORIZED_GROUPS_DSC", "Tenga en cuenta que un usuario que pertenezca a alguno de dichos grupos puede crear categorías sin necesidad de autorización por el administrador.");
define("_MI_DOWNLOADS_DATE_FORMAT", "Formato de fechas");
define("_MI_DOWNLOADS_DATE_FORMAT_DSC", "Más información en: <a href=\"http://php.net/manual/es/function.date.php\" target=\"blank\">php.net</a>");
define("_MI_DOWNLOADS_SHOW_BREADCRUMBS", "Mostrar breadcrumb");
define("_MI_DOWNLOADS_SHOW_BREADCRUMBS_DSC", "Seleccionado <em>Sí</em> se mostrará en el frontend");
define("_MI_DOWNLOADS_SHOW_DOWNLOADS", "Archivos a mostrar");
define("_MI_DOWNLOADS_SHOW_DOWNLOADS_DSC", "Determine el número de archivos a mostrar antes de aplicarse la paginación");
define("_MI_DOWNLOADS_SHOW_CATEGORIES", "Categorías a mostrar");
define("_MI_DOWNLOADS_SHOW_CATEGORIES_DSC", "Determine cuantas categorías se mostrarán en cada página");
define("_MI_DOWNLOADS_SHOW_CATEGORY_COLUMNS", "Columnas para las categorías");
define("_MI_DOWNLOADS_SHOW_CATEGORY_COLUMNS_DSC", "Determine el número de columnas que se mostrarán en la página principal para organizar las categorías");
define("_MI_DOWNLOADS_THUMBNAIL_WIDTH", "Anchura de las imágenes de cada archivo");
define("_MI_DOWNLOADS_THUMBNAIL_WIDTH_DSC", "Se refiere a las imágenes o capturas de pantallas que se añaden como información y determina la anchura con la que se mostrarán en la página");
define("_MI_DOWNLOADS_THUMBNAIL_HEIGHT", "Altura de las imágenes de cada archivo");
define("_MI_DOWNLOADS_THUMBNAIL_HEIGHT_DSC", "");
define("_MI_DOWNLOADS_FILE_THUMBNAIL_WIDTH", "Anchura de la imágen representativa del archivo");
define("_MI_DOWNLOADS_FILE_THUMBNAIL_WIDTH_DSC", "");
define("_MI_DOWNLOADS_FILE_THUMBNAIL_HEIGHT", "Altura de la imágen representativa del archivo");
define("_MI_DOWNLOADS_FILE_THUMBNAIL_HEIGHT_DSC", "");

define("_MI_DOWNLOADS_IMAGE_UPLOAD_WIDTH", "Anchura permitida para las imágenes a subir en el servidor");
define("_MI_DOWNLOADS_IMAGE_UPLOAD_WIDTH_DSC", "");
define("_MI_DOWNLOADS_IMAGE_UPLOAD_HEIGHT", "Altura permitida para las imágenes a subir en el servidor");
define("_MI_DOWNLOADS_IMAGE_UPLOAD_HEIGHT_DSC", "");
define("_MI_DOWNLOADS_IMAGE_FILE_SIZE", "Tamaño máximo de los archivos de imagen a subir en el servidor");
define("_MI_DOWNLOADS_IMAGE_FILE_SIZE_DSC", "");
define("_MI_DOWNLOADS_UPLOAD_FILE_SIZE", "Tamaño máximo de los archivos a subir en el servidor");
define("_MI_DOWNLOADS_UPLOAD_FILE_SIZE_DSC", "Son los que se descargarán por los visitantes");
define("_MI_DOWNLOADS_LIMITS", "Limitaciones");
define("_MI_DOWNLOADS_LIMITS_DSC", "Se pueden seleccionar en el proceso de creación de nuevas descargas. Cuando sean varias deben separarse con '|'");
define("_MI_DOWNLOADS_SHOWDISCLAIMER", "¿Mostrar aviso antes de que un usuario pueda añadir un nuevo archivo?");
define("_MI_DOWNLOADS_SHOWDISCLAIMER_DSC", "");
define("_MI_DOWNLOADS_DISCLAIMER", "Contenido del aviso previo a la creación de nuevos archivos");
define("_MI_DOWNLOADS_UPL_DISCLAIMER_TEXT", "<h1>Terms of Service for {X_SITENAME}:</h1>
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
define("_MI_DOWNLOADS_SHOW_DOWN_DISCL", "¿Mostrar información antes de que un usuario añada archivos?");
define("_MI_DOWNLOADS_SHOW_DOWN_DISCL_DSC", "");
define("_MI_DOWNLOADS_DOWN_DISCLAIMER", "Información previa a añadir archivos");
define("_MI_DOWNLOADS_DOWN_DISCLAIMER_TEXT", "<h1>TERMS OF USE</h1>
												<p>All products available for download through this site are provided by third party software/scripts publishers pursuant to license agreements or other arrangements between such publishers and the end user. We disclaim any responsibility for or liability related to the software/scripts. Any questions complaints or claims related to the software should be directed to the appropriate Author or Company responsible for developing the software. We make no representations or warranties of any kind concerning the quality, safety or suitability of the software/script, either expressed or implied, including without limitation any implied warranties of merchantability, fitness for a particular purpose, or non-infringement. We make no representation or warrantie as to the truth, accuracy or completeness of any statements, information or materials concerning the software/script that is contained on and within any of the websites owned and operated by us. In no event will we be liable for any indirect, punitive, special, incidental or consequential damages however they may arise and even if we have been previously advised of the possibility of such damages. There are inherent dangers in the use of any software/script available for download on the Internet, and we caution you to make sure that you completely understand the potential risks before downloading any of the software/scripts. You are solely responsible for adequate protection and backup of the data and equipment used in connection with any of the software, and we will not be liable for any damages that you may suffer in connection with using, modifying or distributing any of the software.</p>
												<h2>PRIVACY STATEMENT</h2>
												<p>We record visits to this web site and logs the following information for statistical purposes: the user's server or proxy address, the date/time of the visit and the files requested. The information is used to analyse our server traffic. No attempt will be made to identify users or their browsing activities except where authorized by law. For example in the event of an investigation, a law enforcement agency may exercise their legal authority to inspect the internet service provider's logs. If you send us an email message or contact as via contact form, we will record your contact details. This information will only be used for the purpose for which you have provided it. We will not use your email for any other purpose and will not disclose it without your consent except where such use or disclosure is permitted under an exception provided in the Privacy Act. When users choose to join a mailing list their details are added to that specific mailing list and used for the stated purpose of that list only.</p>
												<h2>LINKING</h2>
												<p>Links to external web sites are inserted for convenience and do not constitute endorsement of material at those sites, or any associated organization, product or service.</p>");
define("_MI_DOWNLOADS_PLATFORM", "Requisitos");
define("_MI_DOWNLOADS_PLATFORM_DSC", "Cuando sean varios deben separarse con '|'");
define("_MI_DOWNLOADS_LICENSE", "Licencia");
define("_MI_DOWNLOADS_LICENSE_DSC", "");
define("_MI_DOWNLOADS_USE_RSS", "¿Usar RSS?");
define("_MI_DOWNLOADS_USE_RSS_DSC", "En tal caso se mostrará un icono con un enlace.");
define("_MI_DOWNLOADS_NEED_VERSION_CONTROL", "¿Usar control de versiones?");
define("_MI_DOWNLOADS_NEED_VERSION_CONTROL_DSC", "En tal caso se mostrarán campos para indicar el número de la versión, su estado, el historial del archivo y las versiones previas");

define("_MI_DOWNLOADS_NEED_RELATED", "¿Usar archivos relacionados?");
define("_MI_DOWNLOADS_NEED_RELATED_DSC", "En tal caso se mostrará una lista con todos los existentes para seleccionar los que se considere convenientes.");

define("_MI_DOWNLOADS_NEED_DEMO", "¿Necesita enlace a sitio demo");
define("_MI_DOWNLOADS_NEED_DEMO_DSC", "");

define("_MI_DOWNLOADS_NEED_REQUIREMENTS", "¿Necesita indicar requisitos?");
define("_MI_DOWNLOADS_NEED_REQUIREMENTS_DSC", "");
define("_MI_DOWNLOADS_NEED_KEYFEATURES", "¿Necesita indicar características principales?");
define("_MI_DOWNLOADS_NEED_KEYFEATURES_DSC", "");

define("_MI_DOWNLOADS_USE_SPROCKETS", "¿Usar el módulo 'Sprockets'?");
define("_MI_DOWNLOADS_USE_SPROCKETS_DSC", "Si quiere usar etiquetas seleccione esta opción. Por supuesto dicho módulo deberá estar instalado.");

define("_MI_DOWNLOADS_USE_CATALOGUE", "¿Usar el módulo 'Catalogue'?");
define("_MI_DOWNLOADS_USE_CATALOGUE_DSC", "En tal caso se mostrará una lista con las entradas de dicho módulo para enlazar con los contenido de éste y se mostrará el precio. En lugar de descargarse un archivo se añade el contenido enlace al carro de la compra.");
define("_MI_DOWNLOADS_USE_ALBUM", "¿Usar el módulo 'Album'?");
define("_MI_DOWNLOADS_USE_ALBUM_DSC", "En tal caso se usará el mismo para gestionar las imágenes de cada archivo y podrá añadir las que desee en lugar de las cuatro que se pueden añadir en éste módulo.");
define("_MI_DOWNLOADS_USE_MIRROR", "¿Usar servidores o repositorios externos?");
define("_MI_DOWNLOADS_USE_MIRROR_DSC", "");
define("_MI_DOWNLOADS_MIRROR_APPROVE", "¿Quiere aprobar los nuevos servidores o repositorios externos?");
define("_MI_DOWNLOADS_MIRROR_APPROVE_DSC", "");
define("_MI_DOWNLOADS_DOWNLOAD_APPROVE", "¿Aprobación previa de nuevos archivos?");
define("_MI_DOWNLOADS_DOWNLOAD_APPROVE_DSC", "En tal caso antes de que se muestren los archivos subidos usando el módulo (no en la administración) deberán aprobarse por los administradores.");
define("_MI_DOWNLOADS_CATEGORY_APPROVE", "Do you need approvals for new categories?");
define("_MI_DOWNLOADS_CATEGORY_APPROVE_DSC", "Select 'YES' if you prefer to approve the new categories created on frontend first, before providing the link");
define("_MI_DOWNLOADS_GUEST_CAN_VOTE", "¿Puden votar los usuarios anónimos?");
define("_MI_DOWNLOADS_GUEST_CAN_VOTE_DSC", "Si no es así se mostrará una ventana emergente para acceder o registrarse en el sitio.");
define("_MI_DOWNLOADS_GUEST_CAN_REVIEW", "¿Pueden los usuarios anónimos enviar revisiones?");
define("_MI_DOWNLOADS_GUEST_CAN_REVIEW_DSC", "SSi no es así se mostrará una ventana emergente para acceder o registrarse en el sitio.");
define("_MI_DOWNLOADS_SHOW_REVIEWS", "¿Mostrar revisiones?");
define("_MI_DOWNLOADS_SHOW_REVIEWS_DSC", "En tal caso aparecerá una solapa para mostrarlas en cada archivo.");
define("_MI_DOWNLOADS_SHOW_REVIEWS_EMAIL", "Mostrar email de los autores de las revisiones?");
define("_MI_DOWNLOADS_SHOW_REVIEWS_EMAIL_DSC", "");
define("_MI_DOWNLOADS_SHOW_REVIEWS_AVATAR", "¿Mostrar avatar de los usuarios en las revisiones?");
define("_MI_DOWNLOADS_SHOW_REVIEWS_AVATAR_DSC", "");
define("_MI_DOWNLOADS_REVIEWS_COUNT", "Número de las revisiones a mostrar en una sóla página");
define("_MI_DOWNLOADS_REVIEWS_ORDER", "Orden de las revisiones por fecha");
define("_MI_DOWNLOADS_DISPLAY_REVIEWS_EMAIL", "¿Cómo mostrar la dirección de correo electrónico?");
define("_MI_DOWNLOADS_DISPLAY_REVIEWS_EMAIL_DSC", "");
define("_MI_DOWNLOADS_DISPLAY_REVEMAIL_SPAMPROT", "Protección contra el spam basada en texto (cambia @)");
define("_MI_DOWNLOADS_DISPLAY_REVEMAIL_IMGPROT", "Protección contra el spam creando una imagen con la dirección");
define("_MI_DOWNLOADS_DISPLAY_REVEMAIL_SPAMPROT_BANNED", "Protección basada en texto com comprobación de IP bloqueadas");
define("_MI_DOWNLOADS_DISPLAY_REVEMAIL_IMGPROT_BANNED", "Protección basada en imagen com comprobación de IP bloqueadas");

define("_MI_DOWNLOADS_DISPLAY_FILE_SIZE", "¿Cómo mostrar el tamaño del archivo?");
define("_MI_DOWNLOADS_DISPLAY_FILE_SIZE_DSC", "Las opciones son 'byte', 'mb' y 'gb'");

define("_MI_DOWNLOADS_POPULAR", "Número de descargas necesarias para que un archivo sea considerado 'Popular'");
define("_MI_DOWNLOADS_DAYSNEW", "Días para considerar como nuevo un archivo");
define("_MI_DOWNLOADS_DAYSUPDATED", "Días para considerar como actualizado un archivo después de ser modificado");
// Notifications
define('_MI_DOWNLOADS_GLOBAL_NOTIFY', 'Global');
define('_MI_DOWNLOADS_GLOBAL_NOTIFY_DSC', 'Opciones globales de notificación.');

define('_MI_DOWNLOADS_CATEGORY_NOTIFY', 'Categoria');
define('_MI_DOWNLOADS_CATEGORY_NOTIFY_DSC', 'Opciones de notificación de la presente categoría.');

define('_MI_DOWNLOADS_FILE_NOTIFY', 'Archivo');
define('_MI_DOWNLOADS_FILE_NOTIFY_DSC', 'Opciones de notificación referidas al presente archivo.');

define('_MI_DOWNLOADS_GLOBAL_CATSUBMIT_NOTIFY', 'Categoría añadida');
define('_MI_DOWNLOADS_GLOBAL_CATSUBMIT_NOTIFY_CAP', 'Notificarme cuando una categoría sea añadida.');
define('_MI_DOWNLOADS_GLOBAL_CATSUBMIT_NOTIFY_DSC', 'Recibir notification cuando una categoría sea añadida (esperando aprobación).');
define('_MI_DOWNLOADS_GLOBAL_CATSUBMIT_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: Nueva categoría añadida');

define('_MI_DOWNLOADS_GLOBAL_NEWCATEGORY_NOTIFY', 'Nueva categoría');
define('_MI_DOWNLOADS_GLOBAL_NEWCATEGORY_NOTIFY_CAP', 'Notificarme cuando una categoría sea añadida.');
define('_MI_DOWNLOADS_GLOBAL_NEWCATEGORY_NOTIFY_DSC', 'Recibir notification cuando una categoría sea añadida');
define('_MI_DOWNLOADS_GLOBAL_NEWCATEGORY_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: Nueva categoría añadida');

define('_MI_DOWNLOADS_GLOBAL_CATEGORYMODIFIED_NOTIFY', 'Categoría modificada');
define('_MI_DOWNLOADS_GLOBAL_CATEGORYMODIFIED_NOTIFY_CAP', 'Notificarme cuando una categoría sea modificada.');
define('_MI_DOWNLOADS_GLOBAL_CATEGORYMODIFIED_NOTIFY_DSC', 'Recibir notification cuando cuando una categoría sea modificada.');
define('_MI_DOWNLOADS_GLOBAL_CATEGORYMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: categoría modificada');

define('_MI_DOWNLOADS_GLOBAL_FILEBROKEN_NOTIFY', 'Archivo roto reportado');
define('_MI_DOWNLOADS_GLOBAL_FILEBROKEN_NOTIFY_CAP', 'Notificarme cuando se reporte que un archivo está roto.');
define('_MI_DOWNLOADS_GLOBAL_FILEBROKEN_NOTIFY_DSC', 'Recibir notification cuando se reporte que un archivo está roto.');
define('_MI_DOWNLOADS_GLOBAL_FILEBROKEN_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: archivo roto reportado');

define('_MI_DOWNLOADS_GLOBAL_FILESUBMIT_NOTIFY', 'Archivo enviado');
define('_MI_DOWNLOADS_GLOBAL_FILESUBMIT_NOTIFY_CAP', 'Notificarme cuando un nuevo archivo sea enviado (esperando aprobación).');
define('_MI_DOWNLOADS_GLOBAL_FILESUBMIT_NOTIFY_DSC', 'Recibir notification cuando un nuevo archivo sea enviado (esperando aprobación).');
define('_MI_DOWNLOADS_GLOBAL_FILESUBMIT_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: Nuevo archivo enviado');

define('_MI_DOWNLOADS_GLOBAL_NEWFILE_NOTIFY', 'Nuevo archivo');
define('_MI_DOWNLOADS_GLOBAL_NEWFILE_NOTIFY_CAP', 'Notificarme cuando un nuevo archivo sea publicado.');
define('_MI_DOWNLOADS_GLOBAL_NEWFILE_NOTIFY_DSC', 'Recibir notification cuando un nuevo archivo sea publicado.');
define('_MI_DOWNLOADS_GLOBAL_NEWFILE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: Nuevo archivo');

define('_MI_DOWNLOADS_CATEGORY_FILESUBMIT_NOTIFY', 'Archivo enviado');
define('_MI_DOWNLOADS_CATEGORY_FILESUBMIT_NOTIFY_CAP', 'Notificarme cuando un nuevo archivo sea enviado en esta categoría (esperando aprobación).');   
define('_MI_DOWNLOADS_CATEGORY_FILESUBMIT_NOTIFY_DSC', 'Recibir notification cuando un nuevo archivo sea enviado en esta categoría (esperando aprobación).');      
define('_MI_DOWNLOADS_CATEGORY_FILESUBMIT_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: Nuevo archivo enviado a esta categoría'); 

define('_MI_DOWNLOADS_CATEGORY_NEWFILE_NOTIFY', 'Nuevo archivo');
define('_MI_DOWNLOADS_CATEGORY_NEWFILE_NOTIFY_CAP', 'Notificarme cuando un nuevo archivo sea publicado en esta categoría.');   
define('_MI_DOWNLOADS_CATEGORY_NEWFILE_NOTIFY_DSC', '');      
define('_MI_DOWNLOADS_CATEGORY_NEWFILE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: Nuevo archivo en la categoría'); 

define('_MI_DOWNLOADS_FILE_APPROVE_NOTIFY', 'Archivo aprobado');
define('_MI_DOWNLOADS_FILE_APPROVE_NOTIFY_CAP', 'Notificarme cuando el archivo sea aprobado.');
define('_MI_DOWNLOADS_FILE_APPROVE_NOTIFY_DSC', 'Recibir notification cuando el archivo sea aprobado..');
define('_MI_DOWNLOADS_FILE_APPROVE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: archivo aprobado');

define('_MI_DOWNLOADS_FILE_FILEMODIFIED_NOTIFY', 'Archivo modificado');
define('_MI_DOWNLOADS_FILE_FILEMODIFIED_NOTIFY_CAP', 'Notificarme cuando este archivo sea modificado.');
define('_MI_DOWNLOADS_FILE_FILEMODIFIED_NOTIFY_DSC', 'Recibir notification cuando este archivo sea modificado.');
define('_MI_DOWNLOADS_FILE_FILEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: archivo modificado');

define('_MI_DOWNLOADS_CATEGORY_FILEMODIFIED_NOTIFY', 'Archivo modificado');
define('_MI_DOWNLOADS_CATEGORY_FILEMODIFIED_NOTIFY_CAP', 'Notificarme cuando un archivo de esta categoría sea modificado.');
define('_MI_DOWNLOADS_CATEGORY_FILEMODIFIED_NOTIFY_DSC', 'Recibir notification cuando un archivo de esta categoría sea modificado.');
define('_MI_DOWNLOADS_CATEGORY_FILEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: archivo modificado');

define('_MI_DOWNLOADS_GLOBAL_FILEMODIFIED_NOTIFY', 'Archivo modificado');
define('_MI_DOWNLOADS_GLOBAL_FILEMODIFIED_NOTIFY_CAP', 'Notificarme cuando cualquier archivo sea modificado.');
define('_MI_DOWNLOADS_GLOBAL_FILEMODIFIED_NOTIFY_DSC', 'Recibir cuando cualquier archivo sea modificado.');
define('_MI_DOWNLOADS_GLOBAL_FILEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: archivo modificado');

define('_MI_DOWNLOADS_GLOBAL_REVIEWSUBMITTED_NOTIFY', 'Revisión enviada');
define('_MI_DOWNLOADS_GLOBAL_REVIEWSUBMITTED_NOTIFY_CAP', 'Notificarme cuando sea enviada una revisión.');
define('_MI_DOWNLOADS_GLOBAL_REVIEWSUBMITTED_NOTIFY_DSC', 'Recibir notificación cuando una revisión sea enviada.');
define('_MI_DOWNLOADS_GLOBAL_REVIEWSUBMITTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notificación: Revisión enviada');

// ACP menu
define("_MI_DOWNLOADS_MENU_INDEX", "Índice");
define("_MI_DOWNLOADS_MENU_DOWNLOAD", "Archivos");
define("_MI_DOWNLOADS_MENU_CATEGORY", "Categorías");
define("_MI_DOWNLOADS_MENU_INDEXPAGE", "Página índice");
define("_MI_DOWNLOADS_MENU_TEMPLATES", "Plantillas");
define("_MI_DOWNLOADS_MENU_RATINGS", "Ratings");
define("_MI_DOWNLOADS_MENU_MANUAL", "Manual");
define("_MI_DOWNLOADS_MENU_REVIEW", "Revisiones");
define("_MI_DOWNLOADS_MENU_PERMISSIONS", "Permisos");
define("_MI_DOWNLOADS_MENU_LOG", "Log");
// Submenu while calling a tab
define("_MI_DOWNLOADS_DOWNLOAD_EDIT", "Modificar archivo");
define("_MI_DOWNLOADS_DOWNLOAD_CREATINGNEW", "Añadir archivo");
define("_MI_DOWNLOADS_CATEGORY_EDIT", "Modificar categoría");
define("_MI_DOWNLOADS_CATEGORY_CREATINGNEW", "Crear categoría");
/**
 * added in 1.1
 */
// ACP memu
define("_MI_DOWNLOADS_MENU_IMPORT", "Importar");