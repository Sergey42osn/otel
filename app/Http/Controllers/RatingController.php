<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingCreateRequest;
use App\Mail\SendActivationVendorMail;
use App\Mail\SendInfoForRegMail;
use App\Models\Rating;
use App\Models\User;
use App\Models\RatingAnswer;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Mail;
use App\Mail\SendReviewAnswerMail;

class RatingController extends Controller
{
    protected $ratingService;
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param RatingCreateRequest $request
     * @return mixed
     */
    public function store(RatingCreateRequest $request)
    {
        $data = $request->all();
        return $this->ratingService->store($data);


    }

    public function reply(Request $request)
    {
        $rating_answer = RatingAnswer::create([
            'rating_id' => $request->rating_id,
            'type' => $request->type,
            'answer' => $request->answer
        ]);
        $maildata = [
            'desc'=>__('auth.Hello'),
            'answer'=>$request->answer
        ];
        $email = User::find(Rating::find($request->rating_id)->user_id)->email;
        if($request->type == 1){
            Mail::to($email)->send(new SendReviewAnswerMail($maildata));
        } else {
            Mail::to('anushmanucharyan1997@gmail.com')->send(new SendReviewAnswerMail($maildata));
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
