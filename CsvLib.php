<?php
namespace App\Models;

use Exception;
use Illuminate\Support\Facades\Storage;

class CsvLib implements CsvInterface
{
    private $file;
    /**
     * @var string
     */
    private $part = 10;
    /**
     * @var string
     */
    private $fullpath;
    private $chunks;
    private $chunkFilesPath = [];
    private $loadDir;

    public function __construct($file)
    {
        if ($file) {
            $this->file = $file;
            $this->fullpath = $this->getPath();
            $this->loadDir =  Storage::path('');
        } else {
            throw new Exception("Загрузите файл в каталог '$this->loadDir'");
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

    public function chunk()
    {
        $this->chunks = array_chunk($this->csvToArray(), $this->part);
        foreach ($this->chunks as $key => $chunk) {
            $name = "part$key.csv";
            foreach ($chunk as $value) {
                $fp = fopen($name, 'a+');
                fputcsv($fp, $value);
            }
            $this->chunkFilesPath[] = Storage::path($name);
        }
        return $this->chunkFilesPath;
    }

    public function getFileSize(): string
    {
        return filesize($this->fullpath)." bytes";
    }
}
