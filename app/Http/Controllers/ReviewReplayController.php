<?php

namespace App\Http\Controllers;

use App\Services\ReviewReplayService;
use Illuminate\Http\Request;

class ReviewReplayController extends Controller
{
    protected $service;

    public function __construct(ReviewReplayService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request){
       $data= $request->validate([
            'body'=>'required|string',
            'title'=>'required|string',
            'review_id'=>'required|integer',
        ]);
        return $this->service->create($data);
    }
    public function update(Request $request,$id){
        $data= $request->validate([
            'body'=>'sometimes|required|string',
            'title'=>'sometimes|required|string',
        ]);
        return $this->service->update($data,$id);
    }
    public function delete($id){
        return $this->service->delete($id);
    }

}
