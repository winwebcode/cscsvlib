<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CSV extends Model
{
    use HasFactory;

    public $file;

    public function __construct($file)
    {
        $this->file = $file;
        if ($this->isCSV()) {
            return $file;
        }
        throw new Exception('Формат файла должен быть \'CSV\'');
    }

    private function isCSV(): bool
    {
        $info = $this->getFileInfo();
        if ($info['extension'] === "csv") {
            return true;
        } else {
            return false;
        }
    }

    private function getFileInfo()
    {
        return pathinfo($this->file);
    }
}
