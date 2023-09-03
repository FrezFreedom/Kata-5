<?php

class Database
{
    private $barcodes = [
        '12345' => '7.25',
        '23456' => '12.50',
    ];

    public function loadTableData(string $tableName): array
    {
        return $this->$tableName;
    }
}