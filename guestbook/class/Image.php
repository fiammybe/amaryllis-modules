<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /class/Image.php
 * 
 * Class to handle Images
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("INDEX_DIRNAME")) define("INDEX_DIRNAME", basename(dirname(dirname(__FILE__))));

/**
 * 
 */
class mod_guestbook_Image {
	
	// new created image
	protected $image;
	// width of the original image
	protected $width;
	// height of the original image
	protected $height;
    /**
     * image type
     * 1 = gif
     * 2 = jpeg
     * 3 = png
     */
    protected $imageType;
    //mime type of the image
    protected $mimetype;
    
	// resized image
	protected $resizedImage;
	
	/**
	 * path to the image to be resized
	 */
	protected $inputPath;
	// output path of the image
	protected $outputPath;
	// name of the image
	protected $fileName;
	// new name if needed
	protected $newName;
    
    public $layers = array();
    
    protected $lastLayerId = 0;
	
	/**
	 * constructor
	 * @param str $filename - image filename
	 * @param str $filepPath - path to image
	 * 
	 */
	function __construct($fileName = "", $filePath = "") {
	    $this->cleanVars();
	    if(!$fileName == "" && !$filePath == "") {
    		$this->inputPath = $filePath;
    		list($width, $height, $img_type, $attribute) = getimagesize($this->inputPath . $fileName);
    		$this->width  = $width;
    		$this->height = $height;
    		$this->imageType = $img_type;
            $this->mimetype = $attribute['mime'];
            
    		$this->fileName = $fileName;
    		$this->image = $this->openImage($fileName);
        }
	}
    
    private function cleanVars() {
        $this->image = "";
        $this->width = "";
        $this->height = "";
        $this->resizedImage = "";
        $this->outputPath = "";
        $this->fileName = "";
        $this->newName = "";
        $this->imageType = "";
        $this->inputPath = "";
        return TRUE;
    }
	
	private function openImage($file) {
		switch($this->imageType) {
			case 1:
				$img = @imagecreatefromgif($this->inputPath . $file);
				break;
			case 2:
				$img = @imagecreatefromjpeg($this->inputPath . $file);
				break;
			case 3:
				$img = @imagecreatefrompng($this->inputPath . $file);
				break;
		}
		return $img;
	}
	
    /**
     * dealing with layers
     */
    protected function addLayer() {
        
    }
    
    /**
     * resizing methods
     */
	public function resizeImage($newWidth, $newHeight, $outputPath, $quality = "100") {
		$this->outputPath = $outputPath;
		$this->newName = $this->fileName;
		$this->createPaths();
		$optionArray = $this->getSize($newWidth, $newHeight);
		$optimalWidth  = $optionArray['optimalWidth'];
		$optimalHeight = $optionArray['optimalHeight'];
		// *** Resample - create image canvas of x, y size
		$this->resizedImage = imagecreatetruecolor($optimalWidth, $optimalHeight);
		if($this->imageType == 3) {
			imagealphablending($this->resizedImage, FALSE);
			imagesavealpha($this->resizedImage, TRUE);
		}
		imagecopyresampled($this->resizedImage, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);
		if($this->saveImage($quality)) {
		    return TRUE;
        } else {
            return FALSE;
        }
	}
	
	public function resizeByPixel() {
		
	}
	
	public function resizeByPercent() {
		
	}
	
    public static function getPosition($imageWidth, $imageHeight, $layerWidth, $layerHeight, $layerPosX, $layerPosY, $pos = "TL") {
        $pos = strtoupper($pos);
        
        if($pos == "TL") {
            $layerPosX = $layerPosX;
            $layerPosY = $layerPosY;
        } elseif ($pos == "TC") {
            $layerPosX = (($imageWidth - $layerWidth) / 2) + $layerPosX;
        } elseif ($pos == "TR") {
            $layerPosX = $imageWidth - $layerWidth - $layerPosX;
        } elseif ($pos == "CL") {
            $layerPosY = (($imageHeight - $layerHeight) / 2) + $layerPosY;
        } elseif ($pos == "C") {
            $layerPosX = (($imageWidth - $layerWidth) / 2) + $layerPosX;
            $layerPosY = (($imageHeight - $layerHeight) / 2) + $layerPosY;
        } elseif ($pos == "CR") {
            $layerPosX = $imageWidth - $layerWidth - $layerPosX;
            $layerPosY = (($imageHeight - $layerHeight) / 2) + $layerPosY;
        } elseif ($pos == "BL") {
            $layerPosY = $imageHeight - $layerHeight - $layerPosY;
        } elseif ($pos == "BC") {
            $layerPosX = (($imageWidth - $layerWidth) / 2) + $layerPosX;
            $layerPosY = $imageHeight - $layerHeight - $layerPosY;
        } elseif ($pos == "BR") {
            $layerPosX = $imageWidth - $layerWidth - $layerPosX;
            $layerPosY = $imageHeight - $layerHeight - $layerPosY;
        } 
        
        return array(
            "x" => $layerPosX,
            "y" => $layerPosY,
        );
    }

	/**
	 * watermarking images with text
	 * 
	 * @param $source - is source of the image file to be watermarked
	 * @param $watermarkText - is the text of the watermark
	 * @param $dest - is the destination location where the watermarked images will be placed
	 * @param $color - Text color to be used (possible: black, blue, red, white, green)
	 * @param $pos - position of the watermark
	 * @param $font - font to be used should be in index/extras/fonts/
	 * @param $font_size - font size of watermark
	 * 
	 */
	public function watermarkImage ($watermarkText, $outputPath, $newName, $color, $pos, $font = "arial.ttf", $font_size = 20) {
		$this->outputPath = $outputPath;
		$this->newName = $newName;
		$this->resizedImage = imagecreatetruecolor($this->width, $this->height);
		if($this->imageType == 3) {
			imagealphablending($this->resizedImage, FALSE);
			imagesavealpha($this->resizedImage, TRUE);
		}
		imagecopyresampled($this->resizedImage, $this->image, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height); 
		switch ($color) {
			case 'black':
				$font_color = imagecolorallocate($this->resizedImage, 0, 0, 0);
				break;
			case 'blue':
				$font_color = imagecolorallocate($this->resizedImage, 0, 0, 255);
				break;
			case 'red':
				$font_color = imagecolorallocate($this->resizedImage, 255, 0, 0);
				break;
			case 'white':
				$font_color = imagecolorallocate($this->resizedImage, 255, 255, 255);
				break;
			case 'green':
				$font_color = imagecolorallocate($this->resizedImage, 0, 255, 0);
				break;
		}
		$font = '../extras/fonts/' . $font;
		$font_shadow = imagecolorallocate($this->resizedImage, 128, 128, 128);
		
		$box = @ImageTTFBBox($font_size,0,$font,$watermarkText);
		$t_width = abs($box[4] - $box[0]) + 10;
		$t_height = abs($box[5] - $box[1]) + 10;
		
		if($pos == "TL") {
	    	$dest_x = 0;
	    	$dest_y = 0 + $t_height;
		} elseif ($pos == "TC") {
		    $dest_x = ($this->width - $t_width)/2;
		    $dest_y = 0 + $t_height;
		} elseif ($pos == "TR") {
		    $dest_x = $this->width - $t_width;
		    $dest_y = 0 + $t_height;
		} elseif ($pos == "CL") {
		    $dest_x = 0;
		    $dest_y = ($this->height - $t_height)/2;
		} elseif ($pos == "C") {
		    $dest_x = ($this->width - $t_width)/2;
		    $dest_y = ($this->height - $t_height)/2;
		} elseif ($pos == "CR") {
		    $dest_x = $this->width - $t_width;
		    $dest_y = ($this->height - $t_height)/2;
		} elseif ($pos == "BL") {
		    $dest_x = 0;
		    $dest_y = $this->height - $t_height;
		} elseif ($pos == "BC") {
		    $dest_x = ($this->width - $t_width)/2;
		    $dest_y = $this->height - $t_height;
		} elseif ($pos == "BR") {
		    $dest_x = $this->width - $t_width;
		    $dest_y = $this->height - $t_height;
		}
		$this->fileName = $newName;
		imagettftext($this->resizedImage,$font_size,0,$dest_x+4,$dest_y+4,$font_shadow,$font,$watermarkText);
		imagettftext($this->resizedImage, $font_size, 0, $dest_x, $dest_y, $font_color, $font, $watermarkText);
		if($this->saveImage("100")) {
		    return TRUE;
		} else {
			return FALSE;
		}
	}
	
	private function getSize($newWidth, $newHeight) {
		if ($this->height < $this->width) {
			$optimalWidth = $newWidth;
			$optimalHeight= $this->getSizeByFixedWidth($newWidth);
		}
		elseif ($this->height > $this->width) {
			$optimalWidth = $this->getSizeByFixedHeight($newHeight);
			$optimalHeight= $newHeight;
		}
		else {
			if ($newHeight < $newWidth) {
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
			} elseif ($newHeight > $newWidth) {
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
			} else {
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
			}
		}
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}
	
	private function getSizeByFixedHeight($newHeight) {
		$ratio = $this->width / $this->height;
		$newWidth = $newHeight * $ratio;
		return $newWidth;
	}

	private function getSizeByFixedWidth($newWidth) {
		$ratio = $this->height / $this->width;
		$newHeight = $newWidth * $ratio;
		return $newHeight;
	}
	
	/**
     * get the dimensions of the watermark text
     *
     * @param $font_size - font size to be used
     * @param $fontAngle - rotation
     * @param $font - path to the font file
     * @param $watermarkText
     *
     * @return array or boolean
     */
    private function getTextBoxDimension($font_size, $fontAngle, $font, $watermarkText) {
		$box = imagettfbbox($font_size, $fontAngle, $font, $watermarkText);
		if (!$box) { return FALSE; }
		$minX = min(array($box[0], $box[2], $box[4], $box[6]));
		$maxX = max(array($box[0], $box[2], $box[4], $box[6]));
		$minY = min(array($box[1], $box[3], $box[5], $box[7]));
		$maxY = max(array($box[1], $box[3], $box[5], $box[7]));
		$width = ($maxX - $minX);
		$height = ($maxY - $minY);
		$left = abs($minX) + $width;
		$top = abs($minY) + $height;
		
		$img = @imagecreatetruecolor($width << 2, $height << 2);
		$white = imagecolorallocate($img, 255, 255, 255);
		$black = imagecolorallocate($img, 0, 0, 0);
		imagefilledrectangle($img, 0, 0, imagesx($img), imagesy($img), $black);
		imagettftext($img, $font_size, $fontAngle, $left, $top, $white, $font, $watermarkText);

        $rleft = $w4 = $width<<2;
        $rright = 0;
        $rbottom = 0;
        $rtop = $h4 = $height<<2;
        for ($x = 0; $x < $w4; $x++) {
			for ($y = 0; $y < $h4; $y++) {
				if (imagecolorat($img, $x, $y)) {
					$rleft = min($rleft, $x);
					$rright = max($rright, $x);
					$rtop = min($rtop, $y);
					$rbottom = max($rbottom, $y);
				}
			}
		}
        // destroy img 
        imagedestroy($img);
        return array(
            "left"	=> $left - $rleft,
            "top"	=> $top - $rtop,
            "width"	=> $rright - $rleft + 1,
            "height"=> $rbottom - $rtop + 1,
        );
    }
	
	/**
     * Convert Hex color to RGB color format
     *
     * @param string $hex
     *
     * @return array
     */
    public static function convertHexToRGB($hex) {
        return array(
            "R" => base_convert(substr($hex, 0, 2), 16, 10),
            "G" => base_convert(substr($hex, 2, 2), 16, 10),
            "B" => base_convert(substr($hex, 4, 2), 16, 10),
        );
    }
	
	private function createPaths() {
		if(!is_dir($this->outputPath)){
			mkdir($this->outputPath, '0777', TRUE);
		}
		if(!is_writable($this->outputPath)) {
			chmod($this->outputPath, "0777");
		}
	}
	
	public function saveImage($imageQuality="100") {
		switch($this->imageType) {
			case 1:
				//header ('content-type: image/gif');
				imagegif($this->resizedImage, $this->outputPath . $this->newName);
				//imagejpeg ($this->resizedImage, $this->outputPath . $this->newName, 100);
				break;
			
			case 2:
				//header ('content-type: image/jpeg');
				imagejpeg($this->resizedImage, $this->outputPath . $this->newName, $imageQuality);
				break;
				
			case 3:
				$scaleQuality = round(($imageQuality/100) * 9);
				$invertScaleQuality = 9 - $scaleQuality;
				//header ('content-type: image/png');
				imagepng($this->resizedImage, $this->outputPath . $this->newName , $invertScaleQuality);
				break;
		}
		imagedestroy($this->resizedImage);
		imagedestroy($this->image);
        unset($this->resizedImage, $this->image);
        $this->cleanVars();
		return TRUE;
	}
	
    /**
     * getters
     */
     public function getWidth() {
         return $this->width;
     }
     
     public function getHeight() {
         return $this->height;
     }
}