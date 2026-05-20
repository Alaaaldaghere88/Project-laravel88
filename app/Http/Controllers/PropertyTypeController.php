<?php

namespace App\Http\Controllers;

use App\Services\PropertyTypeService;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    protected $service;
    public function __construct(PropertyTypeService $service)
    {
        $this->service = $service;
    }
    public function get()
    {
        return $this->service->get();
    }
}
