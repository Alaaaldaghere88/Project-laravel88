<?php
namespace App\Repositories\Eloquent;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
class ReviewRepository implements ReviewRepositoryInterface{
    protected $model;
    public function __construct(Review $model)
    {
        $this->model=$model;
    }
    public function create(array $data){
      $data['user_id']=auth()->id();
     return $this->model->create($data);
    }
    public function update(array $data,int $id){
     $review=$this->getById($id);
     $review->update($data);
     return $review;
    }
    public function get($property_id){
     return  $this->model->where('property_id',$property_id)->get();
    }
    public function getById(int $id){
     return $this->model->find($id);
    }
    public function delete(int $id){
     return $this->model->destroy($id);
    }
}
