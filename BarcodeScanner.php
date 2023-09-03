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
        $value = $this->barcodeScanner->estimate($barcode);

        $this->response->message = '$' . strval($value);
    }

    public function display(): BarcodeScannerDTO
    {
        return $this->response;
    }
}