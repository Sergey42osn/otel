<?php

namespace App\Services\Api;

use Illuminate\Http\Request;

class ApiIslandService{

   protected string $apiContentUrl = 'https://api.worldota.net/api/b2b/v3/search/hp/';
   protected string $apiSearchUrl = 'https://api.worldota.net/api/b2b/v3/search/multicomplete/';
   protected string $apiHotelInfo = 'https://api.worldota.net/api/b2b/v3/hotel/info/';
   protected string $apiReservationUrl = 'https://partner.qatl.ru/api/reservation';
   protected string $apiGeoUrl = 'https://partner.qatl.ru/api/geo';

   protected $countryArray = [
      'RU'  => 'Россия'
   ];

   protected $request;

   public function __construct(Request $request)
    {
      $this->request = $request;
    }

   public function search($request)
   {
      //dd($request);

      $this->request = $request;

      if($request->has("place_name")){
         $search = $request->get("place_name");
      }else{
         return false;
      }

      $this->apiSearchUrl = 'https://api.worldota.net/api/b2b/v3/search/multicomplete/';

      $res = $this->getSearchHotel($search);

      //var_dump($res);
      //return $data;

      if(!$res){
         return false;
      }

      $data = [];

      foreach ($res as $row) {
         $d = $this->getDataHotels($row);

         if($d){
            $data[] = $d;
         }
      }

      if(!$data){
         return false;
      }

     // $data['count'] = count($data);

     // var_dump($data);

      return $data;

   }

   public function getSearchHotel($search)
   {
      $params = [
         "query" => $search,
         "language" => app()->getLocale()
      ];

      $res = $this->callApi($this->apiSearchUrl,$params);
      
      //dd($res);

      if($res->status == 'error'){
         return false;
      }

      if($res->data->hotels && $res->data->hotels > 0){
        // var_dump($res);

         return $res->data->hotels;

      }else{
         return false;
      }
   }

   public function getDataHotels($row)
   {
      $data = [];

      ///dd($this->request);

      //dd($row);

      if($this->request->has('check_in')){
         $checkin = date('Y-m-d',strtotime($this->request->get('check_in')));
      }

      if($this->request->has('check_out')){
         $checkout = date('Y-m-d',strtotime($this->request->get('check_out')));
      }

      if($this->request->has('adults')){
         $adults = $this->request->get('adults');
      }

      //dd(app()->getLocale());

      $params = [
         "checkin"   => $checkin ? $checkin : '',
         "checkout"  => $checkout ? $checkout : '',
         "residency" => "",
         "language"  => app()->getLocale(),
         "guests"    => [
            [
                  "adults" => intval($adults),
                  "children" => []
            ]
         ],
         "id"        => $row->id ? $row->id : '',
         "currency"  => "RUB"
      ];

      $res = $this->callApi($this->apiContentUrl,$params);

    //dd($res);

      if($res->status == 'error'){
         return false;
      }

      //dd($res->data->hotels[0]->rates[0]->daily_prices);

      $data = [
         'id'           => $row->id,
         'name'         => $row->name,
         'region_id'    => $row->region_id,
         'daily_prices' => $res->data->hotels ? $res->data->hotels[0]->rates[0]->daily_prices : ''
      ];

      //var_dump($data);

      $info = $this->getHotelInfo($row->id);

      //var_dump($info->data->images[0]);

      $data['description'] = $info->data->description_struct[1]->paragraphs[0] ? $info->data->description_struct[1]->paragraphs[0] : '';

      $images = $info->data->images[0] ? str_replace("{size}","240x240",$info->data->images[0]) : '';

      $data['images'] = $images;

      $data['star_rating'] = $info->data->star_rating ? $info->data->star_rating : 0;

      $data['region'] = [
         'city'   => $info->data->region->name ? $info->data->region->name : '',
         'location'  => $this->countryArray[$info->data->region->country_code]
      ];

      $data['slug'] = $row->id ? str_replace("_","-",$row->id) : 'slug';

      $data['info'] = $info->data ? $info->data : '';

      //var_dump($data['slug']);

      return $data;
   }

   public function getDataHotelsSearch($row)
   {
      $data = [];

      //dd($row);

      //dd($this->request);

      //dd($this->request->has('check_in'));

      if($this->request->has('check_in')){
         $checkin = date('Y-m-d',strtotime($this->request->get('check_in')));
      }else{
         $checkin = date('Y-m-d',strtotime($row['check_in']));
      }

      if($this->request->has('check_out')){
         $checkout = date('Y-m-d',strtotime($this->request->get('check_out')));
      }else{
         $checkout = date('Y-m-d',strtotime($row['check_out']));
      }

      if($this->request->has('adults')){
         $adults = $this->request->get('adults');
      }else{
         $adults = $row['adults'];
      }

      //dd(app()->getLocale());

      //dd($row['check_in']);

      $params = [
         "checkin"   => $checkin ? $checkin : '',
         "checkout"  => $checkout ? $checkout : '',
         "residency" => "",
         "language"  => app()->getLocale(),
         "guests"    => [
            [
                  "adults" => $adults ? intval($adults) : '',
                  "children" => []
            ]
         ],
         "id"        => $row['id'] ? $row['id'] : '',
         "currency"  => "RUB"
      ];

      $res = $this->callApi($this->apiContentUrl,$params);

    // var_dump($res->data);

    //dd($res->data);

      if(!$res->data->hotels){
         return false;
      }

      //var_dump($res->data->hotels[0]->rates[0]->daily_prices);

      

      //var_dump($data);

      $info = $this->getHotelInfo($row['id']);

      //var_dump($info->data->images[0]);

      $data['description'] = $info->data->description_struct[1]->paragraphs[0] ? $info->data->description_struct[1]->paragraphs[0] : '';

      $images = $info->data->images[0] ? str_replace("{size}","240x240",$info->data->images[0]) : '';

      $data['images'] = $images;

      $data['star_rating'] = $info->data->star_rating ? $info->data->star_rating : 0;

      $data['region'] = [
         'city'   => $info->data->region->name ? $info->data->region->name : '',
         'location'  => $this->countryArray[$info->data->region->country_code]
      ];

      $data['slug'] = $row['id'] ? str_replace("_","-",$row['id']) : 'slug';

      $data['info'] = $info->data ? $info->data : '';

      $data['res'] = $res->data->hotels;

      //var_dump($data['slug']);

      return $data;
   }

   public function getHotelInfo($id)
   {
      //dd($id);

      $params = [
         'id'        => $id,
         'language'  => app()->getLocale()
      ];

      $res = $this->callApi($this->apiHotelInfo,$params);

      return $res;
   }

   public function callApi($url,$params = '', $type = "POST")
    {
        $curl = curl_init();

        $curl_params = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Authorization: Basic '. base64_encode("4457:a936d96f-6107-4057-bde6-f518b019abe0"),
                'Content-Type: application/json'
            ),
        );
        if($type == "POST") {
            $curl_params[CURLOPT_POSTFIELDS] = json_encode($params);
        }

        curl_setopt_array($curl, $curl_params);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

}