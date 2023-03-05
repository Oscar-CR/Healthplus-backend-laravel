<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    public function login(Request $request){
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user_data = [];
        $user = User::where('email', $request->email)->first();
        
        //Valida password encriptado
        if (!Hash::check($request->password, $user->password)) {
            return array(['message' =>'Contraseña incorrecta, verifica e intentalo de nuevo']); 
        }

        //El proyecto se configuro para un solo token por usuario (se puede camibiar esta condicion)
        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        //Se crea un nuevo token
        $user->createToken($request->email)->plainTextToken;
        $token = DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->value('token');
    
        array_push($user_data, (object)[
            'fullname' => $user->fullname,
            'token' => $token,
        ]);
        
        return $user_data;
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $user = User::all()->where('email', $request->email)->first();
        
        if($user == null){
            return array(['message' =>'Usuario no encontrado']);
        }

        $new_password = Str::random(10);
        $encrypted_password = Hash::make($new_password);

        DB::table('users')->where('id', $user->id)->update([
            'password' => $encrypted_password, 
        ]);

        try {
            //Mail::to($user->email)->send(new RecoveryMail($user->email,$new_password));
            DB::table('personal_access_tokens')->where('name', $request->email)->delete();
        } catch (\Exception $e) {
        }
        
        return array(['message' =>'Email enviado con exito']);
    }

    public function createUser(Request $request){

        $request->validate([
            'fullname' => 'required',
            'email' => 'required',
            'password' => 'required',
            'token'=>'required'
        ]);

        $user_token = Token::all()->where('token',$request->token)->first();
        $find_email = User::all()->where('email',$request->email)->all(); 

        if(count($find_email)<>0){
            return array(['message' =>'Este correo ya está en uso']);
        }
        
        if($user_token == null){
            return array(['message' =>'Token invalido']);
        }

        $user = User::all()->where('id',$user_token->tokenable_id)->first();

        $encrypted_password = Hash::make($request->password);
        $user = new User();
        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->password = $encrypted_password;
        $user->save();

        return  array (['message' =>'Usuario creado satisfactoriamente']);

    }
}
