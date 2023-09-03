<?php

use PHPUnit\Framework\TestCase;


final class BarcodeValueEstimatorTest extends TestCase
{
    public function testBarcodeValueEstimator()
    {
        $barcodeValueEstimator = new BarcodeValueEstimator();

        $value = $barcodeValueEstimator->estimate('12345');

        $this->assertEquals('7.24', $value);
    }
}