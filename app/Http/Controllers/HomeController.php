<?php

namespace App\Http\Controllers;

use App\Services\DailyRecordService;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $dailyRecordService;

    /**
     * HomeController constructor.
     * @param DailyRecordService $dailyRecordService
     */
    public function __construct(DailyRecordService $dailyRecordService)
    {
        $this->middleware('auth');
        $this->dailyRecordService = $dailyRecordService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $inputDates = [];
        $now        = time();
        $end        = time() - 60 * 60 * 24 * 7; //七天

        for ($date = $now; $date > $end; $date = $date - 60 * 60 * 24) {
            array_push($inputDates, date('Y-m-d', $date));
        }

        $date = date('Y-m-d');
        if ($request->has('date')) {
            $date = $request->input('date');
        }
        $dailyRecords = $this->dailyRecordService->getDailyRecordByDate($date);

        $binding = [
            'inputDates'   => $inputDates,
            'dailyRecords' => $dailyRecords,
            'date'         => $date
        ];

        return view('home', $binding);
    }
}
