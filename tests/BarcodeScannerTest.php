<?php

use PHPUnit\Framework\TestCase;

require_once (__DIR__ . '/../BarcodeScanner.php');

class BarcodeScannerTest extends TestCase
{
    public function testBarcodeScanner()
    {
        $database = new Database();
        $barcodeValueEstimator = new BarcodeValueEstimator($database);
        $barcodeScanner = new BarcodeScanner($barcodeValueEstimator);
        $barcodeScanner->scan('12345');
        $display = $barcodeScanner->display();

        $this->assertEquals('$7.25', $display->message);
    }
}