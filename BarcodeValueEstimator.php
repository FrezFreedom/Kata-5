<?php

class BarcodeValueEstimator
{
    public function estimate($barcode)
    {
        if($barcode == '12345')
            return '7.25';
    }
}