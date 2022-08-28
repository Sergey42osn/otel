<?php

namespace App\Actions;

use App\Contracts\UpdateResidencies;
use App\Models\Hotel;
use App\Models\Image;
use Facades\App\Actions\Base64FileUploader;
use Facades\App\Actions\StoreImages;
use Illuminate\Support\Facades\DB;

class UpdateHotel implements UpdateResidencies
{
    public  function execute($hotel, $req)
    {
        $req->validate([
            'type' => ['required'],
            'stars_num' => 'required'
        ]);


        $hotel->type_id = $req->type;
        $hotel->stars_num = $req->stars_num;
        $hotel->in_stock = $req->in_stock=="on"?1:0;
//        $hotel->crm = $req->crm;

        $hotel->save();

        $deleted_files = $req->deleteFiles;
        $deleted_files = explode(',',$deleted_files);
        foreach($deleted_files as $file){
            DB::table('images')->where([['imageable_id', $hotel->id],['url',$file]])->delete();
        }

       if($req->headFile!=null){
           $arr_images = Image::where([['imageable_id', $hotel->id],['imageable_type','App\Models\Hotel']])->get();
           foreach ($arr_images as $img){
               $img->update([
                   'featured_image' => 0
               ]);
           }
       }

//dd($arr_images);
        if($req->headFile!=null && Image::where([['imageable_id', $hotel->id],['url',$req->headFile],['imageable_type','App\Models\Hotel']])->first()){
            $img = Image::where([['imageable_id', $hotel->id],['url',$req->headFile]])->first()->update([
                'featured_image' => 1
            ]);
        }
//        return $hotel;
        if ($req->Upload){
            foreach ($req->Upload as $file) {
                if (substr($file, 0, 5) == 'data:') {
                    $url = Base64FileUploader::upload($file, '/public/uploads/');
                    if ($req->headFile!=null && $req->headFile == $file) {
                        $hotel->images()->update(['featured_image' => false]);
                        StoreImages::execute($hotel, $url, true);
                    } else {
                        StoreImages::execute($hotel, $url, false);
                    }
                }
            }
        }



        return $hotel;
    }
}
