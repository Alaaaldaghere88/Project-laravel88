<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $service;

    public function __construct(ReviewService $service)
    {
        $this->service = $service;
    }
    public function index($property_id)
    {
        return $this->service->get($property_id);
    }
    public function create(Request $request)
    {
        $data = $request->validate([
            'body' => 'required|string',
            'title' => 'required|string',
            'property_id' => 'required|integer'
        ]);
        return $this->service->create($data);
    }
    public function show($id)
    {
        return $this->service->getById((int)$id);
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'body' => 'sometimes|string',
            'title' => 'sometimes|string',
        ]);

        return $this->service->update($data, (int)$id);
    }
    public function destroy($id)
    {
        return $this->service->delete((int)$id);
    }
}
