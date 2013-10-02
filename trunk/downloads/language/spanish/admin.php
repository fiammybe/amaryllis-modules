<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /language/spanish/admin.php
 *
 * Spanish language constants used in admin section of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @translator	debianus
 * @version		$Id$
 * @package	downloads
 * 
 */

// Requirements
define("_AM_DOWNLOADS_REQUIREMENTS", "'Downloads' Requisitos");
define("_AM_DOWNLOADS_REQUIREMENTS_INFO", "Hemos revisado sus sistema y desafortunadamente no cumple los requisitos necesarios para el funcionamiento de este módulo..");
define("_AM_DOWNLOADS_REQUIREMENTS_ICMS_BUILD", "'Downloads' necesita como mínimo ImpressCMS 1.3 final.");
define("_AM_DOWNLOADS_REQUIREMENTS_SUPPORT", "Soporte: <a href='http://community.impresscms.org'>http://community.impresscms.org</a>.");
//Admin Index
define("_AM_DOWNLOADS_INDEX_WARNING", "<b>Debe leer el manual antes de usar el módulo para conocer los parámetros que debe configurar.</b>");
define("_AM_DOWNLOADS_INDEX", "Sumario");
define("_AM_DOWNLOADS_INDEX_TOTAL", "Actualmente hay");
define("_AM_DOWNLOADS_FILES_IN", "&nbsp;archivos en &nbsp;");
define("_AM_DOWNLOADS_CATEGORIES", "&nbsp; categorías");
define("_AM_DOWNLOADS_INDEX_BROKEN_FILES", "Archivos rotos:");
define("_AM_DOWNLOADS_INDEX_NEED_APPROVAL_FILES", "Pendientes de aprobación:");
define("_AM_DOWNLOADS_INDEX_NEED_APPROVAL_MIRRORS", "Repositorios para aprobar:");
define("_AM_DOWNLOADS_INDEX_NEED_APPROVAL_CATS", "Categorías pendientes de aprobar: &nbsp;");

// 
define("_AM_DOWNLOADS_DOWNLOAD_ADD", "Añadir archivo");
define("_AM_DOWNLOADS_CREATE", "Nuevo");
define("_AM_DOWNLOADS_EDIT", "Modificar");
define("_AM_DOWNLOADS_CREATED", "Creado con éxito");
define("_AM_DOWNLOADS_MODIFIED", "Modificado con éxito");
define("_AM_DOWNLOADS_ONLINE", "Online");
define("_AM_DOWNLOADS_OFFLINE", "Offline");
define("_AM_DOWNLOADS_DOWNLOAD_WEIGHTS_UPDATED", "Importancia actualizada");
define("_AM_DOWNLOADS_DOWNLOAD_NOFILEEXIST", "Archivo no encontrado");

define("_AM_DOWNLOADS_INDEXPAGE_EDIT", "Modificar la página principal");
define("_AM_DOWNLOADS_INDEXPAGE_MODIFIED", "Página principal modificada");

define("_AM_DOWNLOADS_CATEGORY_ADD", "Añadir categoría");
define("_AM_DOWNLOADS_CATEGORY_WEIGHTS_UPDATED", "Importancia actualizada");

define("_AM_DOWNLOADS_INBLOCK_TRUE", "Visible in bloques");
define("_AM_DOWNLOADS_INBLOCK_FALSE", "No mostrar en bloques");

define("_AM_DOWNLOADS_APPROVE_TRUE", "Approbado");
define("_AM_DOWNLOADS_APPROVE_FALSE", "Rechazado");

define("_AM_DOWNLOADS_MIRROR_FALSE", "Repositorio rechazado");
define("_AM_DOWNLOADS_MIRROR_TRUE", "Repositorio aprobado");

define("_AM_DOWNLOADS_NO_CAT_FOUND", "No se ha creado una categoría; es necesario que exista alguna para poder añadir descargas.");

// constants for permission Form
define("_AM_DOWNLOADS_PREMISSION_DOWNLOADS_VIEW", "Ver archivos");
define("_AM_DOWNLOADS_PREMISSION_CATEGORY_VIEW", "Ver categorías");
define("_AM_DOWNLOADS_PREMISSION_CATEGORY_SUBMIT", "Subir archivos");