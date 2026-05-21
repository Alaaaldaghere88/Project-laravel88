<?php
namespace App\Services;

use App\Traits\BaseResponse;
class CategoryService
{
    use BaseResponse;
    protected $repository;
    public function __construct(\App\Repositories\Interfaces\CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function get()
    {
        return $this->repository->getAllCategories();
    }
    public function getById($id)
    {
        $category=$this->repository->getCategoryById($id);
        if(!$category){
            return $this->errorResponse('Category not found',404);
        }
        return $this->successResponse('success',$category);
    }
    }
