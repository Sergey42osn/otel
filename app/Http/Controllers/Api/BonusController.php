<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bonuses;

class BonusController extends Controller
{
    public function getBonus(Request $request)
    {
        if(Bonuses::where('email',$request->email)->first()) {
            return response()->json(['email_error'=>'Этот электронный адрес уже используется']);
        }
        elseif(Bonuses::where('phone',$request->phone)->first()) {
            return response()->json(['phone_error'=>'Этот номер телефона уже используется']);
        }
        else {
                $details = [
                    'content' => 'Здравствуйте, благодарим за предварительную регистрацию. В связи с этим, мы предоставляем  скидку до 20% на первую бронь, а также - возможность выиграть бесплатные ночи в отелях по всему миру. Ждите подробности в следующих письмах.',
                    'code' => $request->code
                ];
                \Mail::to($request->email)->send(new \App\Mail\SendBonusMail($details));
                $input['name'] = $request->name;
                $input['surname'] = $request->surname;
                $input['email'] = $request->email;
                $input['phone'] = $request->phone;
                $input['promocode'] = $request->code;
                Bonuses::create($input);
                return response()->json(['success'=>true]);
            }

    }
}
