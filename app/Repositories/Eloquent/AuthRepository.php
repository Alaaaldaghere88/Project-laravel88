<?php
namespace App\Repositories\Eloquent;

use App\Mail\OtpMail;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthRepository implements AuthRepositoryInterface{

private $model;
public function __construct(User $model)
{
     $this->model=$model;
}
public function register(array $data){
  $otp=rand(100000,999999);//;
$user= $this->model->create([
            'first_name'     =>$data['first_name'],
            'last_name'    => $data['last_name'],
            'phone'=>$data['phone'],
            'email'=>$data['email'],
            'password' => Hash::make($data['password']),
            'otp'=>$otp
        ]);
        $user->assignRole($data['role']);
     Mail::to($user->email)->send(new OtpMail($otp));
       $token = $user->createToken('auth_token')->plainTextToken;
       return ['user'=>$user,'token'=>$token];
}
public function login(array $data){
  $user = $this->model->where('email', $data['email'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
           return null;
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return ['user' => $user, 'token' => $token];
}
public function me(){
 return auth()->user();
}
public function logout(){
  return  auth()->user()->currentAccessToken()->delete();
}
public function verify(array $data)
{
$user=auth()->user();
if($data['otp']!=$user->otp)
    return null;
$user->otp=null;
$user->email_verified_at=now();
$user->save();
return $user;
}
}
