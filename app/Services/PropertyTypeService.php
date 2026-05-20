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
        return $this->successResponse('success',$this->propertyTypeRepository->get());
    }
}
