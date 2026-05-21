<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Traits\BaseResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use BaseResponse;
    protected $service;
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }
    public function get()
    {
        return $this->service->get();
    }
    public function getById($id)
    {
        return $this->service->getById($id);
    }
}
