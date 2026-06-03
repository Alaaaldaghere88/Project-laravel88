<?php
namespace App\Repositories\Eloquent;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Models\Payment;
class PaymentRepository implements PaymentRepositoryInterface
{
    protected $model;
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function update(int $id, array $data)
    {
        $payment = $this->model->findOrFail($id);
        $payment->update($data);
        return $payment;
    }
    public function getById(int $id)
    {
        return $this->model->findOrFail($id);
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function filter(string $filter)
    {
       return $this->model->where('status', $filter)->get();
    }
}
