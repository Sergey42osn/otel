<?php

namespace App\Http\Controllers;

use App\Models\PartnerShip;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\UserPermission;
use Auth;
class FinanceAndDocumentsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function document(Request $request, UserService $userService)
    {

        $user = \Auth::user();
            if ( $user->role_id==3 ) {
                $us = UserPermission::where('user_id', $user->id)->first();
                if ($us  && $us->partner_ship_id != 2) {
                    $id = $us->owner_id;
                    if(isset($request->from) && isset($request->to)) {
                        $documents = Document::where([['user_id', $id], ['type', 2]])->whereBetween('date_at',[date('Y-m-d', strtotime($request->from)), date('Y-m-d', strtotime($request->to))])->paginate(2);
                    } else {
                        $documents = Document::where([['user_id', $id], ['type', 2]])->paginate(2);
                    }
                    return view('auth.vendor.vendor-documents', ['documents' => $documents]);
                }
            } elseif ($user->role_id == 1) {
                if(isset($request->from) && isset($request->to)) {
                    $documents = Document::where([['user_id', $user->id], ['type', 2]])->whereBetween('date_at',[date('Y-m-d', strtotime($request->from)), date('Y-m-d', strtotime($request->to))])->paginate(2);
                } else {
                    $documents = Document::where([['user_id', $user->id], ['type', 2]])->paginate(2);
                }
                return view('auth.vendor.vendor-documents', ['documents' => $documents]);
            }
            abort(404);
    }
    public function finance(Request $request, UserService $userService)
    {
        $user = \Auth::user();
        if ( $user->role_id==3 ) {
            $us = UserPermission::where('user_id', $user->id)->first();
            if ($us  && $us->partner_ship_id != 2) {
                $id = $us->owner_id;
                if(isset($request->from) && isset($request->to)) {
                    $documents = Document::where([['user_id', $id], ['type', 1]])->whereBetween('date_at',[date('Y-m-d', strtotime($request->from)), date('Y-m-d', strtotime($request->to))])->paginate(2);
                } else {
                    $documents = Document::where([['user_id', $id], ['type', 1]])->paginate(2);
                }
                return view('auth.vendor.vendor-finance', ['documents' => $documents]);
            }
        } elseif ($user->role_id == 1) {
            if(isset($request->from) && isset($request->to)) {
                $documents = Document::where([['user_id', $user->id], ['type', 1]])->whereBetween('date_at',[date('Y-m-d', strtotime($request->from)), date('Y-m-d', strtotime($request->to))])->paginate(2);
            } else {
                $documents = Document::where([['user_id', $user->id], ['type', 1]])->paginate(2);
            }
            return view('auth.vendor.vendor-finance', ['documents' => $documents]);
        }
        abort(404);
    }
}
