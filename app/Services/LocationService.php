<?php
namespace App\Services;

use App\Repositories\Interfaces\LocationRepositoryInterface;
use App\Traits\BaseResponse;

class LocationService{
    use BaseResponse;
    protected $locationRepository;
    public function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }
    public function create(array $data)
    {
        return $this->locationRepository->create($data);
    }
    public function update(int $id,array $data)
    {
        $existence = $this->handleExistence($id);
        if(!$existence){
            return $this->errorResponse("Location not found");
        }
         $data=$this->locationRepository->update($id,$data);
         return $this->successResponse("Location updated successfully",$data);
    }
    public function delete(int $id)
    {
        $existence = $this->handleExistence($id);
        if(!$existence){
            return $this->errorResponse("Location not found");
        }
         $this->locationRepository->delete($id);
         return $this->successResponse("Location deleted successfully");
    }
    public function index(int $id)
    {
        $existence = $this->handleExistence($id);
        if(!$existence){
            return $this->errorResponse("Location not found");
        }
        $data=$this->locationRepository->index($id);
        return $this->successResponse("Location retrieved successfully",$data);
    }
    public function handleExistence(int $id)
    {
        return is_null($this->locationRepository->index($id))? false: true;
    }

}
