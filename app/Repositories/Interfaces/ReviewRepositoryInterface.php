<?php
namespace App\Repositories\Interfaces;
interface ReviewRepositoryInterface{
public function create(array $data);
public function update(array $data,int $id);
public function get(int $property_id);
public function getById(int $id);
public function delete(int $id);
}
