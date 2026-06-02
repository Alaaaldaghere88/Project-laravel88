<?php

namespace App\Http\Controllers;

use App\Enums\PropertyStatus;
use App\Http\Requests\CreateProperty;
use App\Http\Requests\UpdateProperty;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public function filter(Request $request){
        $data = $request->validate([
            'filters' => 'array'
        ]);
        return $this->service->filter($data['filters']);
    }
     public function suggestion($categoryId)
    {
        return $this->service->suggestion($categoryId);
    }
    public function changeStatus($id)
    {
       $data = request()->validate([
             'status' => ['required', Rule::enum(PropertyStatus::class)],
             ]);
        return $this->service->changeStatus($id, $data['status']);
    }
    public function active($id)
    {
        $data = request()->validate([
            'flag' => 'required|boolean'
        ]);
        return $this->service->active($id, $data['flag']);
    }
}
