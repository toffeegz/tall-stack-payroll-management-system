<?php

namespace App\Services\Utils;

use App\Services\Utils\FileServiceInterface;
use Illuminate\Support\Facades\Storage;

class FileService implements FileServiceInterface
{
    private $basePath;
    public function  __construct(

    ) {
        $this->basePath = config('storage.base_path');
    }

    public function download($folderName, $fileName)
    {
        $file = $this->basePath . $folderName . '/'. $fileName;
        return Storage::download($file);
    }
}