<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Services\AccommodationService;
use App\Services\IslandService;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    protected $service;

    protected $islandservice;

    public function __construct(AccommodationService $service,IslandService $islandservice)
    {
        $this->service = $service;

        $this->islandservice = $islandservice;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Accommodation::latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource .
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accommodation  $Accommodation
     * @return \Illuminate\Http\Response
     */
    public function show(Accommodation $Accommodation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accommodation  $Accommodation
     * @return \Illuminate\Http\Response
     */
    public function edit(Accommodation $Accommodation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accommodation  $Accommodation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accommodation $Accommodation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accommodation  $Accommodation
     * @return \Illuminate\Http\Response
     */

    public function destroy(Accommodation $Accommodation)
    {
        $Accommodation->delete();
    }

    public function search(Request $request) {

        //var_dump($request);
        $data = $this->service->search($request);

       // var_dump($data);

       $res = $this->islandservice->api($request);

       //$res['count'] = count($res);

       //var_dump($res['count']);

        if($res){
            $r = [
                'res'   => $res
            ];

            $data = array_merge($data,$r);

            $data['count'] = $data['count'] + count($res);
        }

        //var_dump($data['count']);
        
        return view('list',$data);
    }
}
