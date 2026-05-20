<?php

namespace App\Http\Controllers;

use App\Services\LocationService;
use Illuminate\Http\Request;

class LoctaionController extends Controller
{
    protected $locationService;
    public function __construct(LocationService $locationService)
    {
         $this->locationService = $locationService;
    }
    public function create(Request $request)
    {        $data = $request->validate(['tall'=>'required|numeric',
                        'width'=>'required|numeric']);
        return $this->locationService->create($data);
    }
    public function update(Request $request,int $id)
        {        $data = $request->validate(['tall'=>'sometimes|numeric',
                        'width'=>'sometimes|numeric']);
        return $this->locationService->update($id,$data);

    }
    public function delete(int $id)
    {
        return $this->locationService->delete($id);

    }
    public function index(int $id)
    {
        return $this->locationService->index($id);
    }

}
