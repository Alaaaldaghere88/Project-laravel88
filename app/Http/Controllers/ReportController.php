<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }
    public function create(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        return $this->reportService->createReport($data);
    }
    public function index()
    {
        return $this->reportService->getAllReports();
    }
    public function show($id){
        return $this->reportService->getReportById($id);
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
        ]);
        return $this->reportService->updateReport($id, $data);
    }
    public function destroy($id){
        return $this->reportService->deleteReport($id);
    }
}
