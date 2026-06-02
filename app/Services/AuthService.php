<?php
namespace App\Services;

use App\Repositories\Eloquent\AuthRepository;
use App\Traits\BaseImages;
use App\Traits\BaseResponse;

class AuthService{
private $repo;
use BaseResponse;
use BaseImages;
public function __construct(AuthRepository $repo)
{
     $this->repo=$repo;
}
public function register(array $data){
 return $this->successResponse("Registered successfully",$this->repo->register($data));
}
public function login(array $data){
 return is_null($this->repo->login($data))?$this->errorResponse("Invalid credentials"): $this->successResponse("Logged in successfully",$this->repo->login($data));
}
public function me(){
 return  $this->successResponse("User data retrieved successfully",$this->repo->me());
}
public function logout(){
  return  $this->successResponse("Logged out successfully",$this->repo->logout());
}
public function verify(array $data)
{

return is_null($this->repo->verify($data))?$this->errorResponse("Invalid Otp"): $this->successResponse("Account verified successfully");
}
public function updateInfo(array $data){
    $user=auth()->user();
    if(isset($data['photo'])&& $data['photo']!=null){
        $path=$this->update_image($user->photo,$data['photo'],'users');
        $data['photo'] = $path;
    }
    return $this->successResponse("User info updated successfully",$this->repo->updateInfo($data));
}
}
