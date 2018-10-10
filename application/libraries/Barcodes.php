<?php defined('BASEPATH') OR exit('No direct script access allowed');


use Zend\Barcode\Barcode;

class barcodes
{
    public function __construct() {
    }

    public function __get($var) {
        return get_instance()->$var;
    }

    public function barcode($text = null, $bcs = 'code128', $height = 74, $stext = 1, $get_be = false) {
        $drawText = ($stext != 1) ? false : true;
        return $this->generate($text, $bcs, $height, $drawText, $get_be);
    }

    public function generate($text, $bcs = 'code128', $height = 50, $drawText = true, $get_be = false) {
        // Barcode::setBarcodeFont('my_font.ttf');
        $check = $this->prepareForChecksum($text, $bcs);

        $barcodeOptions = ['text' => $check['text'], 'barHeight' => $height, 'drawText' => $drawText, 'withChecksum' => $check['checksum'], 'withChecksumInText' => $check['checksum']]; //'fontSize' => 12, 'factor' => 1.5,

        $rendererOptions = ['imageType' => 'png', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle'];
        $imageResource = Barcode::draw($bcs, 'image', $barcodeOptions, $rendererOptions);
        ob_start();
        imagepng($imageResource);
        $imagedata = ob_get_contents();
        ob_end_clean();
        if ($get_be) {
            return 'data:image/png;base64,'.base64_encode($imagedata);
        }
        return "<img src='data:image/png;base64,".base64_encode($imagedata)."' alt='{$text}' class='bcimg' />";
    }

    protected function prepareForChecksum($text, $bcs) {
        if ($bcs == 'code25' || $bcs == 'code39') {
            return ['text' => $text, 'checksum' => false];
        } elseif ($bcs == 'code128') {
            return ['text' => $text, 'checksum' => true];
        }
        return ['text' => substr($text, 0, -1), 'checksum' => true];
    }
}
