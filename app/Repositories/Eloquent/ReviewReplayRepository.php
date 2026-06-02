<?php
namespace App\Repositories\Eloquent;

use App\Models\ReviewReplay;
use App\Repositories\Interfaces\ReviewReplayRepositoryInterface;

class ReviewReplayRepository implements ReviewReplayRepositoryInterface{
    protected $reviewReplay;

    public function __construct(ReviewReplay $reviewReplay){
        $this->reviewReplay = $reviewReplay;
    }

    public function create(array $data){
        return $this->reviewReplay->create($data);
    }

    public function update(array $data,int $id){
        $replay=$this->getById($id);
        $replay->update($data);
        return $replay;
    }

    public function delete(int $id){
        return $this->reviewReplay->where('id',$id)->delete();
    }
    public function getById($id){
        return $this->reviewReplay->find($id);
    }

}
