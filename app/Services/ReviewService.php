<?php
namespace App\Services;

use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Traits\BaseResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Resources\ReviewResource;
class ReviewService{
    use BaseResponse;
    protected $repo;
    public function __construct(ReviewRepositoryInterface $repo)
    {
    $this->repo=$repo;
    }
    public function create(array $data){
     return $this->successResponse("Created done",ReviewResource::make($this->repo->create($data)),201);
    }
    public function update(array $data,int $id){
     $this->check($id);
     return $this->successResponse('Updated done',ReviewResource::make($this->repo->update($data,$id)));
    }
    public function get($property_id){
     return  $this->successResponse('success',ReviewResource::collection($this->repo->get($property_id)));
    }
    public function getById(int $id){
       $review=$this->repo->getById($id);
        if(!$review )
            throw new HttpResponseException($this->errorResponse('Review not found',404));
     return $this->successResponse('success',ReviewResource::make($this->repo->getById($id)));
    }
    public function delete(int $id){
      $this->check($id);
      $this->repo->delete($id);
      return $this->successResponse("Deleted done");
    }
    public function check($id){
        $review=$this->repo->getById($id);
        $user=auth()->user();
        if(!$review )
            throw new HttpResponseException($this->errorResponse('Review not found',404));
        if($user->id!=$review->user_id)
            throw new HttpResponseException($this->errorResponse('You can\'t access this',403));
    }

}
