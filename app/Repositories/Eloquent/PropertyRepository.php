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
        return $this->model->all();
    }
    public function getById($id)
    {
        return $this->model->find($id);
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

}
