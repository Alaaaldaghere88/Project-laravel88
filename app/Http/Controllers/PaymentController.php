<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    public function getPaymentById(int $id)
    {
        return $this->paymentService->getPaymentById($id);
    }
    public function getAllPayments()
    {
        return $this->paymentService->getAllPayments();
    }
    public function filterPayments(Request $request)
    {
        $filter = $request->validate(['status' => 'required|in:pending,paid,failed,refunded,unpaid']);
        return $this->paymentService->filterPayments($filter['status']);
    }
}
