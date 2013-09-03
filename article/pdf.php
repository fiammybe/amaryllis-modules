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
$powered_by = " Powered by &nbsp;<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Article</a>";

$article = $articleObj->toArray();
require_once ICMS_PDF_LIB_PATH.'/tcpdf.php';

			class NewsPDF extends TCPDF {

				public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
					global $icmsConfig;
					parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
					include_once ICMS_ROOT_PATH.'/language/'.$icmsConfig['language'].'/pdf.php';
					$this->l = $l;
				}

				public function Header() {
					if ($this->header_xobjid < 0) {
						// start a new XObject Template
						$this->header_xobjid = $this->startTemplate($this->w, $this->tMargin);
						$headerfont = $this->getHeaderFont();
						$headerdata = $this->getHeaderData();
						$this->y = $this->header_margin;
						if ($this->rtl) {
							$this->x = $this->w - $this->original_rMargin;
						} else {
							$this->x = $this->original_lMargin;
						}
						if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
							/**
							 * @TODO uncomment this, if tcpdf has been upgraded
							 */
							/**
							$imgtype = TCPDF_IMAGES::getImageFileType(ICMS_ROOT_PATH.'/'.$headerdata['logo']);
							if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
								$this->ImageEps(ICMS_ROOT_PATH.'/'.$headerdata['logo'], '', '', $headerdata['logo_width']);
							} elseif ($imgtype == 'svg') {
								$this->ImageSVG(ICMS_ROOT_PATH.'/'.$headerdata['logo'], '', '', $headerdata['logo_width']);
							} else {
								$this->Image(ICMS_ROOT_PATH.'/'.$headerdata['logo'], '', '', $headerdata['logo_width']);
							}
							 *
							 */
							$this->Image(ICMS_ROOT_PATH.'/'.$headerdata['logo'], '', '', $headerdata['logo_width']);
							$imgy = $this->getImageRBY();
						} else {
							$imgy = $this->y;
						}
						$cell_height = round(($this->cell_height_ratio * $headerfont[2]) / $this->k, 2);
						// set starting margin for text data cell
						if ($this->getRTL()) {
							$header_x = $this->original_rMargin + ($headerdata['logo_width'] * 1.1);
						} else {
							$header_x = $this->original_lMargin + ($headerdata['logo_width'] * 1.1);
						}
						$cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1);
						$this->SetTextColorArray($this->header_text_color);
						// header title
						$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
						$this->SetX($header_x);
						$this->writeHTMLCell($cw, $cell_height, '', '', $headerdata['title'], 0, 1, false, TRUE, "C", true);
						// header string
						$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
						$this->SetX($header_x);
						$this->MultiCell(0, 0, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
						// print an ending header line
						$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
						$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
						if ($this->rtl) {
							$this->SetX($this->original_rMargin);
						} else {
							$this->SetX($this->original_lMargin);
						}
						$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
						$this->endTemplate();
					}
					// print header template
					$x = 0;
					$dx = 0;
					if (!$this->header_xobj_autoreset AND $this->booklet AND (($this->page % 2) == 0)) {
						// adjust margins for booklet mode
						$dx = ($this->original_lMargin - $this->original_rMargin);
					}
					if ($this->rtl) {
						$x = $this->w + $dx;
					} else {
						$x = 0 + $dx;
					}
					$this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', 'L', TRUE);
					if ($this->header_xobj_autoreset) {
						// reset header xobject template at each page
						$this->header_xobjid = -1;
					}
				}
				// Page footer
				public function Footer() {
					global $articleConfig, $powered_by, $version, $icmsModule, $icmsConfig;

					$cur_y = $this->y;
					$this->SetTextColorArray($this->footer_text_color);
					//set style for cell border
					$line_width = (0.85 / $this->k);
					$this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
					//print document barcode
					$barcode = $this->getBarcode();
					if (!empty($barcode)) {
						$this->Ln($line_width);
						$barcode_width = round(($this->w - $this->original_lMargin - $this->original_rMargin) / 3);
						$style = array(
							'position' => $this->rtl?'R':'L',
							'align' => $this->rtl?'R':'L',
							'stretch' => false,
							'fitwidth' => true,
							'cellfitalign' => '',
							'border' => false,
							'padding' => 0,
							'fgcolor' => array(0,0,0),
							'bgcolor' => false,
							'text' => false
						);
						$this->write1DBarcode($barcode, 'C128', '', $cur_y + $line_width, '', (($this->footer_margin / 3) - $line_width), 0.3, $style, '');
					}

					$w_page = isset($this->l['w_page']) ? $this->l['w_page'].' ' : '';
					if (empty($this->pagegroups)) {
						$pagenumtxt = $w_page.$this->getAliasNumPage().' / '.$this->getAliasNbPages();
					} else {
						$pagenumtxt = $w_page.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();
					}
					$this->SetY(-20);
					//Print page number
					if ($this->getRTL()) {
						$this->SetX($this->original_rMargin);
						//$this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');
					} else {
						$this->SetX($this->original_lMargin);
						//$this->Cell(0, 0, $this->getAliasRightShift().$pagenumtxt, 'T', 0, 'R');
					}
					$tbl = '<table border="0" cellpadding="0" cellspacing="0" align="center"><tr nobr="true"><td>'.$pagenumtxt.'</td><td>'.$powered_by.' '.$version.'</td></tr><tr nobr="true">'.
							str_replace(array("<!-- input filtered -->", "<!-- filtered with htmlpurifier -->"), array("", ""), $articleConfig['article_print_footer']).'</tr></table>';
					$this->SetFont('helvetica', 'I', 8);
					//$this->writeHTMLCell(0, 30, '', '', $tbl, array('T' => array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0))), 0, false, TRUE, "C", true);
					$this->writeHTML($tbl, true, false, TRUE, TRUE, 'C');
				}
			}

			$pdf = new NewsPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(icms_core_DataFilter::undoHtmlSpecialChars($icmsConfig['sitename']));
			$pdf->SetAuthor($article['submitter']);
			$pdf->SetTitle($article['title']);
			$pdf->SetSubject($article['title']);
			$pdf->SetKeywords($article['meta_keywords']);

			$sitename = $icmsConfig['sitename'];
			$siteslogan = $icmsConfig['slogan'];
			$pdfheader = "<p><a href='".ICMS_URL."' title='".$sitename."'>".$sitename."</a> - ".$siteslogan."</p><br><p>".$icmsModule->getVar("name").":<br>".$articleObj->title()."</p><br>";
			$printlogo = ($articleConfig['article_print_logo'] !== "") ? $articleConfig['article_print_logo'] : "";
			$pdf->SetHeaderData($printlogo, PDF_HEADER_LOGO_WIDTH, $pdfheader, ICMS_URL);
			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			//set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			//set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			//set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			//$pdf->setLanguageArray($l); //set language items
			// set font
			/*
			 * @TODO uncomment this if public tcpdf has been updated and fixed..
			$TextFont = 'dejavusans';
			$pdf -> SetFont($TextFont, '', 12);
			 *
			 */
			//initialize document
			$pdf->AddPage();
			$pdf->addHTMLTOC();
			$content .= _MD_ARTICLE_CATS . ' : ' . $article['cats'] . '<br />'; 
			$content .= _MD_ARTICLE_PUBLISHER . ' : ' . $article['publisher'] . '<br />';
			if($article['imgpath']) {
				$pdf->setJPEGQuality(100);
				$content .= '<p style="text-align: center;"><img src="'.$article['imgpath'].'" title="'.$article['title'].'" style="float: left; display: inline-block;" /></p>';
			}
			$content .= implode("<br pagebreak='true' />", $article['body_array']);
			$content .= $article['conclusion'];
			$content .= icms_core_DataFilter::undoHtmlSpecialChars($articleConfig['article_print_footer'] . $powered_by . "&nbsp;" . $version);
			include_once ICMS_INCLUDE_PATH. '/im_multilanguage.php';
			$content = easiestml($content);
			$content = str_replace(array("<em>", "</em>"), array("<b>", "</b>"), $content);
			$pdf->writeHTML($content, TRUE, FALSE, TRUE, TRUE, "L");

			$pdf->Output(ICMS_ROOT_PATH.'/cache/'. $article['short_url'].'.pdf', "I");
