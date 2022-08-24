<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Authorregister;
use App\Http\Requests\AuthorRequest;
use App\Http\Requests\changepassword;
use App\Http\Requests\loginequest;
use App\Http\Requests\loginrequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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

class AuthorController extends Controller
{
    public function register(AuthorRequest $request){
        if(User::where('email',$request->email)->first()){
            return response([
                'message'=> 'email already exist!!',
                'status'=>'failed',
            ],401);
        }
        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $token= $user->createToken($request->email)->plainTextToken;
        return response([
              'message'=>"user registered!!",
              'status' =>"success",
              'token'=>$token           
        ],201);
   
    }
    public function login(loginrequest $request){
        $user = User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            $token=$user->createToken($request->email)->plainTextToken; 
            return response([
                'token' => $token,
                'message'=> "successfully logged in!",
             ]);   
        }
        else{
            return response([
                'message'=>'invalid details!!!',
            ]);
        }
         
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            "message"=> "logged out"
        ]);
    }
    // create api for email verifications ,
    // use smtp for send email
    // Routes setup for mail verification
    public function sendVerifyMail($email)
    {
        if(auth()->user()){
            $user= User::where('email',$email)->get();
            if(count($user) > 0){
                $random = Str::random(40);
                $domain=URL::to('/');
                $url=$domain.'/'.$random;
                $data['url']=$url;
                $data['email']= $email;
                $data['title']= "email verification";
                $data['body']="please verify your email by clicking on brlow link.";
                Mail::send('VerifyMail',['data'=>$data],function($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);
                });



            }else{
            return response()->json([
                'success'=>false,
                'msg'=>"user not found!!!",
            ]);
        }
    }
        else
        {
            return response()->json([
                'success'=>false,
                'msg'=>"error in loading not authenticate user.",
            ]);

        }
    }
    public function change_password(changepassword $request){
               $loggeduser=auth()->user();
               $loggeduser->password= Hash::make($request->password);
               $loggeduser->save();
               return response()->json([
                'message'=>"password changed successfully!!!",
                'status' => "success",
               ],200);
      
    }

}    
