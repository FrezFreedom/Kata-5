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

        $barcodes5 = ['23456', '12345', '', '121001', '80008'];

        $expectedResponse5 = new BarcodeScannerDTO();
        $expectedResponse5->total = 20;
        $expectedResponse5->totalStr = '$20';
        $expectedResponse5->message = '$0.25';

        yield [
            $expectedResponse5,
            $barcodes5,
        ];

        $barcodes6 = ['23456', '12345', '', '121001', '80008', '12345'];

        $expectedResponse6 = new BarcodeScannerDTO();
        $expectedResponse6->total = 27.25;
        $expectedResponse6->totalStr = '$27.25';
        $expectedResponse6->message = '$7.25';

        yield [
            $expectedResponse6,
            $barcodes6,
        ];

        $barcodes7 = ['', '121001'];

        $expectedResponse7 = new BarcodeScannerDTO();
        $expectedResponse7->total = 0;
        $expectedResponse7->totalStr = '$0';
        $expectedResponse7->message = 'Error: barcode not found';

        yield [
            $expectedResponse7,
            $barcodes7,
        ];
    }
}