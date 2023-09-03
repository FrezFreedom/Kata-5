<?php


use PHPUnit\Framework\TestCase;

class BarcodeScannerTest extends TestCase
{
    public function testBarcodeScanner()
    {
        $barcodeScanner = new BarcodeScanner();
        $barcodeScanner->scan('12345');
        $display = $barcodeScanner->display();

        $this->assertEquals('$7.25', $display->message);
    }
}