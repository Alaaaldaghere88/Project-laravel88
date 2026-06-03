<?php

namespace App\Services;

use App\Http\Resources\PropertyResource;
use App\Notifications\CustomNotification;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Traits\BaseImages;
use App\Traits\BaseResponse;
use Illuminate\Support\Facades\Auth;
use App\Events\SendNotificationMessage;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class PropertyService
{
    use BaseResponse;

    public function __construct(
        protected PropertyRepositoryInterface $propertyRepository
    ) {}

    public function get()
    {
        return $this->successResponse('success', PropertyResource::collection($this->propertyRepository->get()));
    }

    public function getById($id)
    {
        $property = $this->propertyRepository->getById($id);

        if (!$property) {
            return $this->errorResponse('Property not found', 404);
        }

        return $this->successResponse('success', new PropertyResource($property));
    }

    public function create(array $data)
    {
        $property = $this->propertyRepository->create($data);
        $admins = User::role('admin')->get();
        $title = __('messages.new_property');
        $message = __('messages.A new property has been created with ID: :id', [
         'id' => $property->id
         ]);
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new CustomNotification($message, $title));
         }
        return $this->successResponse('Property created successfully', new PropertyResource($property), 201);
    }

    public function update($id, array $data)
    {
        $property = $this->propertyRepository->getById($id);
        if (!$property) {
            return $this->errorResponse('Property not found', 404);
        }

        if (!$this->canAccess($property)) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $updatedProperty = $this->propertyRepository->update($id, $data);
        return $this->successResponse('Property updated successfully', new PropertyResource($updatedProperty));
    }

    public function delete($id)
    {
        $property = $this->propertyRepository->getById($id);
        if (!$property) {
            return $this->errorResponse('Property not found', 404);
        }

        if (!$this->canAccess($property)) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $this->propertyRepository->delete($id);
        return $this->successResponse('Property deleted successfully', null);
    }
    public function filter(array $filters)
    {
        $properties = $this->propertyRepository->filter($filters);
        return $this->successResponse('success', PropertyResource::collection($properties));
    }

    public function canAccess($property): bool
    {
        $user = auth()->user();
        if ($user?->hasRole('admin')) return true;
        return $property->user_id === $user?->id;
    }
     public function suggestion(int $categoryId)
    {
        $appointments = $this->propertyRepository->suggestion($categoryId);
        return $this->successResponse(__('messages.retrieved_successfully'), PropertyResource::collection($appointments));
    }
    public function changeStatus($id, $status)
    {
        $property = $this->propertyRepository->getById($id);
        if (!$property) {
            return $this->errorResponse(__('messages.not_found'), 404);
        }

        if (!$this->canAccess($property)) {
            return $this->errorResponse(__('messages.unauthorized'), 403);
        }

        $this->propertyRepository->changeStatus($id, $status);
        return $this->successResponse(__('messages.status_updated'), null);
    }
    public function active($id,$flag){
        $property = $this->propertyRepository->getById($id);
        if (!$property) {
            return $this->errorResponse(__('messages.not_found'), 404);
        }
        $this->propertyRepository->active($id,$flag);
        $user=$property->user;
        $user->notify(
    new CustomNotification(
        __('messages.Active property changed successfully'),
        __('messages.Active property changed successfully')
    )
);
        return $this->successResponse(__('messages.change_status_done'), null);
    }
}
