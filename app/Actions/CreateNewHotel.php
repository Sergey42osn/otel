<?php

namespace App\Actions;

use App\Actions\Base64FileUploader as ActionsBase64FileUploader;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Facades\App\Actions\StoreImages;
use Illuminate\Support\Facades\Storage;

use Facades\App\Actions\Base64FileUploader;
use App\Contracts\CreateNewResidencyContarct;

class CreateNewHotel implements CreateNewResidencyContarct
{
    public function create($req): Hotel
    {

        $req->validate([
            'type' => ['required'],
            'stars_num' => 'required'
        ]);
        $hotel = Hotel::create([
            'type_id' => $req->type,
            'stars_num' => $req->stars_num,
            'in_stock' => $req->in_stock=="on"?1:0,
//            'crm' => $req->crm
        ]);

        foreach ($req->Upload as $file) {
            if ($req->file == $file) {
                StoreImages::execute($hotel, Base64FileUploader::upload($file, 'public/uploads/'), true);
            } else {
                StoreImages::execute($hotel, Base64FileUploader::upload($file, 'public/uploads/'), false);
            }
        }

        return $hotel;
    }

    public function upload($file, $dir)
    {
        $base64Image = explode(";base64,", $file);
        $explodeImage = explode("image/", $base64Image[0]);
        $imageType = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);
        $file = time() . '.' . $imageType;
        Storage::put($dir . '/' . $file, $image_base64);
        return $file;
    }
}
