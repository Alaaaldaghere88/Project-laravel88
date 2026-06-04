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
        return false;
    }
   $start = \Carbon\Carbon::parse($data['appointment_date']);
    $days = (int) ($data['days_num'] ?? 1);
    $end = $start->copy()->addDays($days - 1);
    return $this->model->where('property_id', $data['property_id'])
        ->where('status', '!=', 'rejected')
        ->where(function ($query) use ($start, $end) {
            $query->where(function ($q) use ($start, $end) {
                $q->whereDate('appointment_date', '<=', $end)
                  ->whereRaw('DATE_ADD(appointment_date, INTERVAL days_num - 1 DAY) >= ?', [$start]);
            });
        })
        ->exists();
    }
    public function filter(array $filters)
    {
    $query = $this->model->query();
    $user=auth()->user();
    if(!$user->hasRole('admin'))
        $query->where(function($q) use ($user){
            $q->where('user_id', $user->id)
              ->orWhereHas('property', function ($query) use ($user) {
                  $query->where('user_id', $user->id);
              });
        });
    if (!empty($filters['appointment_date'])) {
        $query->where('appointment_date', $filters['appointment_date']);
    }
    if (!empty($filters['status'])) {
        $query->where('status', $filters['status']);
    }
    return $query->get();
    }
    public function getByOwnerId(int $ownerId)
    {
    return $this->model->whereHas('property', function ($query) use ($ownerId) {
        $query->where('user_id', $ownerId);
    })->get();
    }

}
