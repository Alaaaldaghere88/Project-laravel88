<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogInRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $service;
public function __construct(AuthService $service)
{
     $this->service=$service;
}
public function register(RegisterRequest $request){
    $data=$request->validated();
 return $this->service->register($data);
}
public function login(LogInRequest $request){
    $data=$request->validated();
 return $this->service->login($data);
}
public function me(){
 return $this->service->me();
}
public function logout(){
  return  $this->service->logout();
}
public function verify()
{
    $data=request()->validate(['otp'=>'required|numeric|digits:6']);
return $this->service->verify($data);
}
public function updateInfo(UpdateInfoRequest $request){
    $data=$request->validated();
    return $this->service->updateInfo($data);
}
}
