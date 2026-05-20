<?php
namespace App\Repositories\Interfaces;
interface LocationRepositoryInterface{
    public function create(array $data);
    public function update(int $id,array $data);
    public function delete(int $id);
    public function index(int $id);
}
