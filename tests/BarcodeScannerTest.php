<?php

use PHPUnit\Framework\TestCase;

require_once (__DIR__ . '/../BarcodeScanner.php');

class BarcodeScannerTest extends TestCase
{
    /**
     * @dataProvider provideBarcodeScannerData
     */
    public function testBarcodeScanner(string $expectedMessage, string $barcode)
    {
        $database = new Database();
        $barcodeValueEstimator = new BarcodeValueEstimator($database);
        $barcodeScanner = new BarcodeScanner($barcodeValueEstimator);
        $barcodeScanner->scan($barcode);
        $display = $barcodeScanner->display();

        $this->assertEquals($expectedMessage, $display->message);
    }

    public static function provideBarcodeScannerData()
    {
        yield [
            '$7.25',
            '12345',
        ];

        yield [
            '$12.50',
            '23456',
        ];

        yield [
            'Error: barcode not found',
            '99999',
        ];

        yield [
            'Error: empty barcode',
            '',
        ];
    }

    public function testMultipleBarcodesScanner()
    {
        $barcodes = ['12345', '23456'];

        $database = new Database();
        $barcodeValueEstimator = new BarcodeValueEstimator($database);
        $barcodeScanner = new BarcodeScanner($barcodeValueEstimator);

        foreach ($barcodes as $barcode)
        {
            $barcodeScanner->scan($barcode);
        }

        $response = $barcodeScanner->display();
        $this->assertEquals('$19.75', $response->totalStr);
    }
}