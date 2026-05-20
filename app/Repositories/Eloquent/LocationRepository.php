<?php
namespace App\Repositories\Eloquent;

use App\Models\Loctaion;
use App\Repositories\Interfaces\LocationRepositoryInterface;

class LocationRepository implements LocationRepositoryInterface{
    public function create(array $data)
    {
        return Loctaion::create($data);
    }
    public function update(int $id,array $data)
    {
        $this->index($id)->update($data);
        return $this->index($id);
    }
    public function delete(int $id)
    {
        return Loctaion::destroy($id);
    }
    public function index(int $id)
    {
        return Loctaion::find($id);
    }
}

