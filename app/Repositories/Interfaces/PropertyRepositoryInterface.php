<?php
namespace App\Repositories\Interfaces;
interface PropertyRepositoryInterface{
    public function get();
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function filter(array $filters);
    public function suggestion(int $id);
    public function changeStatus($id, $status);
    public function active($id,$flag);
}
