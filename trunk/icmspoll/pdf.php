<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /pdf.php
 * 
 * pdf export for poll results
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: index.php 619 2012-06-28 08:34:35Z st.flohrer $
 * @package		icmspoll
 *
 */

include_once 'header.php';

$clean_poll_id = isset($_GET['poll_id']) ? filter_input(INPUT_GET, 'poll_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$item_page_id = isset($_GET['page']) ? (int)($_GET['page']) : -1;

if ($clean_poll_id == 0) {
	redirect_header(icms_getPreviousPage(), 3, _MD_ICMSPOLL_NO_POLL_SELECTED);
}

$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
$pollObj = $polls_handler->get($clean_poll_id);

if (!$pollObj || !is_object($pollObj) || $pollObj->isNew()) {
	redirect_header(icms_getPreviousPage(), 3, _MD_ICMSPOLL_NO_POLL_SELECTED);
}

if (!$pollObj->viewAccessGranted()) {
	redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}

$poll = $pollObj->toArray();
$content = '<a href="' . ICMS_URL . '/modules/icmspoll/index.php?poll_id=' . $clean_poll_id . '" title="' . $poll['question'] . '">' . $poll['question'] . '</a><br />';
$content .= _MD_ARTICLE_PUBLISHER . ' : ' . $poll['publisher'] . '<br />';
$content .= strip_tags(implode(" ", $poll['body_array']));
$content .= $icmspollConfig['icmspoll_print_footer'];

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
	$pdf->SetHeaderData($icmspollConfig['icmspoll_print_logo'], PDF_HEADER_LOGO_WIDTH, $pdfheader, ICMS_URL);

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

