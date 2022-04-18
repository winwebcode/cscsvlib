<?php

namespace Tests\Unit;

use App\Models\CSV;
use App\Models\CsvLib;
use PHPUnit\Framework\TestCase;

class CsvLibTest extends TestCase
{

    public function checkFileType(): CSV
    {
        return new CSV('123.csv');
    }
}
