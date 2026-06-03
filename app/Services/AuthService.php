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
 return $this->successResponse(__('messages.created_done'),$this->repo->register($data));
}
public function login(array $data){
 return is_null($this->repo->login($data))?$this->errorResponse(__('messages.Unauthorized')): $this->successResponse(__('messages.logged_in_successfully'),$this->repo->login($data));
}
public function me(){
 return  $this->successResponse(__('messages.retrieved_successfully'),$this->repo->me());
}
public function logout(){
  return  $this->successResponse(__('messages.logged_out_successfully'),$this->repo->logout());
}
public function verify(array $data)
{

return is_null($this->repo->verify($data))?$this->errorResponse(__('messages.Invalid_Otp')): $this->successResponse(__('messages.Account_verified_successfully'));
}
public function updateInfo(array $data){
    $user=auth()->user();
    if(isset($data['photo'])&& $data['photo']!=null){
        $path=$this->update_image($user->photo,$data['photo'],'users');
        $data['photo'] = $path;
    }
    return $this->successResponse(__('messages.updated_done'),$this->repo->updateInfo($data));
}
}
