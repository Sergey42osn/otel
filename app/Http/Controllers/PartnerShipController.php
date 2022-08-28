<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\Document;
use Auth;
class PartnerShipController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function document(Request $request, UserService $userService)
    {
        $documents = Document::where([['user_id',\Auth::user()->id],['type',2]])->paginate(2);
        return view('auth.vendor.vendor-documents',['documents'=>$documents]);
    }
    public function finance(Request $request, UserService $userService)
    {
        $documents = Document::where([['user_id',\Auth::user()->id],['type',1]])->paginate(2);
        return view('auth.vendor.vendor-finance',['documents'=>$documents]);
    }
}
