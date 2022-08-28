<?php

namespace App\Services\Api;

use App\Contracts\Api\TravelLineContract;

class TravelLineService implements TravelLineContract
{
    protected string $apiContentUrl = 'https://partner.qatl.ru/api/content';
    protected string $apiSearchUrl = 'https://partner.qatl.ru/api/search';
    protected string $apiReservationUrl = 'https://partner.qatl.ru/api/reservation';
    protected string $apiGeoUrl = 'https://partner.qatl.ru/api/geo';

    /**
     * @param $data
     * @return array
     */
    public function getAccommodationIds($data)
    {
        $ids = [];
        $url = $this->apiSearchUrl . '/v1/properties/room-stays/search';
        $params = [
            'propertyIds' => $data['propertyIds'],
            'adults' => $data['adults'],
            'childAges' => $data['childAges'],
            'arrivalDate' => $data['arrivalDate'],
            'departureDate' => $data['departureDate'],
            'include' => '',
        ];
        $response = json_decode($this->callApi($url,$params), true);
        if (isset($response['roomStays'])){
            foreach($response['roomStays'] as $item){
                $ids[$item['propertyId']] = $item['total']['priceBeforeTax'] + $item['total']['taxAmount'];
            }
        }

        return $ids;
    }
    public function verifyBooking($data)
    {
        $url = $this->apiReservationUrl.'/v1/bookings/verify';
//        $roomStays = $this->roomStays($data);
        $count = 0;
        if (isset($data['count'])){
            $count = $data['count'];
        }
        $roomStays = [];
        for ($i=0; $i< $count; $i++){
            $item = [
                'stayDates' => [
                    'arrivalDateTime' => $data['arrivalDateTime'],
                    'departureDateTime' => $data['departureDateTime']
                ],
                'ratePlan' => [
                    'id' => $data['rate_plan_id']
                ],
                'roomType' => [
                    'id' => $data['room_type_id'],
                    'placements' => [
                        [
                            'code' => $data['code'],
                        ]
                    ]
                ],
                'guests' => [
                    [
                        'firstName' => $data['firstName'],
                        'lastName' => $data['lastName'],
                        'middleName' => $data['middleName'],
                        'citizenship' => $data['citizenship'],
                        'sex' => $data['sex']
                    ]
                ],
                'guestCount' => [
                    'adultCount' => $data['adultCount'],
                    'childAges' => $data['childAges']
                ],
                'services' => [],
                'checksum' => $data['checksum']
            ];
            array_push($roomStays, $item);
        }
        $params = [
            'booking' => [
                'propertyId' => $data['propertyId'],
                'roomStays' => $roomStays,
                'services'=> [],
                'customer'=> [
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName'],
                    'middleName' => $data['middleName'],
                    'citizenship' => $data['citizenship'],
                    "contacts"=> [
                        "phones" => [
                            [
                                "phoneNumber"=> $data['phone']
                            ]
                        ],
                        "emails"=> [
                            [
                                "emailAddress"=>  $data['email']
                            ]
                        ]
                    ]
                ]
            ]
        ];
//dd(json_encode($params));
        $data = json_decode($this->callApi($url,$params), true);

        return ['verify_response' => $data, 'booking_params' => $params];
    }



    public function createBooking($data)
    {
        $url = $this->apiReservationUrl . '/v1/bookings';

        $booking = json_decode($this->callApi($url,$data), true);

        return $booking;
    }
    public function calculateCancelPenalty($data)
    {
        $url = $this->apiReservationUrl.'/v1/bookings/'.$data['number'].'/calculate-cancellation-penalty'.'?cancellationDateTimeUtc='.$data['cancellationDateTimeUtc'];
        $response = json_decode($this->callApi($url, [] ,'GET'), true);
        return $response;
    }

    public function cancelBooking($data)
    {
        $url = $this->apiReservationUrl.'/v1/bookings/'.$data['number'].'/cancel';
        unset($data['number']);
        $cancel = json_decode($this->callApi($url,$data), true);
        return $cancel;
    }
    public function getAvailableRoomIds($data)
    {
        $room_info = [];
        $newArr = $data;
        $newArr['include'] = 'content';
        unset($newArr['propertyId']);
        $params = str_replace(['%5B1%5D', '%5B2%5D'], '', http_build_query($newArr));

        $url = $this->apiSearchUrl.'/v1/properties/'.$data['propertyId'].'/room-stays'.'?'.$params;
        $response = json_decode($this->callApi($url, [], 'GET'));
        if( gettype($response) == 'object' ) {
            if( !property_exists($response, 'errors') ) {
                $room_obejcts = $response->roomStays;
                foreach( $room_obejcts as $room_object) {
                    $room_info[$room_object->roomType->id][$room_object->ratePlan->id]['check_sum'] = $room_object->checksum;
                    $room_info[$room_object->roomType->id][$room_object->ratePlan->id]['cancellationPolicy'] = $room_object->cancellationPolicy;
                    $room_info[$room_object->roomType->id][$room_object->ratePlan->id]['availability'] = $room_object->availability;
                    $placements = [];
                    if( $room_object->roomType->placements != null && !empty($room_object->roomType->placements) && is_array($room_object->roomType->placements) ) {
                        foreach ($room_object->roomType->placements as $placement) {
                            $placements[] = $placement->code;
                        }
                        $room_info[$room_object->roomType->id][$room_object->ratePlan->id]['placement_code'] = implode('_', $placements);
                    }
                    if( $room_object->total != null && is_object($room_object->total) ) {
                        $total = $room_object->total;
                        $price = $tax = 0;
                        if( property_exists($total, 'priceBeforeTax') ) {
                            $price = $total->priceBeforeTax;
                        }
                        if( property_exists($total, 'taxAmount') ) {
                            $tax = $total->taxAmount;
                        }
                        $price+=$tax;
                        $room_info[$room_object->roomType->id][$room_object->ratePlan->id]['price'] = $price;
//                        dump([$room_object->roomType->id => $room_object->ratePlan->id]);
                    }
                }
            }
        }
        return $room_info;
    }

    public function getObjectById($object_id)
    {
        $object = $this->callApi($this->apiContentUrl.'/v1/properties/'.$object_id, [], 'GET');
        return json_decode($object, true);
    }

    /**
     * @param $url
     * @param $params
     * @return bool|string
     */
    public function callApi($url,$params, $type = "POST"): bool|string
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
                'x-api-key: ' . config('api.travelline_api_key'),
                'Content-Type: application/json'
            ),
        );
        if($type == "POST") {
            $curl_params[CURLOPT_POSTFIELDS] = json_encode($params);
        }

        curl_setopt_array($curl, $curl_params);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
