<?php

namespace App\Services;

use App\Http\Resources\PropertyResource;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Traits\BaseImages;
use App\Traits\BaseResponse;
use Illuminate\Support\Facades\Auth;

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

    public function canAccess($property): bool
    {
        $user = auth()->user();
        if ($user?->hasRole('admin')) return true;
        return $property->user_id === $user?->id;
    }
}
