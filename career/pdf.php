<?php
/**
 * 'Article' is an career management module for ImpressCMS
 *
 * File: /pdf.php
 * 
 * pdf print for single career
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

include_once 'header.php';

$clean_career_id = isset($_GET['career_id']) ? filter_input(INPUT_GET, 'career_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$item_page_id = isset($_GET['page']) ? intval($_GET['page']) : -1;

if ($clean_career_id == 0) {
	redirect_header(icms_getPreviousPage(), 3, _MD_CAREER_NO_CAREER);
}

$career_career_handler = icms_getModuleHandler("career", basename(dirname(__FILE__)), "career");
$careerObj = $career_career_handler->get($clean_career_id);

if (!$careerObj || !is_object($careerObj) || $careerObj->isNew()) {
	redirect_header(icms_getPreviousPage(), 3, _MD_CAREER_NO_CAREER);
}

if (!$careerObj->accessGranted()) {
	redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
}

$career = $careerObj->toArray();
$doc_title = '<h1><a href="' . ICMS_URL . '/modules/career/career.php?career_id=' . $clean_career_id . '" title="' . $career['title'] . '">' . $career['title'] . '</a></h1><br /><br />';
$content = '<a href="' . ICMS_URL . '/modules/career/career.php?career_id=' . $clean_career_id . '" title="' . $career['title'] . '">' . $career['title'] . '</a><br /><br />';
$content .= _MD_CAREER_CATS . ' : ' . $career['department'] . '<br />'; 
$content .= _MD_CAREER_PUBLISHER . ' : ' . $career['submitter'] . '<br /><br />';
$content .= strip_tags($career['dsc']);
$content .= $careerConfig['career_print_footer'];
$doc_keywords = $careerObj->getVar('meta_kewywords');
require_once ICMS_PDF_LIB_PATH.'/tcpdf.php';
	icms_loadLanguageFile('core', 'pdf');
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE);
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor(PDF_AUTHOR);
	$pdf->SetTitle($doc_title);
	$pdf->SetSubject($doc_title);
	$pdf->SetKeywords($doc_keywords);
	$sitename = $icmsConfig['sitename'];
	$siteslogan = $icmsConfig['slogan'];
	$pdfheader = icms_core_DataFilter::undoHtmlSpecialChars($sitename.' - '.$siteslogan);
	$pdf->SetHeaderData($careerConfig['career_print_logo'], PDF_HEADER_LOGO_WIDTH, $pdfheader, ICMS_URL);

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

