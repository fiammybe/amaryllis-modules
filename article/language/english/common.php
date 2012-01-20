<?php
/**
 * English language constants commonly used in the module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		article
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// category
define("_CO_ARTICLE_CATEGORY_CATEGORY_TITLE", "Title");
define("_CO_ARTICLE_CATEGORY_CATEGORY_TITLE_DSC", "");
define("_CO_ARTICLE_CATEGORY_CATEGORY_DESCRIPRION", "Description");
define("_CO_ARTICLE_CATEGORY_CATEGORY_DESCRIPRION_DSC", "Describe your category (optional)");
define("_CO_ARTICLE_CATEGORY_CATEGORY_PID", "Parent Category");
define("_CO_ARTICLE_CATEGORY_CATEGORY_PID_DSC", "Select the parent category, if needed.");
define("_CO_ARTICLE_CATEGORY_CATEGORY_IMAGE", "Image");
define("_CO_ARTICLE_CATEGORY_CATEGORY_IMAGE_DSC", "Select an Image OR upload a new one");
define("_CO_ARTICLE_CATEGORY_CATEGORY_IMAGE_UPL", "Image Upload");
define("_CO_ARTICLE_CATEGORY_CATEGORY_IMAGE_UPL_DSC", "Upload a new category Imgage");
define("_CO_ARTICLE_CATEGORY_CATEGORY_SUBMITTER", "Submitter");
define("_CO_ARTICLE_CATEGORY_CATEGORY_SUBMITTER_DSC", "Submitter of the category");
define("_CO_ARTICLE_CATEGORY_CATEGORY_PUBLISHER", "Publisher");
define("_CO_ARTICLE_CATEGORY_CATEGORY_PUBLISHER_DSC", "Publisher of the category");
define("_CO_ARTICLE_CATEGORY_CATEGORY_PUBLISHED_DATE", "Published on");
define("_CO_ARTICLE_CATEGORY_CATEGORY_PUBLISHED_DATE_DSC", "");
define("_CO_ARTICLE_CATEGORY_CATEGORY_UPDATED_DATE", "Updated on");
define("_CO_ARTICLE_CATEGORY_CATEGORY_UPDATED_DATE_DSC", "");
define("_CO_ARTICLE_CATEGORY_CATEGORY_GRPPERM", "View permissions");
define("_CO_ARTICLE_CATEGORY_CATEGORY_GRPPERM_DSC", "");
define("_CO_ARTICLE_CATEGORY_CATEGORY_UPLPERM", "Submit permissions");
define("_CO_ARTICLE_CATEGORY_CATEGORY_UPLPERM_DSC", "");
define("_CO_ARTICLE_CATEGORY_CATEGORY_ACTIVE", "Active?");
define("_CO_ARTICLE_CATEGORY_CATEGORY_APPROVE", "Approved?");
define("_CO_ARTICLE_CATEGORY_CATEGORY_INBLOCKS", "In Blocks?");
define("_CO_ARTICLE_CATEGORY_CATEGORY_INBLOCKS_DSC", "Display category in blocks?");
define("_CO_ARTICLE_CATEGORY_CATEGORY_UPDATED", "Updated?");
define("_CO_ARTICLE_CATEGORY_CATEGORY_UPDATED_DSC", "Display category as updated?");

// article
define("_CO_ARTICLE_ARTICLE_ARTICLE_CID", "Category");
define("_CO_ARTICLE_ARTICLE_ARTICLE_CID_DSC", "Select the categories for this article");
define("_CO_ARTICLE_ARTICLE_ARTICLE_TITLE", "Title");
define("_CO_ARTICLE_ARTICLE_ARTICLE_TITLE_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_TEASER", "Teaser");
define("_CO_ARTICLE_ARTICLE_ARTICLE_TEASER_DSC", "Teaser of the Article");
define("_CO_ARTICLE_ARTICLE_ARTICLE_SHOW_TEASER", "Display Teaser?");
define("_CO_ARTICLE_ARTICLE_ARTICLE_BODY", "Body");
define("_CO_ARTICLE_ARTICLE_ARTICLE_BODY_DSC", "Body of the Article. You can use [pagebreak] to paginate your article.");
define("_CO_ARTICLE_ARTICLE_ARTICLE_RELATED", "Related articles");
define("_CO_ARTICLE_ARTICLE_ARTICLE_RELATED_DSC", "Select related Articles");
define("_CO_ARTICLE_ARTICLE_ARTICLE_SUBMITTER", "Submitter");
define("_CO_ARTICLE_ARTICLE_ARTICLE_SUBMITTER_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_PUBLISHER", "Published by");
define("_CO_ARTICLE_ARTICLE_ARTICLE_PUBLISHER_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_PUBLISHED_DATE", "Published on");
define("_CO_ARTICLE_ARTICLE_ARTICLE_PUBLISHED_DATE_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_UPDATED_DATE", "Updated on");
define("_CO_ARTICLE_ARTICLE_ARTICLE_UPDATED_DATE_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_TAGS", "Tags");
define("_CO_ARTICLE_ARTICLE_ARTICLE_TAGS_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_ATTACHMENT", "Attach a File");
define("_CO_ARTICLE_ARTICLE_ARTICLE_ATTACHMENT_DSC", "Upload a new file OR use the box below for an ftp-uploaded file");
define("_CO_ARTICLE_ARTICLE_ARTICLE_ATTACHMENT_ALT", "Or upload via ftp and insert the filename included extension here. e.g.: example.zip");
define("_CO_ARTICLE_ARTICLE_ARTICLE_UPDATER", "Last Updated by");
define("_CO_ARTICLE_ARTICLE_ARTICLE_UPDATER_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_APPROVE", "Approved");
define("_CO_ARTICLE_ARTICLE_ARTICLE_APPROVE_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_ACTIVE", "Active?");
define("_CO_ARTICLE_ARTICLE_ARTICLE_ACTIVE_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_UPDATED", "Updated?");
define("_CO_ARTICLE_ARTICLE_ARTICLE_UPDATED_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_INBLOCKS", "In Blocks?");
define("_CO_ARTICLE_ARTICLE_ARTICLE_INBLOCKS_DSC", "Display article in blocks?");
define("_CO_ARTICLE_ARTICLE_ARTICLE_CANCOMMENT", "Can comment?");
define("_CO_ARTICLE_ARTICLE_ARTICLE_CANCOMMENT_DSC", "Can Article be commented?");
define("_CO_ARTICLE_ARTICLE_ARTICLE_BROKEN_FILE", "Broken?");
define("_CO_ARTICLE_ARTICLE_ARTICLE_BROKEN_FILE_DSC", "Is the attachment broken?");
define("_CO_ARTICLE_ARTICLE_ARTICLE_GRPPERM", "View Permissions");
define("_CO_ARTICLE_ARTICLE_ARTICLE_GRPPERM_DSC", "");
define("_CO_ARTICLE_ARTICLE_ARTICLE_IMG", "Image");
define("_CO_ARTICLE_ARTICLE_ARTICLE_IMG_DSC", "Select an image or upload a new one");
define("_CO_ARTICLE_ARTICLE_ARTICLE_IMG_UPL", "Image Upload");
define("_CO_ARTICLE_ARTICLE_ARTICLE_IMG_UPL_DSC", "You can upload an image for your article. This image will be shown in article list and also on singleview");
// article form sections
define("_CO_ARTICLE_ARTICLE_ARTICLE_DESCRIPTIONS", "Main Content Part");
define("_CO_ARTICLE_ARTICLE_ARTICLE_INFORMATIONS", "Additional informations");
define("_CO_ARTICLE_ARTICLE_ARTICLE_PERMISSIONS", "Permission control");
define("_CO_ARTICLE_ARTICLE_ARTICLE_STATICS", "Static fields");
define("_CO_ARTICLE_ARTICLE_ARTICLE_ADDITIONALS", "Article Meta informations");
// some general constants
define("_ER_UP_UNKNOWNFILETYPEREJECTED", "Filetype unknown.");
define("_CO_ARTICLE_PREVIEW", "preview");
define("_CO_ARTICLE_EDIT", "edit");
if(!defined("_CO_SUBMIT")) define("_CO_SUBMIT", "submit");
define("_CO_ARTICLE_DELETE", "delete");
define("_CO_ARTICLE_VIEW", "view");
if(!defined("_NO_PERM")) define("_NO_PERM", "No permissions");

// indexpage
define("_CO_ARTICLE_INDEXPAGE_INDEX_HEADER", "Header");
define("_CO_ARTICLE_INDEXPAGE_INDEX_HEADER_DSC", "");
define("_CO_ARTICLE_INDEXPAGE_INDEX_HEADING", "Heading");
define("_CO_ARTICLE_INDEXPAGE_INDEX_HEADING_DSC", "");
define("_CO_ARTICLE_INDEXPAGE_INDEX_FOOTER", "Footer");
define("_CO_ARTICLE_INDEXPAGE_INDEX_FOOTER_DSC", "");
define("_CO_ARTICLE_INDEXPAGE_INDEX_IMAGE", "Image");
define("_CO_ARTICLE_INDEXPAGE_INDEX_IMAGE_DSC", "Select an index-Image OR upload a new one");
define("_CO_ARTICLE_INDEXPAGE_INDEX_IMG_UPL", "Upload new image");
define("_CO_ARTICLE_INDEXPAGE_INDEX_IMG_UPL_DSC", "");