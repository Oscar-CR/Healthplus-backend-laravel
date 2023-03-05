<?php

namespace App\Http\Controllers;

use App\Models\DalyAdvance;
use App\Models\Disease;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userData($token)
    {
        $token = Token::all()->where('token',$token)->last();

        if($token == null){
            return  array (['message' =>'Usuario no encontrado']);
        }

        $user = User::all()->where('id', $token->tokenable_id)->last();
        $user_daly_advance = DalyAdvance::all()->where('user_id',$user->id);
        $diseases = Disease::all();

        $user_data = [];

        foreach($diseases as $disease){
            foreach($user_daly_advance as $daly_user){
                if($daly_user->disease_id == $disease->id){
                    array_push($user_data, (object)[
                        'disease' => $diseases->name,
                        'daly_advance' => $daly_user,
                    ]);
                }
            }
        }
        
        return $user_data;
    }

    public function postDalyAdvance(Request $request)
    {
        
    }

    public function editDalyAdvance(Request $request)
    {
            
    }


}
