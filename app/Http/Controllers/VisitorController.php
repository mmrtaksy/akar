<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use ConsoleTVs\Charts\Facades\Charts;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::selectRaw('COUNT(*) as visits, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chart = Charts::create('line', 'highcharts')
            ->title('Visitor Statistics')
            ->labels($visitors->pluck('date'))
            ->values($visitors->pluck('visits'))
            ->dimensions(1000, 500)
            ->responsive(true);

        return view('xadmin.pages.visitors.index', compact('chart'));
    }
}