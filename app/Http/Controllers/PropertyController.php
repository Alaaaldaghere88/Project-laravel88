<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProperty;
use App\Http\Requests\UpdateProperty;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected $service;
    public function __construct(PropertyService $service)
    {
        $this->service = $service;
    }
    public function get(){
        return $this->service->get();
    }
    public function getById($id){
        return $this->service->getById($id);
    }
    public function create(CreateProperty $request){
        return $this->service->create($request->validated());
    }
    public function update($id, UpdateProperty $request){
        return $this->service->update($id, $request->validated());
    }
    public function delete($id){
        return $this->service->delete($id);
    }
}
