<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /language/spanish/admin.php
 * 
 * spanish language constants
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

// Requirements
define("_AM_ARTICLE_REQUIREMENTS", "Requisitos");
define("_AM_ARTICLE_REQUIREMENTS_INFO", "Hemos revisado sus sistema y desafortunadamente no cumple los requisitos necesarios para el funcionamiento de este módulo.");
define("_AM_ARTICLE_REQUIREMENTS_ICMS_BUILD", "Article necesita al menos ImpressCMS 1.3.");
define("_AM_ARTICLE_REQUIREMENTS_SUPPORT", "Soporte: <a href='http://community.impresscms.org'>http://community.impresscms.org</a>.");
// constants for /admin/article.php
define("_AM_ARTICLE_ARTICLE_ADD", "Crear artículo");
define("_AM_ARTICLE_ARTICLE_EDIT", "Modificar artículo");
define("_AM_ARTICLE_ARTICLE_CREATE", "Crear un nuevo artículo");
define("_AM_ARTICLE_ARTICLE_CREATED", "El artículo fue envidado con éxito");
define("_AM_ARTICLE_ARTICLE_MODIFIED", "El artículo fue modificado con éxito");
define("_AM_ARTICLE_ARTICLE_OFFLINE", "No publicado");
define("_AM_ARTICLE_ARTICLE_ONLINE", "Publicado");
define("_AM_ARTICLE_ARTICLE_INBLOCK_TRUE", "Artículo visible en los bloques");
define("_AM_ARTICLE_ARTICLE_INBLOCK_FALSE", "Artículo oculto en los bloques");
define("_AM_ARTICLE_ARTICLE_APPROVED", "Aprobado");
define("_AM_ARTICLE_ARTICLE_DENIED", "Rechazado");
define("_AM_ARTICLE_ARTICLE_WEIGHTS_UPDATED", "Cambios realizados con éxito");
define("_AM_ARTICLE_NO_CAT_FOUND", "No se encontró la categoría");
// constants for admin/category.php
define("_AM_ARTICLE_CATEGORY_ADD", "Crear categoría");
define("_AM_ARTICLE_CATEGORY_EDIT", "Modificar categoría");
define("_AM_ARTICLE_CATEGORY_CREATE", "Crear nueva categoría");
define("_AM_ARTICLE_CATEGORY_CREATED", "La categoría se creó con éxito");
define("_AM_ARTICLE_CATEGORY_MODIFIED", "La categoría modificada con éxito");
define("_AM_ARTICLE_CATEGORY_OFFLINE", "No activa");
define("_AM_ARTICLE_CATEGORY_ONLINE", "Activa");
define("_AM_ARTICLE_CATEGORY_INBLOCK_TRUE", "Categoría visible en los bloques");
define("_AM_ARTICLE_CATEGORY_INBLOCK_FALSE", "Categoría no visible en los bloques");
define("_AM_ARTICLE_CATEGORY_APPROVED", "Categoría aprobada");
define("_AM_ARTICLE_CATEGORY_DENIED", "Categoría rechazada");
define("_AM_ARTICLE_CATEGORY_WEIGHTS_UPDATED", "La importancia de cada categoría ha sido actualizada con éxito");

// constants for /admin/indexpage.php
define("_AM_ARTICLE_INDEXPAGE_EDIT", "Página principal");
define("_AM_ARTICLE_INDEXPAGE_MODIFIED", "Página principal modificada");

//constants for admin/index.php
define("_AM_ARTICLE_INDEX_WARNING", "Es recomendable leer el Manual antes de empezar a usar el módulo");
define("_AM_ARTICLE_INDEX_TOTAL", "Total");
define("_AM_ARTICLE_FILES_IN", " Archivos en ");
define("_AM_ARTICLE_CATEGORIES", " Categorías");
define("_AM_ARTICLE_INDEX_BROKEN_FILES", "Reportes de archivos adjuntos erróneos");
define("_AM_ARTICLE_INDEX_NEED_APPROVAL_FILES", "Archivos pendientes de aprobación");
define("_AM_ARTICLE_INDEX_NEED_APPROVAL_CATS", "Categorías pendientes de aprobación");
define("_AM_ARTICLE_INDEX", "Índice");
// constants for permission Form
define("_AM_ARTICLE_PREMISSION_ARTICLE_VIEW", "Permisos para visualizar artículos");
define("_AM_ARTICLE_PREMISSION_CATEGORY_VIEW", "Permisos para visualizar categorías");
define("_AM_ARTICLE_PREMISSION_CATEGORY_SUBMIT", "Permisos para enviar artículos");
// import site
define("_AM_ARTICLE_IMPORT_SMARTSECTION_WARNING", "¡Tenga mucho cuidado! Compruebe que está usando ImpressCMS 1.3.x.<br />
Asimismo actualmente no debe tener instalado el módulo 'Downloads' ni haber creado artículos o categorías en este módulo<br />
En caso de haber usado el módulo Tags con SmartSection, primero necesita importar las etiquetas al módulo Sprockets.");