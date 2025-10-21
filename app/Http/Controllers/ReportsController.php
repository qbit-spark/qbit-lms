<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\book_issue;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function date_wise()
    {
        return view('report.dateWise', ['books' => '']);
    }

    public function generate_date_wise_report(Request $request)
    {
        $request->validate(['date' => "required|date"]);
        return view('report.dateWise', [
            'books' => book_issue::where('issue_date', $request->date)->latest()->get()
        ]);
    }

    public function month_wise()
    {
        return view('report.monthWise', ['books' => '']);
    }

    public function generate_month_wise_report(Request $request)
    {
        $request->validate(['month' => "required|date"]);
        return view('report.monthWise', [
            'books' => book_issue::where('issue_date', 'LIKE', '%' . $request->month . '%')->latest()->get(),
        ]);
    }

    public function not_returned()
    {
        return view('report.notReturned',[
            'books' => book_issue::where('issue_status','N')->latest()->get()
        ]);
    }

    public function week_wise()
    {
        return view('report.weekWise', ['books' => '']);
    }

    public function generate_week_wise_report(Request $request)
    {
        $request->validate(['week' => "required|date"]);
        
        $startOfWeek = Carbon::parse($request->week)->startOfWeek();
        $endOfWeek = Carbon::parse($request->week)->endOfWeek();

        return view('report.weekWise', [
            'books' => book_issue::whereBetween('issue_date', [$startOfWeek, $endOfWeek])
                ->latest()
                ->get(),
            'start_date' => $startOfWeek->format('Y-m-d'),
            'end_date' => $endOfWeek->format('Y-m-d')
        ]);
    }

    public function date_range()
    {
        return view('report.dateRange', ['books' => '']);
    }

    public function generate_date_range_report(Request $request)
    {
        $request->validate([
            'start_date' => "required|date",
            'end_date' => "required|date|after_or_equal:start_date"
        ]);

        return view('report.dateRange', [
            'books' => book_issue::whereBetween('issue_date', [$request->start_date, $request->end_date])
                ->latest()
                ->get(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
    }
}
