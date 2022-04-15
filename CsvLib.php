<?php

use Exception;
use Illuminate\Support\Facades\Storage;

class CsvLib implements CsvInterface
{
    private $file;
    /**
     * @var string
     */
    private $part = 100;
    /**
     * @var string
     */
    private $fullpath;

    public function __construct($file)
    {
        if ($file) {
            $this->file = $file;
            $this->fullpath = $this->getPath();
        } else {
            throw new Exception('Загрузите файл в каталог \'Public\'');
        }
    }

    public function csvToArray(): array
    {
        if (($handle = fopen($this->fullpath, "r")) !== false) {
            return array_map('str_getcsv', file($this->fullpath));
        } else {
            throw new Exception('Не могу открыть '.$this->fullpath);
        }
    }

    public function getPath(): string
    {
        return Storage::path($this->file);
    }

    public function showCsv(): array
    {
        return array_chunk($this->csvToArray(), $this->part);
    }

    public function getFileSize(): string
    {
        return filesize($this->fullpath)." bytes";
    }
}
