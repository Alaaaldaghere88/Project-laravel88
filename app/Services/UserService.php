<?php
namespace App\Services;

use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\BaseResponse;

class UserService{
    use BaseResponse;
    protected $repository;
    public function __construct( UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function create(array $data){
        return $this->successResponse(__('messages.created_done'),UserResource::make($this->repository->create($data)));
    }
    public function update(array $data,int $id){
        return $this->successResponse(__('messages.updated_done'),UserResource::make($this->repository->update($data,$id)));
    }
    public function getById(int $id){
        return $this->successResponse(__('messages.retrieved_successfully'),UserResource::make($this->repository->getById($id)));
    }
    public function delete(int $id){
        return $this->successResponse(__('messages.deleted_done'),UserResource::make($this->repository->delete($id)));
    }
    public function getAll(){
        return $this->successResponse(__('messages.retrieved_successfully'),UserResource::collection($this->repository->getAll()));
    }
    public function changeActiveStatus(int $id){
        return $this->successResponse(__('messages.change_status_done'),UserResource::make($this->repository->changeActiveStatus($id)));
    }
}
