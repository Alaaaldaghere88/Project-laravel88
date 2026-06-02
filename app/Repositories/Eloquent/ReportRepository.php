<?php
namespace App\Repositories\Eloquent;
use App\Models\Report;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use Override;

class ReportRepository implements ReportRepositoryInterface
{
    protected $model;

    public function __construct(Report $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function update($id, array $data)
    {
        $report = $this->getById($id);
        $report->update($data);
        return $report;
    }

    public function delete($id)
    {
        $report = $this->getById($id);
        return $report->delete();
    }
    #[Override]
    public function getMyReport()
    {
        return auth()->user()->reports;
    }
}
