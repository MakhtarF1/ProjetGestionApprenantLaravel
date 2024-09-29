<?php

namespace App\Http\Controllers;

use App\Services\ExcelExportService;
use Illuminate\Http\Request;

class ExcelExportController extends Controller
{
    protected $excelExportService;

    public function __construct(ExcelExportService $excelExportService)
    {
        $this->excelExportService = $excelExportService;
    }

    public function export()
    {
        $filePath = $this->excelExportService->generateExcelFile();

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
