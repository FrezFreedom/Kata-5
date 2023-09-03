<?php

require_once ('Database.php');

class BarcodeValueEstimator
{
    public function __construct(private Database $database)
    {
    }

    public function estimate($barcode)
    {
        $barcodesTable = $this->database->loadTableData('barcodes');

        if(key_exists($barcode, $barcodesTable))
        {
            return $barcodesTable[$barcode];
        }

        return -1;
    }
}