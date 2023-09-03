<?php


use PHPUnit\Framework\TestCase;

class BarcodeScannerTest extends TestCase
{
    public function testBarcodeScanner()
    {
        $barcodeScanner = new BarcodeScanner();
        $barcodeScanner->scan('12345');
        $message = $barcodeScanner->getMessage();

        $this->assertEquals('$7.25', $message);
    }
}