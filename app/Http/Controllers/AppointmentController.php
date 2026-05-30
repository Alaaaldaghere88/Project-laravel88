<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointment;
use App\Http\Requests\UpdateAppointment;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentService;
   public function __construct(AppointmentService $appointmentService)
   {
       $this->appointmentService = $appointmentService;
   }
   public function create(CreateAppointment $request)
   {
       $data = $request->validated();
       return $this->appointmentService->createAppointment($data);
   }
   public function update(UpdateAppointment $request,$id)
   {
       $data = $request->validated();
       return $this->appointmentService->updateAppointment($id,$data);
   }
   public function get(){
    return $this->appointmentService->getAllAppointments();
   }
   public function getById($id){
    return $this->appointmentService->getAppointmentById($id);
   }
   public function delete($id){
    return $this->appointmentService->deleteAppointment($id);
   }
   public function cancel($id){
    return $this->appointmentService->cancelAppointment($id);
   }
}
