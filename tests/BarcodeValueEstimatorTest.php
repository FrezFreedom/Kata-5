<?php

use PHPUnit\Framework\TestCase;

require_once ( __DIR__ . '/../BarcodeValueEstimator.php');
require_once ( __DIR__ . '/../Database.php');

final class BarcodeValueEstimatorTest extends TestCase
{
    public function testBarcodeValueEstimator()
    {
        $database = new Database();

        $barcodeValueEstimator = new BarcodeValueEstimator($database);

        $value = $barcodeValueEstimator->estimate('12345');

        $this->assertEquals('7.25', $value);
    }
}