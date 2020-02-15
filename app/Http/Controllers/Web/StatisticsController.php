<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use DB;
use Illuminate\Http\Request;

class StatisticsController extends WebController
{


    /**
     *  get list of all orders in the app as statistics
     *
     * @param Request $request
     * @return void
     */
    public function orders(Request $request)
    {
        $year = $request['year'] ?? now()->format('Y');
        $month = $request['month'] ?? now()->format('m');

        $graphDate = DB::table('orders')
            ->where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"), $year)
            ->where(DB::raw("(DATE_FORMAT(created_at,'%m'))"), $month)
            ->select(DB::raw("(DATE_FORMAT(created_at,'%d')) as day_id"), DB::raw("CONCAT(DATE_FORMAT(created_at,'%a'),'(',DATE_FORMAT(created_at,'%d'),')') as day"), DB::raw('COUNT(*) as count'))
            ->orderBy('day_id')
            ->groupBy('day_id')
            ->get();

        $labels = $graphDate->pluck('day');
        $data = $graphDate->pluck('count');

        return response()->json(['status' => true, 'labels' => $labels, 'data' => $data]);
    }
}
