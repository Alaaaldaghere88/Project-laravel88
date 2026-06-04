<?php
namespace App\Repositories\Eloquent;
use App\Models\Property;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Traits\BaseImages;
class PropertyRepository implements PropertyRepositoryInterface{
    protected $model;
    use BaseImages;
    public function __construct(Property $model)
    {
        $this->model = $model;
    }
    public function get()
    {
        return $this->model->visibleToUser()->get();
    }
    public function getById($id)
    {
        return $this->model->visibleToUser()->find($id);
    }
    public function create(array $data)
    {
        $data['video']=$this->create_image($data['video'],'properties/videos');
        $data['document']=$this->create_image($data['document'],'properties/documents');
        $data['user_id']=auth()->id();
        return $this->model->create($data);
    }
    public function update($id, array $data)
    {
        $property = $this->model->find($id);
        if ($property) {
            if(isset($data['video'])){
                $this->delete_image($property->video);
                $data['video']=$this->update_image($data['video'],'properties/videos',$property->video);
            }
            if(isset($data['document'])){
                $this->delete_image($property->document);
                $data['document']=$this->update_image($data['document'],'properties/documents',$property->document);
            }
            $property->update($data);
            return $property;
        }
        return null;
    }
    public function delete($id)
    {
        $property = $this->model->find($id);
        if ($property) {
            $this->delete_image($property->video);
            $this->delete_image($property->document);
            $property->delete();
            return true;
        }
        return false;
    }

public function filter(array $filters)
{
    $query = $this->model->query();
    if (!empty($filters['min_price'])) {
        $query->where('price', '>=', $filters['min_price']);
    }
    if (!empty($filters['max_price'])) {
        $query->where('price', '<=', $filters['max_price']);
    }
    if (!empty($filters['rooms'])) {
        $query->where('rooms', $filters['rooms']);
    }
    if (!empty($filters['capacity'])) {
        $query->where('capacity', '>=', $filters['capacity']);
        }
        if (!empty($filters['location_id'])) {
        $query->where('location_id', $filters['location_id']);
         }
        if (!empty($filters['type_id'])) {
        $query->where('type_id', $filters['type_id']);
         }
      return $query->where('active', true)->get();
    }
     public function suggestion(int $id)
    {
        $appointments = $this->model->visibleToUser()->where('category_id',$id)->get();
        if (!$appointments) {
            return null;
        }
       return $appointments;
    }
    public function changeStatus($id, $status)
    {
        $property = $this->model->find($id);
        if ($property) {
            $property->status = $status;
            $property->save();
            return $property;
        }
        return null;
    }
    public function active($id,$flag)
    {
        $property = $this->model->find($id);
        if ($property) {
            $property->active = $flag;
            $property->save();
            return $property;
        }
        return null;
    }
    public function getByOwnerId($ownerId)
    {
        return $this->model->where('user_id', $ownerId)->get();
    }
}
