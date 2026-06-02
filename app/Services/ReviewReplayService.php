<?php
namespace App\Services;

use App\Http\Resources\ReviewReplayResource;
use App\Repositories\Interfaces\ReviewReplayRepositoryInterface;
use App\Traits\BaseResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReviewReplayService
{
    use BaseResponse;
    protected $reviewReplayRepository;
    public function __construct(ReviewReplayRepositoryInterface $reviewReplayRepository){
        $this->reviewReplayRepository = $reviewReplayRepository;
    }
    public function create(array $data){
        $data['user_id'] = auth()->id();
        return $this->successResponse("Created done",ReviewReplayResource::make($this->reviewReplayRepository->create($data)));
    }
    public function update(array $data,int $id){
        $this->canAccess($id);
        return $this->successResponse("Updated done",ReviewReplayResource::make($this->reviewReplayRepository->update($data,$id)));
    }
    public function delete(int $id){
        $this->canAccess($id);
        $this->reviewReplayRepository->delete($id);
        return $this->successResponse("Deleted done");
    }
    public function canAccess($id){
        $reviewReplay = $this->reviewReplayRepository->getById($id);
        if(!$reviewReplay){
            throw new HttpResponseException($this->errorResponse('Review replay not found',404));
        }
        if($reviewReplay->review->user_id != auth()->id()){
            throw new HttpResponseException($this->errorResponse('You are not allowed to access this review replay',401));
        }
    }
}
