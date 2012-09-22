<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /pdf.php
 * 
 * pdf print for single article
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

include_once 'header.php';

$clean_article_id = isset($_GET['article_id']) ? filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$item_page_id = isset($_GET['page']) ? (int)($_GET['page']) : -1;

if ($clean_article_id == 0) {
	redirect_header(icms_getPreviousPage(), 3, _MD_ARTICLE_NO_ARTICLE);
}

$article_article_handler = icms_getModuleHandler("article", ARTICLE_DIRNAME, "article");
$articleObj = $article_article_handler->get($clean_article_id);

if (!$articleObj || !is_object($articleObj) || $articleObj->isNew()) {
	redirect_header(icms_getPreviousPage(), 3, _MD_ARTICLE_NO_ARTICLE);
}

if (!$articleObj->accessGranted()) {
	redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}

$version = number_format(icms::$module->getVar('version')/100, 2);
$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;
$powered_by = " Powered by &nbsp;<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Icmspoll</a>";

$article = $articleObj->toArray();
$content = '<a href="' . ICMS_URL . '/modules/article/article.php?article_id=' . $clean_article_id . '" title="' . $article['title'] . '">' . $article['title'] . '</a><br />';
$content .= _MD_ARTICLE_CATS . ' : ' . $article['cats'] . '<br />'; 
$content .= _MD_ARTICLE_PUBLISHER . ' : ' . $article['publisher'] . '<br />';
$content .= strip_tags(implode(" ", $article['body_array']));
$content .= icms_core_DataFilter::undoHtmlSpecialChars($articleConfig['article_print_footer'] . $powered_by . "&nbsp;" . $version);

require_once ICMS_PDF_LIB_PATH.'/tcpdf.php';
	icms_loadLanguageFile('core', 'pdf');
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE);
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor(PDF_AUTHOR);
	$pdf->SetTitle($title);
	$pdf->SetSubject($title);
	$pdf->SetKeywords($keywords);
	$sitename = $icmsConfig['sitename'];
	$siteslogan = $icmsConfig['slogan'];
	$pdfheader = icms_core_DataFilter::undoHtmlSpecialChars($sitename.' - '.$siteslogan);
	$pdf->SetHeaderData($articleConfig['article_print_logo'], PDF_HEADER_LOGO_WIDTH, $pdfheader, ICMS_URL);

	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	$pdf->setLanguageArray($l); //set language items
	// set font
	$TextFont = (@_PDF_LOCAL_FONT && file_exists(ICMS_PDF_LIB_PATH.'/fonts/'._PDF_LOCAL_FONT.'.php')) ? _PDF_LOCAL_FONT : 'dejavusans';
	$pdf -> SetFont($TextFont);

	//initialize document
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->writeHTML($content, TRUE, 0);
	return $pdf->Output();

