<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
   /**
     * @SWG\Get(
     *   path="/api/testing/{mytest}",
     *   summary="Get Testing",
     *   operationId="testing",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=406, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error"),
	 *		@SWG\Parameter(
     *          name="mytest",
     *          in="path",
     *          required=true, 
     *          type="string" 
     *      ),
     * )
     *
     */

class PasswordResetController extends Controller
{
    public function send_reset_password_email(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);         
    //check user email exist or not
    $user = User::where('email',$request->email)->first();
    if(!$user){
        return response()->json([
            'message'=>"email does not exist!!!",
            'status'=> "failed",
        ]);
    }
    $token=Str::random(60);
    PasswordReset::create([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
    ]);
        //dump("http://127.0.0.1:3000/api/user/reset" .$token);
        $email=$request->email;
        //Sending email with password reset 
        Mail::send('reset',['token'=>$token], function( Message $message)use($email){
        $message->subject('reset your password');
        $message->to($email);

        });

        return response()->json([
            'msg'=> "mailed successfully",
            'status'=> 'success'
        ],200);
    
    }
    public function reset(Request $request, $token){
        $request->validate([
            'password'=>'required|confirmed',
        ]);
        $passwordreset= PasswordReset::where('token',$token)->first();
        if(!$passwordreset){
            return response([
                'message'=>'token is invalid or expired',
                'status'  => 'failed',
            ],404);
        }
        $user=User::where('email',$passwordreset->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        
        //Delete the token after resetting the password
        PasswordReset::where('email',$user->email)->delete(); 
        return response([
            'message'=>'Password reset successfully',
            'status'  => 'success',
        ],200);
    }
}

