<?php

namespace App\Actions;

use App\Models\Type;

use App\Models\Appartment;
use Facades\App\Actions\Base64FileUploader;
use Facades\App\Actions\StoreImages;
use App\Contracts\CreateNewResidencyContarct;

class CreateNewAppartment implements CreateNewResidencyContarct
{
    public function create($data)
    {

        $validated = $data->validate([
            'single_bed' => 'required|integer',
            'sofa_bed' => 'required|integer',
            'double_bed' => 'required|integer',
            'wide_bed' => 'required|integer',
            'futon' => 'required|integer',
            'extra_beds' => 'required',
            'guest_count' => 'required',
            'room_no' => 'required',
            'price' => 'required',
            'bathroom_count' => 'required'
        ]);


        $validated = collect($validated)->merge([
            'area' => $data->area,
            'type_id' => $data->type
        ])->toArray();

        $appartment =  Appartment::create($validated);
        foreach ($data->Upload as $file) {

            if ($data->file == $file) {
                StoreImages::execute($appartment, Base64FileUploader::upload($file, '/public/uploads'), true);
            } else {
                StoreImages::execute($appartment, Base64FileUploader::upload($file, '/public/uploads'), false);
            }
        }

        return $appartment;
    }
}
