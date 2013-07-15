<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/print.php
 *
 * print manual
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

include_once 'admin_header.php';

icms_loadLanguageFile("tools", "modinfo");

icms::$logger->disableLogger();

$clean_print = isset($_GET['print']) ? filter_input(INPUT_GET, 'print', FILTER_SANITIZE_STRING) : 'manual';

$valid_print = array("manual", "pdf");

if(in_array($clean_print, $valid_print, TRUE)) {
	switch ($clean_print) {
		case 'manual':
			global $icmsConfig;
			$file = "/manual.html";
			$lang = "language/" . $icmsConfig['language'];
			$manual = TOOLS_ROOT_PATH . "$lang/$file";
			if (!file_exists($manual)) {
				$lang = 'language/english';
				$manual = TOOLS_ROOT_PATH . "$lang/$file";
			}
			$title = _MI_TOOLS_MD_NAME."&nbsp;&raquo;"._MI_TOOLS_MENU_MANUAL."&laquo;";
			$dsc = _MI_TOOLS_MD_DESC;
			$content = file_get_contents($manual);
			$print = icms_view_Printerfriendly::generate($content, $title, $dsc, $title);
			return $print;
			break;
		case 'pdf':
			require_once ICMS_PDF_LIB_PATH.'/tcpdf.php';

			class ToolsPDF extends TCPDF {

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
							$imgtype = TCPDF_IMAGES::getImageFileType(ICMS_ROOT_PATH.'/'.$headerdata['logo']);
							if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
								$this->ImageEps(ICMS_ROOT_PATH.'/'.$headerdata['logo'], '', '', $headerdata['logo_width']);
							} elseif ($imgtype == 'svg') {
								$this->ImageSVG(ICMS_ROOT_PATH.'/'.$headerdata['logo'], '', '', $headerdata['logo_width']);
							} else {
								$this->Image(ICMS_ROOT_PATH.'/'.$headerdata['logo'], '', '', $headerdata['logo_width']);
							}
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
					global $toolsConfig, $powered_by, $version, $icmsModule, $icmsConfig;

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
							str_replace(array("<!-- input filtered -->", "<!-- filtered with htmlpurifier -->"), array("", ""), $toolsConfig['print_footer']).'</tr></table>';
					$this->SetFont('helvetica', 'I', 8);
					//$this->writeHTMLCell(0, 30, '', '', $tbl, array('T' => array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0))), 0, false, TRUE, "C", true);
					$this->writeHTML($tbl, true, false, TRUE, TRUE, 'C');
				}
			}

			$pdf = new ToolsPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(icms_core_DataFilter::undoHtmlSpecialChars($icmsConfig['sitename']));
			$pdf->SetAuthor("Steffen Flohrer <QM-B>");
			$pdf->SetTitle(_MI_TOOLS_MD_NAME."&nbsp;&raquo;"._MI_TOOLS_MENU_MANUAL."&laquo;");
			$pdf->SetSubject(_MI_TOOLS_MD_NAME."&nbsp;&raquo;"._MI_TOOLS_MENU_MANUAL."&laquo;");
			$pdf->SetKeywords(_MI_TOOLS_MD_NAME,_MI_TOOLS_MENU_MANUAL);

			$sitename = $icmsConfig['sitename'];
			$siteslogan = $icmsConfig['slogan'];
			$pdfheader = "<p><a href='".ICMS_URL."' title='".$sitename."'>".$sitename."</a> - ".$siteslogan."</p><br><p>".$icmsModule->getVar("name").":<br>"._MI_TOOLS_MENU_MANUAL."</p><br>";
			$pdf->SetHeaderData($toolsConfig['print_logo'], PDF_HEADER_LOGO_WIDTH, $pdfheader, ICMS_URL);
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
			$TextFont = 'helvetica';
			$pdf -> SetFont($TextFont, '', 12);
			//initialize document
			$pdf->AddPage();
			$pdf->addHTMLTOC();
			$header = "<h1>"._MI_TOOLS_MENU_MANUAL.'</h1><hr />';
			$subheader = "<p><small>&copy; &nbsp;2011-".date("Y")." Steffen Flohrer <QM-B><br /> Author: Steffen Flohrer <QM-B>" . '</small></p>';
			$content = <<<EOF
						<style type='text/css'>
							hr {background-color:#15242a;border-bottom-color:#204656;margin:1.3em 0;} img {vertical-align: middle;}
							h1, h2, h3 {font-family: Georgia, 'Times New Roman', Times, serif; padding-bottom: 1em; padding-top: 1em; line-height: 1.7em; font-weight: bold;}
				        	h1 {text-align: center; font-size: 1.5em; font-variant: small caps; color: #336699;}
				        	h2 {font-size: 1.250em; color: #6699CC;}
				        	h3 {font-size: 1.1em; color: #6699FF;}
				        	p {font-size: .9em; margin: 0; padding: 5px;}
				        	ul li {list-style-type: square; margin-left: 10px; line-height: 1.5em; font-weight: bolder; }
				        	ul li ul li {list-style-type: disc; font-weight: normal; }
				        	a, a:visited {color: #336699}
				        	a:hover {color: #336699; text-decoration: underline;}
				        	#page_footer {margin: 2em auto; padding: 0 1em 2em;background-color: #0255A7; color: white;}
				        	#page_footer h2 {padding: .5em 0 0; color: white;}
				        	#page_footer a,#page_footer a:visited, #page_footer a:hover  {padding: .5em 0 0; color: #090909;}
				        	#page_footer p {font-family: Georgia, 'Times New Roman', Times, serif; font-size: 1em; }
							#credit {font-weight: bold;color: #336699;}
							.important {background-color:#FC8383; border: 1px dashed #FF0000; padding: 1em 0;}
							.important p {font-size: 1em; padding: 0 1em; color: #FF0000;}
							.highlighted {background-color:#e7fc12; padding: 0;}
							.tools_attention, .tools_ok {width: 90%;display: block; height: auto; margin: 1em 0;padding: 1em;}
							.tools_attention {background: #CD5C5C url(../images/attention_big.png) no-repeat scroll .5em center; color:#CD0A0A; border: 1px solid #CD0A0A;}
							.tools_ok {background: #b6fbbf url(../images/check.png) no-repeat scroll .5em center; color:#0bda28; border: 1px solid #0bda28;}
							.tools_attention p, .tools_ok p {padding-left: 40px;}
							a.tools_backup, a.tools_backup:visited, a.tools_backup:active, a.tools_backup:focus {
								font-size: 1em;background: none repeat scroll 0 0 #0254A6;color: white;display: inline-block;margin: 1em 0;padding: 4px 10px;transition: background 750ms ease 0s;
							}
							a.tools_backup:focus {outline-style: none;}
							a.tools_backup.tools_warning:hover, a.tools_backup:hover, a.tools_delete:hover {background: none repeat scroll 0 0 #333333; text-decoration: none;}
							a.tools_delete, a.tools_delete:visited, a.tools_backup.tools_warning, a.tools_backup.tools_warning:visited, a.tools_backup.tools_warning:active, a.tools_backup.tools_warning:focus {
								background: none repeat scroll 0 0 #CD0A0A;font-size: 1em;color: white;display: inline-block;margin: 1em 0;padding: 4px 10px;transition: background 750ms ease 0s;
							}
							.tools_attention p, p.tools_warning_old {color: #CD0A0A; font-weight: bold;}
						</style>
						$header . $subheader
EOF;

			$file = "manual.html";
			$lang = "language/" . $icmsConfig['language'];
			$manual = TOOLS_ROOT_PATH . "$lang/$file";
			if (!file_exists($manual)) {
				$lang = 'language/english';
				$manual = TOOLS_ROOT_PATH . "$lang/$file";
			}

    $context = stream_context_create($opts);
    $result = @file_get_contents($manual,false,$context);
			$content .= $result;
			$pdf->writeHTML($content, TRUE, FALSE, TRUE, TRUE, "L");

			$pdf->Output(ICMS_CACHE_PATH.'/'.'tools_manual.pdf', "I");
		break;
	}
} else {
	redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}
