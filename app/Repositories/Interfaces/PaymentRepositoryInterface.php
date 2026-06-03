<?php
namespace App\Repositories\Interfaces;
interface PaymentRepositoryInterface
{
    public function create(array $data);
    public function getById(int $id);
    public function update(int $id, array $data);
    public function getAll();
    public function filter(string $filter);
}
