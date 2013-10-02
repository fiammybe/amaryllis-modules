<?php
/**
 * "Downloads" is a light weight download handling module for ImpressCMS
 *
 * File: /language/spanish/main.php
 *
 * Spanish language constants used in the user side of the module
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

// general used constants
define("_MD_DOWNLOADS_PUBLISHED_BY", "Publicado por");
define("_MD_DOWNLOADS_PUBLISHED_ON", "Publicado el");
define("_MD_DOWNLOADS_UPDATED_ON", "Actualizado el");
define("_MD_DOWNLOADS_SECURITY_CHECK_FAILED", "Fallo en la comprobación de seguridad.");
define("_MD_DOWNLOADS_ADMIN_PAGE", ":: Administración ::");
define("_MD_DOWNLOADS_SUBMIT", "Enviar");
// constants on index view
define("_MD_DOWNLOADS_DOWNLOAD_FILELIST", "Archivos en esta categoría");
define("_MD_DOWNLOADS_CATEGORY_SUBCATLIST", "Subcategorías");
define("_MD_DOWNLOADS_FILES", "Archivos");
define("_MD_DOWNLOADS_SUBCATS", "Subcategorías");
define("_MD_DOWNLOADS_SUBMIT_CAT", "Crear categoría");
define("_MD_DOWNLOADS_UPLOAD", "Añadir archivo");
define("_MD_DOWNLOADS_NOFILES", "Actualmente no hay archivos en esta categoría.");
define("_MD_DOWNLOADS_READ_MORE", "Información y descarga");
define("_MD_DOWNLOADS_NO_CATEGORY_DSC", "La categoría no tiene descripción.");
define("_MD_DOWNLOADS_NO_TEASER_TEXT", "No hay resumen de la información");

// constants on single file view
define("_MD_DOWNLOADS_DOWNLOAD", "Descargar");
define("_MD_DOWNLOADS_GOTO_ITEM", "Comprar");
define("_MD_DOWNLOADS_DOWNLOAD_USE_MIRROR", "O usar nuestro repositorio de descargas:");
define("_MD_DOWNLOADS_FILE_KEYFEATURES", "Características:");
define("_MD_DOWNLOADS_FILE_REQUIREMENTS", "Dependencias");
define("_MD_DOWNLOADS_FILE_RELATED", "Archivos relacionados");
define("_MD_DOWNLOADS_FILE_DEV", "Nombre:");
define("_MD_DOWNLOADS_FILE_DEV_HP", "Web:");
define("_MD_DOWNLOADS_FILE_VERSION", "Versión");
define("_MD_DOWNLOADS_FILE_VERSION_STATUS", "Estado:");
define("_MD_DOWNLOADS_FILE_PLATFORM", "Plataforma");
define("_MD_DOWNLOADS_FILE_LICENSE", "Licencia:");
define("_MD_DOWNLOADS_FILE_LIMITS", "Limitaciones:");
define("_MD_DOWNLOADS_FILE_LANGUAGE", "Lenguajes");
define("_MD_DOWNLOADS_SURE_BROKEN", "¿Está seguro de que existe un error en la descarga?");
define("_MD_DOWNLOADS_REPORT_BROKEN", "Reportar fallo");
define("_MD_DOWNLOADS_FILE_UPDATED", "Actualizado");
define("_MD_DOWNLOADS_FILE_NEW", "Nuevo");
define("_MD_DOWNLOADS_DOWNLOAD_INPROGRESS", "Descarga realizándose...");
define("_MD_DOWNLOADS_DOWNLOAD_START_IN", "Su descarga comenzará en tres segundos.<b>Espere, por favor</b>.");
define("_MD_DOWNLOADS_DOWNLOAD_START_NOT", "Si no comenzase, ");
define("_MD_DOWNLOADS_CLICK_HERE", "Haga clic aquí");
define("_MD_DOWNLOADS_MAILTO", "Recomendar");
define("_MD_DOWNLOADS_MAILTO_SBJ", "He%20encontrado%20un%20interesante%20archivo%20para%20dscargar");
define("_MD_DOWNLOADS_MAILTO_BDY", "He%20encontrado%20un%20interesante%20archivo%20para%20dscargar"); // @DAVID Please have a look for Mail body
define("_MD_DOWNLOADS_REVIEW", "Opiniones y sugerencias");
define("_MD_DOWNLOADS_REVIEW_PERM", "No tiene permisos para enviar comentarios o análisis. Acceda como usuario registrado o regístrse en el sitio.");
define("_MD_DOWNLOADS_REV_PERM", "No tiene permisos para ello");
define("_MD_DOWNLOADS_VOTE_PERM", "No tiene permisos para votar. Acceda como usuario registrado o regístrse en el sitio.");
define("_MD_DOWNLOADS_FILE_DOWNLOADED", "File downloaded");
define("_MD_DOWNLOADS_TAG_ADD", "Añadir etiqueta");
define("_MD_DOWNLOADS_TAGS_PERM", "No tiene permisos para añadir etiquetas. Acceda como usuario registrado o regístrse en el sitio.");
define("_MD_DOWNLOADS_TAG_PERM", "No tiene permisos para ello");
define("_MD_DOWNLOADS_DOWNLOAD_DEMO", "Demo");

// tabs
define("_MD_DOWNLOADS_FILE_GENERAL_INFORMATIONS", "Datos");
define("_MD_DOWNLOADS_FILE_DESCRIPTION", "Descripción");
define("_MD_DOWNLOADS_FILE_IMAGES", "Imágenes");
define("_MD_DOWNLOADS_FILE_INSTRUCTIONS", "Relevant");
define("_MD_DOWNLOADS_FILE_HISTORY", "Historial");
define("_MD_DOWNLOADS_FILE_REVIEWS", "Opiniones");
define("_MD_DOWNLOADS_COMMENT", "Comentario");
define("_MD_DOWNLOADS_COMMENTS", "Comentarios");

define("_MD_DOWNLOADS_PUBLISHER_MAIL", "Correo electrónico");
define("_MD_DOWNLOADS_CATS", "Categoría");
define("_MD_DOWNLOADS_TAGS", "Etiquetas");
define("_MD_DOWNLOADS_FILESIZE", "Tamaño");
define("_MD_DOWNLOADS_FILETYPE", "Tipo de archivo");

// used in ajax.php
define("_MD_DOWNLOADS_BROKEN_REPORTED", "Gracias por el aviso. Error reportado.");
define("_MD_DOWNLOADS_DOWNLOAD_START", "La descarga comenzará en breve.");
define("_MD_DOWNLOADS_THANKS_VOTING", "Gracias por su voto");
define("_MD_DOWNLOADS_ALLREADY_VOTED", "Ya ha votado");
define('_THANKS_SUBMISSION_TAG', 'Gracias por añadir una nueva etiqueta');
//for new file form
define("_MD_DOWNLOADS_DOWNLOAD_EDIT", "Modificar");
define("_MD_DOWNLOADS_DOWNLOAD_CREATE", "Añadir");
define("_MD_DOWNLOADS_DOWNLOAD_CREATED", "El nuevo archivo se añadió con éxito. Gracias.");
define("_MD_DOWNLOADS_DOWNLOAD_MODIFIED", "El nuevo archivo se modificó con éxito. Gracias.");
//for new cat form
define("_MD_DOWNLOADS_CATEGORY_CREATE", "Crear nueva categoría");
define("_MD_DOWNLOADS_CATEGORY_EDIT", "Modificar");
define("_MD_DOWNLOADS_CATEGORY_CREATED", "La cateogría se creó correctamente. Gracias.");
define("_MD_DOWNLOADS_CATEGORY_MODIFIED", "La cateogría se modificó correctamente. Gracias.");
// for review form
define("_MD_DOWNLOADS_REVIEW_ADD", "Enviar análisis");
define('_MD_DOWNLOADS_REVIEW_SUBMITTED', 'Análisis enviado');
define('_THANKS_SUBMISSION_REV', 'Gracias por en análisis enviado');