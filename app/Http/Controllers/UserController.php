<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateUser;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;
    public function __construct( UserService $service)
    {
        $this->service = $service;
    }
    public function create(CreateUser $request){
        $data=$request->validated();
        return $this->service->create($data);
    }
    public function update(UpdateUser $request,int $id){
        $data=$request->validated();
        return $this->service->update($data,$id);
    }
    public function delete(int $id){
        return $this->service->delete($id);
    }
    public function getById(int $id){
        return $this->service->getById($id);
    }
    public function getAll(){
        return $this->service->getAll();
    }
    public function changeActiveStatus(int $id){
        return $this->service->changeActiveStatus($id);
    }
}
