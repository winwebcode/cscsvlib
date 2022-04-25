<?php

namespace Tests\Unit;

use App\Models\CSV;
use App\Models\CsvLib;
use Exception;
use PHPUnit\Framework\TestCase;


class CsvTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    private $csv;
    private $file;
    private $name;

    public function setUp(): void
    {
        $this->name = '123.csv';
        $this->file = new CSV($this->name);
        $this->csv = new CsvLib(new CSV($this->name));
    }

    public function testCreateFile()
    {
        $this->assertEquals($this->name, $this->csv->file);
    }

    public function testWrongExtension()
    {
        //?? how catch exception in Assert
        try {
            $this->name = '123.mp3';
            $this->file = new CSV($this->name);
            $this->csv = new CsvLib(new CSV($this->name));
        }
        catch (Exception $e) {
            $this->assertNotEquals($this->name, $this->csv->file);
        }
    }

    public function testChunk()
    {
        $part = count($this->csv->chunk());
        $files[] = scandir(realpath(''));
        //////
    }

    public function testDefineFileName()
    {
        $this->csv->getFileName();
        $this->assertEquals($this->name, $this->csv->file);
    }
}
