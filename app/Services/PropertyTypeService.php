<?php
namespace App\Services;

use App\Repositories\Interfaces\PropertyTypeRepositoryInterface;
use App\Traits\BaseResponse;

class PropertyTypeService{
    protected $propertyTypeRepository;
    use BaseResponse;
    public function __construct( PropertyTypeRepositoryInterface $propertyTypeRepository)
    {
        $this->propertyTypeRepository = $propertyTypeRepository;
    }
    public function get()
    {
        return $this->successResponse(__('messages.retrieved_successfully'),$this->propertyTypeRepository->get());
    }
    public function getById($id)
    {
        $propertyType = $this->propertyTypeRepository->getById($id);
        if(!$propertyType){
            return $this->errorResponse(__('messages.not_found'),404);
        }
        return $this->successResponse(__('messages.retrieved_successfully'),$propertyType);
    }
}
