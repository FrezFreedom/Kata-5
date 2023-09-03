<?php

use PHPUnit\Framework\TestCase;

require_once ( __DIR__ . '/../BarcodeValueEstimator.php');
require_once ( __DIR__ . '/../Database.php');

final class BarcodeValueEstimatorTest extends TestCase
{
    /**
     * @dataProvider provideBarcodeValueEstimatorData
     */
    public function testBarcodeValueEstimator($expectedValue, $input)
    {
        $database = new Database();

        $barcodeValueEstimator = new BarcodeValueEstimator($database);

        $value = $barcodeValueEstimator->estimate($input);

        $this->assertEquals($expectedValue, $value);
    }

    public static function provideBarcodeValueEstimatorData()
    {
        yield [
            7.25,
            '12345',
        ];

        yield [
            12.50,
            '23456',
        ];

        yield [
            -1,
            '99999',
        ];
    }


}