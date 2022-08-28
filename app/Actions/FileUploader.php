<?php

namespace App\Actions;

use App\Contracts\FileUploaderContract;

class FileUploader implements FileUploaderContract
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
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file('file')->storeAs($dir, $fileName, 'public');
        $url  = '/storage/' . $filePath;
        return $url;
    }
}
