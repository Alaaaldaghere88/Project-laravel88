<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\BaseImages;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface{
    use BaseImages;
    protected $model;
    public function __construct(User $model)
    {
        $this->model=$model;
    }
    public function create(array $data){
        if(isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        if(isset($data['photo'])){
         $path=$this->create_image($data['photo'],'users');
         $data['photo']=$path;
        }
        $user=$this->model->create($data);
        $user->assignRole($data['role']);
     return $user;
    }


    public function update(array $data,int $id){
     $user=$this->getById($id);
     if(isset($data['photo'])){
         $path=$this->update_image($user->photo,$data['photo'],'users');
         $data['photo']=$path;
        }
     $user->update($data);
     return $user;
    }
    public function getById(int $id){
     return $this->model->find($id);
    }
    public function delete(int $id){
     $this->delete_image($this->getById($id)->photo);
     return $this->model->destroy($id);
    }
    public function getAll(){
     return $this->model->all();
    }
    public function changeActiveStatus(int $id){
        $user=$this->getById($id);
        $user->active=!$user->active;
        $user->save();
        return $user;
    }
}
