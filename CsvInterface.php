<?php
namespace App\Models;

interface CsvInterface
{
    public function getPath();
    public function csvToArray();
}
