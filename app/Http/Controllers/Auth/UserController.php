<?php

namespace App\Http\Controllers\Auth;
use Exception;
use App\Models\User;
use App\Models\Setting;
use App\Jobs\SendEmailJob; 
use App\Jobs\SendOtpJob;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\VerifyotpRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Passwordreset;
use App\Mail\passwordemail;
use App\Mail\otpemail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;



class UserController extends Controller
{
    // public function savelanguage(Request $request)
    // {
        
    //     $request->validate([
    //         'language' => 'required|string',  
    //         'email' => 'required|email',      
    //     ]);
    

    //     $user = User::where('email', $request->email)->first();
    
        
    //     if (!$user) {
    //         return response()->json([
    //             'message' => 'User not found'
    //         ], 404);
    //     }
    
    //     $setting =Setting::updateOrCreate(
    //         ['user_id' => $user->id,  
    //         'language' => $request->language]  
    //     );
    
        
    //     return response()->json([
    //         'message' => 'Language saved successfully',
    //         'data' => $setting
    //     ]);
    // }
    
    public function signup(RegistrationRequest $request){
        try{
        
            $password = Str::random(6);
            
            $user = User::create([
                'first_name' => $request->firstname,
                'last_name' => $request->lastname,
                'email' => $request->email,
                'phone_number' => $request->phonenumber,
                'password' => $password,
                'role' => $request->role ?? 'user',
            ]);
            
            $fullname = $request->firstname . ' ' . $request->lastname;
            SendEmailJob::dispatch($user, $password, $fullname);
            return response()->json([
                'status' => true,
                'message' => 'User registered Successfully, Password sent via email', //trans(key: 'lang.key')
                'user' => $user,
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error Occured',
            ],500);
        } 
     
    }

    public function login(LoginRequest $request){
        try{
            // dd($request->all());
            // // dump($request->session());
            // // dd(Session::all());
            // // dd(Session::get('lang'));
            // $language = session('lang'); 

            // dd($language);  
            if(Auth::attempt(['email'=>$request->email,'password'=> $request->password])){
                $authUser = Auth::user();
                $role = $authUser->role;
                // dd($authUser);
                return response()->json([
                    'status' => true,
                    'message' => 'User Logged in Successfully',
                    'role' => $role,

                    // 'token' => $authUser->createToken("API Token")->plainTextToken,
                    // 'tokn_type' => 'bearer',
                ],200); 
            } 
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Credentials',
                ],400);
            }
            catch(Exception $e){
                return response()->json([
                    'status' => false,
                    'message' => 'Error Occured',
                ],500);
            }        
    }

    public function forgetPassword(ForgetPasswordRequest $request){
        try{
            $user =User::where("email",$request->email)->first();

            $otp = random_int(100000, 999999);

            $user->passwordReset()->updateOrCreate(
                ["user_id" => $user->id], 
                [
                    "otp" => $otp,
                    "expiry_time" => now()->addMinutes(15), 
                ]
            );
            SendOtpJob::dispatch($user , $otp);

            // return redirect()->route('otp_view', ['email' => $user->email])->with([
            //     'status' => true,
            //     'message' => 'OTP sent to your email.',
            // ]);

            return response()->json([
                'status' => true,
                'message' => 'Email sent Successfully',
            ],200);
        }
        catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error Occured',
            ],500);
        } 

    }

    public function verifyOtp(VerifyotpRequest $request){
        try{
            $user = auth()->user();
            if (!$user && $request->has('email')) {
                $user = User::where('email', $request->email)->first();
            }
            $findotp = $user->passwordreset()
                            // ->where('user_id',$user->id)
                            ->where('otp', $request->otp)
                            ->where('expiry_time', '>', now())
                            ->first();
            if ($findotp){
                $findotp->delete();
                // return redirect()->route('reset_password',['email' => $user->email])->with([
                //     'status' => true,
                //     'message' => 'OTP sent to your email.',
                // ]);
                return response()->json([
                    'status' => true,
                    'message' => 'OTP Verified',
                ],200); 
                
            } else{
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP.',
                ], 400);
            }  
        } 
        catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error Occured',
            ],500);
        }                    
}
    public function resetPassword(ResetPasswordRequest $request){  
        try{ 
                $newpassword = $request->password;
                
                $user = User::where('email', $request->email)->first();
                $user->update(['password' => $newpassword]);

                return redirect()->route('signup')->with([
                    'status' => true,
                    'message' => 'Password reset successful.',
                ], 200);
            }
        catch (Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error Occurred',
            ],500);
        }   
    }
}
