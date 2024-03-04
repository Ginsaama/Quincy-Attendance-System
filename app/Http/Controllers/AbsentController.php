<?php

namespace App\Http\Controllers;

use App\Models\Daily;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Merchandiser;
use Illuminate\Support\Facades\DB;

class AbsentController extends Controller
{
    //
    public function index()
    {
        $absents = DB::table('dailies')
            ->join('merchandisers', 'dailies.merchandisers_id', '=', 'merchandisers.id')
            ->where('dailies.status', 'absent')
            ->whereNull('dailies.excused')
            ->whereNull('dailies.offset')
            ->select('merchandisers.id as merchandisers_id', 'merchandisers.name', 'dailies.date', 'merchandisers.call_sign')
            ->distinct()
            ->orderBy('date', 'asc')
            ->get();
        return view('absent', compact('absents'));
    }

    public function update(Request $request)
    {
        $dates = [];
        $resultData = [];
        // $try = $request->input('schedule_dates');
        foreach ($request->input('merchandisers_id') as $key => $merchandiserId) {
            $selectedOption = $request->input('absent-offset')[$key];
            $data = [
                'excused' => $request->input('absent-offset')[$key] === 'With Excuse' ? 1 : 0,
                'offset' => stripos($selectedOption, 'Offset') !== false ? $selectedOption : null,
                'date' => ($request->input('schedule_dates')[$key])
            ];
            $resultData[] = Daily::updateOrCreate([
                'merchandisers_id' => $merchandiserId,
                'date' => $data['date']
            ], $data);
            // $dates[] =  $key;
        }
        return redirect('/absent');
    }
}
