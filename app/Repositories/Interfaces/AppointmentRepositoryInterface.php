<?php
namespace App\Repositories\Interfaces;
interface AppointmentRepositoryInterface
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getById(int $id);
    public function getAll();
    public function getAccessibleAppointments(int $userId);
    public function sameDay(array $data);
    public function filter(array $filters);

}
