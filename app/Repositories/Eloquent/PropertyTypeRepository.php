<?php
namespace App\Repositories\Eloquent;

use App\Models\PropertyType;
use App\Repositories\Interfaces\PropertyTypeRepositoryInterface;

class PropertyTypeRepository implements PropertyTypeRepositoryInterface{
    public function get()
    {
        return PropertyType::all();
    }
    public function getById($id)
    {
        return PropertyType::find($id);
    }
}
