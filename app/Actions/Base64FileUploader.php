<?php

namespace App\Actions;

use Illuminate\Support\Facades\File;
use App\Contracts\FileUploaderContract;
use Illuminate\Support\Facades\Storage;

class Base64FileUploader implements FileUploaderContract
{
    /**
     * File Upload  function
     *
     * @param [file] $file
     * @param [string] $dir
     * @return void
     */
    public function upload($file, $dir)
    {
        $base64Image = explode(";base64,", $file);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);
        $file = 'image_' . microtime() . '.' . $imageType;
        Storage::put($dir . '/' . $file, $image_base64);

        return $file;
    }
}
