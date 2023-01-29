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
        $path = $this->basePath . $folderName ."/" . $fileName;
        return Storage::disk('public')->download($path);
    }

    public function upload($folderName, $fileName, $file)
    {
        $fileName = $fileName . "." . $file->getClientOriginalExtension();
        $folderName = $this->basePath . $folderName;
        $result = Storage::disk('public')->putFileAs($folderName, $file, $fileName);
        return $result;
    }
}