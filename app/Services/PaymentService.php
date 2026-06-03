<?php
namespace App\Services;

use App\Http\Resources\PaymentResource;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Traits\BaseResponse;
class PaymentService {
    use BaseResponse;
    protected $paymentRepository;
    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }
    public function getPaymentById(int $id)
    {
        return $this->successResponse(__('messages.retrieved_successfully'),PaymentResource::make($this->paymentRepository->getById($id)));
    }
    public function getAllPayments()
    {
        return $this->successResponse(__('messages.retrieved_successfully'), PaymentResource::collection($this->paymentRepository->getAll()));
    }
    public function filterPayments(string $filter)
    {
        return $this->successResponse(__('messages.retrieved_successfully'), PaymentResource::collection($this->paymentRepository->filter($filter)));
    }
}
