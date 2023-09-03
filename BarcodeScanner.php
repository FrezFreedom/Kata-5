<?php

require_once ('BarcodeValueEstimator.php');
require_once ('BarcodeScannerDTO.php');

class BarcodeScanner
{
    private BarcodeScannerDTO $response;

    public function __construct(private BarcodeValueEstimator $barcodeScanner)
    {
        $this->response = new BarcodeScannerDTO();
    }

    public function scan($barcode)
    {
        if($barcode === '')
        {
            $this->response->message = 'Error: empty barcode';
            return;
        }

        $value = $this->barcodeScanner->estimate($barcode);

        if($value === -1)
        {
            $this->response->message = 'Error: barcode not found';
        }
        else
        {
            $this->response->message = '$' . $value;
            $this->response->total += floatval($value);
        }
    }

    public function display(): BarcodeScannerDTO
    {
        $this->response->totalStr = '$' . strval($this->response->total);
        return $this->response;
    }
}