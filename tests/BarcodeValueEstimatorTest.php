<?php

use PHPUnit\Framework\TestCase;

require_once ( __DIR__ . '/../BarcodeValueEstimator.php');

final class BarcodeValueEstimatorTest extends TestCase
{
    public function testBarcodeValueEstimator()
    {
        $barcodeValueEstimator = new BarcodeValueEstimator();

        $value = $barcodeValueEstimator->estimate('12345');

        $this->assertEquals('7.25', $value);
    }
}