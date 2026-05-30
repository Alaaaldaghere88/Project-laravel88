<?php
namespace App\Repositories\Eloquent;

use App\Enums\AppointmentStatus;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Models\Appointment;
class AppointmentRepository implements AppointmentRepositoryInterface
{
    protected $model;
    public function __construct(Appointment $model)
    {
        $this->model = $model;
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function update(int $id, array $data)
    {
        $appointment = $this->model->find($id);
        $appointment->update($data);
        return $appointment;
    }
    public function delete(int $id)
    {
        $appointment = $this->model->find($id);
        return $appointment->delete();
    }
    public function getById(int $id)
    {
        return $this->model->find($id);
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function getAccessibleAppointments(int $userId)
    {
        return $this->model->with('property')
        ->where('user_id', $userId)
        ->orWhereHas('property', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->latest()
        ->get();
    }
    public function sameDay(array $data)
    {
        if (!isset($data['appointment_date'])) {
        return;
    }
        return $this->model->whereDate('appointment_date', $data['appointment_date'])
        ->where('property_id', $data['property_id'])
        ->where('status', '!=', AppointmentStatus::Rejected)
        ->exists();
    }
}
