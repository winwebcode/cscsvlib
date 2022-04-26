<?php
namespace App\Models;

use Exception;

class CsvLib implements CsvInterface
{
    public $file;
    /**
     * @var string
     */
    private $part;
    /**
     * @var string
     */
    private $fullpath;
    private $chunks;
    private $chunkFilesPath = [];
    private $loadDir;

    public function __construct(CSV $csv, int $part = 2)
    {
            $this->file = $csv->file;
            $this->fullpath = $this->getPath();
            $this->loadDir = realpath('');
            $this->part = $part;
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
        return realpath($this->file);
    }

    public function getHeader(): array
    {
        $data = $this->csvToArray();
        return $data[0];
    }

    public function showCsv(): array
    {
        return array_chunk($this->csvToArray(), $this->part);
    }

    public function chunk()
    {
        $data = $this->getDataWithoutHead();
        $this->chunks = array_chunk($data, $this->part);
        $header = $this->getHeader();
        foreach ($this->chunks as $key => $chunk) {
            $name = "part$key.csv";
            $fp = fopen($name, 'a+');
            fputcsv($fp, $header);
            foreach ($chunk as $value) {
                fputcsv($fp, $value);
            }
            $this->chunkFilesPath[] = realpath($name);
        }
        return $this->chunkFilesPath;
    }

    public function getDataWithoutHead()
    {
        $data = $this->csvToArray();
        unset($data[0]);
        return $data;
    }

    public function getFileSize(): string
    {
        return filesize($this->fullpath)." bytes";
    }

    public function getNumberRows(): int
    {
        return count($this->csvToArray());
    }

    public function getFileName(): string
    {
        $info = pathinfo($this->file);
        return $info['filename'];
    }
}
