<?php

namespace App\Services;

use App\Services\Api\ApiIslandService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IslandService
{
   protected $apiislandservice;

   public function __construct(ApiIslandService $apiislandservice)
    {
      $this->apiislandservice = $apiislandservice;
    }

   public function api(Request $request)
   {
      //dd($request);

      $res = $this->getSearch($request);

      return $res;
   }

   protected function getSearch($request)
   {
      $res = $this->apiislandservice->search($request);

      if(!$res){
         return false;
      }

      return $res;
   }

   public function getInfoHotelById($id)
   {
      $res = $this->apiislandservice->getHotelInfo($id);

      return $res;
   }

   public function getInfoHotelSearchById($row)
   {
     // dd($row);

      $res = $this->apiislandservice->getDataHotelsSearch($row);

      return $res;
   }

   public function getInfoHotelSearchByIdAjax($row)
   {
     // dd($row);

      $res = $this->apiislandservice->getDataHotelsSearch($row);

      return $res;
   }
}