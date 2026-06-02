<?php
namespace App\Services;

use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Traits\BaseResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportService
{
    use BaseResponse;
    protected $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function createReport(array $data)
    {
        $data['user_id'] = auth()->id();
        return $this->successResponse("Created done",$this->reportRepository->create($data));
    }

    public function getAllReports()
    {
        $all=null;
        if(auth()->user()->hasRole('admin'))
            $all=$this->reportRepository->getAll();
        else{
            $all=$this->reportRepository->getMyReport();
        }

        return $this->successResponse("Reports retrieved",$all);
    }

    public function getReportById($id)
    {
        $this->check($id);
        return $this->successResponse("Report retrieved",$this->reportRepository->getById($id));
    }

    public function updateReport($id, array $data)
    {
        $this->check($id);
        return $this->successResponse("Report updated",$this->reportRepository->update($id, $data));
    }
    public function deleteReport($id)
    {
        $this->check($id);
        return $this->successResponse("Report deleted",$this->reportRepository->delete($id));
    }
    public function check($id){
        $report = $this->reportRepository->getById($id);
        $user=auth()->user();
        if (!$report)
            throw new HttpResponseException($this->errorResponse("Report not found", 404));
        if($report->user_id != $user->id && !$user->hasRole('admin'))
            throw new HttpResponseException($this->errorResponse("Unauthorized", 403));

    }
}
