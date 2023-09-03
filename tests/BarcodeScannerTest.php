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

    /**
     * @dataProvider provideMultipleBarcodesScannerData
     */
    public function testMultipleBarcodesScanner(BarcodeScannerDTO $expectedResponse,array $barcodes)
    {
        $database = new Database();
        $barcodeValueEstimator = new BarcodeValueEstimator($database);
        $barcodeScanner = new BarcodeScanner($barcodeValueEstimator);

        foreach ($barcodes as $key => $barcode)
        {
            echo $key . $barcode . '\n';
            $barcodeScanner->scan($barcode);
        }

        $response = $barcodeScanner->display();

        $this->assertEquals($expectedResponse->total, $response->total);
        $this->assertEquals($expectedResponse->totalStr, $response->totalStr);
        $this->assertEquals($expectedResponse->message, $response->message);
    }

    public static function provideMultipleBarcodesScannerData()
    {
        $barcodes = ['12345', '23456'];

        $expectedResponse = new BarcodeScannerDTO();
        $expectedResponse->total = 19.75;
        $expectedResponse->totalStr = '$19.75';
        $expectedResponse->message = '$12.50';

        yield [
            $expectedResponse,
            $barcodes,
        ];

        $barcodes2 = ['23456', '12345'];

        $expectedResponse2 = new BarcodeScannerDTO();
        $expectedResponse2->total = 19.75;
        $expectedResponse2->totalStr = '$19.75';
        $expectedResponse2->message = '$7.25';

        yield [
            $expectedResponse2,
            $barcodes2,
        ];

        $barcodes3 = ['23456', '12345', ''];

        $expectedResponse3 = new BarcodeScannerDTO();
        $expectedResponse3->total = 19.75;
        $expectedResponse3->totalStr = '$19.75';
        $expectedResponse3->message = 'Error: empty barcode';

        yield [
            $expectedResponse3,
            $barcodes3,
        ];

        $barcodes4 = ['23456', '12345', '', '121001'];

        $expectedResponse4 = new BarcodeScannerDTO();
        $expectedResponse4->total = 19.75;
        $expectedResponse4->totalStr = '$19.75';
        $expectedResponse4->message = 'Error: barcode not found';

        yield [
            $expectedResponse4,
            $barcodes4,
        ];
    }
}