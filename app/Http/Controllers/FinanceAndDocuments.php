<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
//use App\Models\Order;
use Auth;
class FinanceAndDocumentsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, UserService $userService)
    {
        return view('auth.vendor.vendor-documents');
    }
}
