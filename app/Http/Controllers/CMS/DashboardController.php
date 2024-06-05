<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function getVisitorCount()
    {
        $visitorCount = Cache::remember('visitor_count', 60, function () {
            return DB::table('visitors')->count();
        });

        return response()->json(['count' => $visitorCount]);
    }

}
