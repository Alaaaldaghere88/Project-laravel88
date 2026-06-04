<?php
namespace App\Services;

use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\BaseResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsService
{
    use BaseResponse;
    protected $propertyRepository;
    protected $appointmentRepository;
    protected $userRepository;
    public function __construct( PropertyRepositoryInterface $propertyRepository,
    AppointmentRepositoryInterface $appointmentRepository,
    UserRepositoryInterface $userRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->appointmentRepository = $appointmentRepository;
        $this->userRepository = $userRepository;
    }
    public function getStatistics()
    {
        $user=auth()->user();
        if($user->hasRole('admin')){
            return $this->getAdminStatistics();
        }
        else{
            return $this->getOwnerStatistics();
        }
        $totalProperties = $this->propertyRepository->count();
        $totalAppointments = $this->appointmentRepository->count();
        $totalUsers = \App\Models\User::count();
        $totalReviews = \App\Models\Review::count();

        return [
            'total_properties' => $totalProperties,
            'total_appointments' => $totalAppointments,
            'total_users' => $totalUsers,
            'total_reviews' => $totalReviews,
        ];
    }
    public function getAdminStatistics()
    {
        $totalProperties = $this->propertyRepository->get()->count();
        $totalAppointments = $this->appointmentRepository->getAll()->count();
        $totalUsers = $this->userRepository->getAll()->count();
        return $this->successResponse('Statistics',JsonResource::make([
            'total_properties' => $totalProperties,
            'total_appointments' => $totalAppointments,
            'total_users' => $totalUsers,
        ]));
    }
    public function getOwnerStatistics()
    {
        $userId = auth()->id();
        $totalProperties = $this->propertyRepository->getByOwnerId($userId)->count();
        $totalAppointments = $this->appointmentRepository->getByOwnerId($userId)->count();
        return $this->successResponse('Statistics',JsonResource::make([
            'total_properties' => $totalProperties,
            'total_appointments' => $totalAppointments,
        ]));
    }
}
