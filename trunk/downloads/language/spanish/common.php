<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /language/spanish/common.php
 *
 * english language constants commonly used in the module
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

//some general language constants
define("_CO_DOWNLOADS_PREVIEW", "Vista previa");
define("_CO_DOWNLOADS_EDIT", "Modificar");
if(!defined("_CO_SUBMIT")) define("_CO_SUBMIT", "Enviar");
define("_CO_DOWNLOADS_DELETE", "Eliminar");
define("_CO_DOWNLOADS_VIEW", "Ver");
if(!defined("_NO_PERM")) define("_NO_PERM", "Hubo un problema con la configuración de los permisos");

define("_CO_DOWNLOADS_MODIFIED", "Modificado");
if(!defined("_ER_UP_UNKNOWNFILETYPEREJECTED")) define("_ER_UP_UNKNOWNFILETYPEREJECTED", "Tipo de archivo desconocido");
// language constants for adding new file
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TITLE", "Título");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TITLE_DSC", "Establezca el título del archivo");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_CID", "Categoría");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_CID_DSC", "El archivo será incluido en la misma");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISHED_DATE", "Fecha de publicación");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISHED_DATE_DSC", "  ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_UPDATED_DATE", "Fecha de actualización");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_UPDATED_DATE_DSC", "  ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_IMG", "Imagen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_IMG_DSC", " Se mostrará cuando se muestre la lista de archivos");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DESCRIPTION", "Descripción");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DESCRIPTION_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_ACTIVE", "Activo");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_ACTIVE_DSC", "Seleccionado 'Sí' se motrará el archivo como tal");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_INBLOCKS", "Bloques");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_INBLOCKS_DSC", "Seleccionado 'Sí' se motrará el archivo en el bloque de <em>Descargas recientes</em>");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_APPROVE", "Aprobado");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_APPROVE_DSC", "De forma predeterminada se aprueban los archivos añadidos en la administración del módulo. Pero cuando un usuario los añade y está seleccionada la necesidad de aprobación en las preferencias del módulo, debe aprobarse el archivo añadido en la administración.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISHER", "Publicó");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISHER_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SUBMITTER", "Envió");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEV", "Desarrollador");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEV_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_GRPPERM", "Permisos para ver");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_GRPPERM_DSC", " Seleccione los grupos que podrán ver este archivo. Los usuarios que pertenezcan a uno de ellos podrá verlo si está activo' ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE", "Añadir archivo");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_DSC", "  ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_ALT", "O seleccione alguno");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_ALT_DSC", "Suba un archivo en <em>upload/downloads/download/</em> e introduzca aquí el nombre del mismo. Por ejemplo: <em>archivo.zip</em>.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_LINK", "Select <b>first</b> file version");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_LINK_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_HISTORY", "Historial");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_HISTORY_DSC", "Se permite HTML, pero básico.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TEASER", "Introducción");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TEASER_DSC", "Una o dos frases son suficientes; el texto se mostrará en la vista de índice.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LANGUAGE", "Lenguaje");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LANGUAGE_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_KEYFEATURES", "Características principales");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_KEYFEATURES_DSC", "Si son varios use | para separarlos.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_REQUIREMENTS", "Requisitos");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_REQUIREMENTS_DSC", "Si son varios use | para separarlos.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_RELATED", "Archivos relacionados");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_RELATED_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SCREEN_1", "1ª imagen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SCREEN_2", "2ª imagen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SCREEN_3", "3ª imagen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SCREEN_4", "4ª imagen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION", "Versión número");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_STATUS", "Status");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_STATUS_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_FINAL", "Final");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_ALPHA", "Alpha");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_BETA", "Beta");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_RC", "Release Candidate");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_NONE", "Ninguno");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_DEPRECATED", "Esta versión es anticuada. Por favor use la más reciente.");

define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LIMITATIONS", "Limitaciones");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LIMITATIONS_DSC", " ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LICENSE", "Licencia");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LICENSE_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PLATFORM", "Plataforma");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PLATFORM_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_URL", "Repositorio o servidor");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_URL_DSC", "Introduzca el URL completo. Por ej.: <em>http://www.myhomepage.de/files/file.rar</em>");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_TITLE", "Nombre");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_TITLE_DSC", "El mismo se mostrará en lugar del URL");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEV_HP", "Web del desarrollador");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEV_HP_DSC", "Debe ponerse el URL completo. Ejemplo:'http://www.example.com/'");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEMO", "Demo");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEMO_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_UPDATED", "¿Actualizado?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_UPDATED_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_CATALOGUE_ITEM", "Seleccione un item");
define("_CO_DOWNLOADS_DOWNLOAD_CATALOGUE_ITEM_DSC", "Se mostrará entonces el precio y un enlace al módulo <em>Catalogue</em> en lugar del enlace para descargar.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_ALBUM", "Seleccione un album");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_ALBUM_DSC", "Cuando selecciona en las preferencias usar el módulo <em>Album</em> las imágenes que se mostrarán en el archivo procederán del album seleccionado");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_BROKEN", "¿Roto?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_BROKEN_DSC", "Así aparecerá cuando se haya reportado como roto el archivo y no se pueda descargar");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_HAS_MIRROR", "Repositorio o servidor?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_APPROVE", "¿Servidor aprobado?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TAGS", "Etiquetas");

define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_IMAGES", "Añada imágenes o capturas de pantalla");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_DESCRIPTIONS", "Describa el archivo");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_HANDLING", "Servidor de descarga");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEVELOPER_INFO", "Información del desarrollador");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISH_INFO", "Información del archivo");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VIEW_SECTION", "Permisos");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_STATIC_SECTION", "Información adicional");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DOWNCOUNTER", "Descargado");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LIKE", "+");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DISLIKE", "-");
// language constants for editing indexpage
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_HEADER", "Título");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_HEADER_DSC", "Se mostrará en la página principal del módulo.");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_HEADING", "Descripción");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_HEADING_DSC", "  ");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_IMAGE", "Imagen");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_IMAGE_DSC", "");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_IMG_UPLOAD", "Añadir imagen");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_FOOTER", "Pie de página");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_FOOTER_DSC", "");
// language constants for adding new categories
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_TITLE", "Título");
define("_CO_DOWNLOADS_CATEGORY_WEIGHT", "Importancia");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_PID", "Categoría raíz");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_PID_DSC", "");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_IMG", "Imagen");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_IMG_UPLOAD", "");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_DESCRIPTION", "Descripción");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_DESCRIPTION_DSC", "");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_ACTIVE", "¿Activa?");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_ACTIVE_DSC", "");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_INBLOCKS", "¿Mostrar en los bloques?");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_INBLOCKS_DSC", "En tal caso se mostrará en el bloque Mostrar categorías");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_APPROVE", "¿Aprobada?");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_APPROVE_DSC", "");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_PUBLISHER", "Publicó");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_GRPPERM", "Permisos para visualizar");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_GRPPERM_DSC", "");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_PUBLISHED_DATE", "Publicada el");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_UPDATED_DATE", "Actualizada el");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_SUBMITTER", "Publicó");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_UPLPERM", "Permisos para añadir archivos");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_UPLPERM_DSC", "");
// review system
define("_CO_DOWNLOADS_REVIEW_REVIEW_ITEM_ID", "Item");
define("_CO_DOWNLOADS_REVIEW_REVIEW_UID", "Usuario");
define("_CO_DOWNLOADS_REVIEW_REVIEW_NAME", "Nombre");
define("_CO_DOWNLOADS_REVIEW_REVIEW_CASE", "Asunto");
define("_CO_DOWNLOADS_REVIEW_REVIEW_EMAIL", "E-Mail");
define("_CO_DOWNLOADS_REVIEW_REVIEW_MESSAGE", "Mensaje");
define("_CO_DOWNLOADS_REVIEW_REVIEW_MESSAGE_DSC", 'Puede usar HTML. Las etiquetas permitidas son &lt;b&gt; por <b>bold</b>, &lt;i&gt; por <i>italic</i> Text, &lt;a&gt; para enlaces y &lt;br&gt; para saltos de línea. Las demás serán omitidas.');
define("_CO_DOWNLOADS_REVIEW_REVIEW_DATE", "Fecha");
define("_CO_DOWNLOADS_REVIEW_PRAISE", "Ruego");
define("_CO_DOWNLOADS_REVIEW_SUGGESTION", "Sugerencia");
define("_CO_DOWNLOADS_REVIEW_PROBLEM", "Problema");
define("_CO_DOWNLOADS_REVIEW_QUESTION", "Pregunta");
// LOG system
define("_CO_DOWNLOADS_LOG_LOG_ITEM_ID", "Nombre");
define("_CO_DOWNLOADS_LOG_LOG_ITEM", "Item");
define("_CO_DOWNLOADS_LOG_LOG_IP", "IP");
define("_CO_DOWNLOADS_LOG_LOG_UID", "Usuario");
define("_CO_DOWNLOADS_LOG_LOG_CASE", "Registro");
define("_CO_DOWNLOADS_LOG_LOG_DATE", "Fecha");