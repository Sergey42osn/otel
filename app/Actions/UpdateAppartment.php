<?php

namespace App\Actions;

use App\Contracts\UpdateResidencies;
use App\Models\Appartment;
use App\Models\Image;
use Facades\App\Actions\Base64FileUploader;
use Facades\App\Actions\StoreImages;
use Illuminate\Support\Facades\DB;

class UpdateAppartment implements UpdateResidencies
{

    public function execute($appartment, $request)
    {

        $validated = $request->validate([
            /*'single_bed' => 'required|integer',
            'sofa_bed' => 'required|integer',
            'double_bed' => 'required|integer',
            'wide_bed' => 'required|integer',
            'futon' => 'required|integer',
            'extra_beds' => 'required',
            'guest_count' => 'required',
            'room_no' => 'required',
            'price' => 'required',
            'bathroom_count' => 'required'*/
        ]);


        $appartment->type_id = $request->type;
        $appartment->area = $request->area;
        $appartment->room_no = $request->room_no;

        $appartment->save();
        $id = $appartment->id;
        Appartment::find($id)->update($validated);

        $deleted_files = $request->deleteFiles;
        $deleted_files = explode(',',$deleted_files);
        foreach($deleted_files as $file){
            DB::table('images')->where([['imageable_id', $id],['url',$file]])->delete();
        }
        if($request->headFile!=null) {

            $arr_images = Image::where('imageable_id', $id)->get();
            foreach ($arr_images as $img) {
                $img->update([
                    'featured_image' => 0
                ]);
            }
        }

        if($request->headFile!=null && Image::where([['imageable_id', $id],['url',$request->headFile]])->first()){
            $img = Image::where([['imageable_id', $id],['url',$request->headFile]])->first()->update([
                'featured_image' => 1
            ]);
        }
        if($request->Upload){
            foreach ($request->Upload as $file) {
                if (substr($file, 0, 5) == 'data:') {
                    $url = Base64FileUploader::upload($file, '/public/uploads/');
                    if ($request->headFile!=null && $request->headFile == $file) {
                        $appartment->images()->update(['featured_image' => false]);
                        StoreImages::execute($appartment, $url, true);
                    } else {
                        StoreImages::execute($appartment, $url, false);
                    }
                }
            }
        }


        return $appartment;
    }
}
