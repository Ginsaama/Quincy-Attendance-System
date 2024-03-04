<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchandiser;
use App\Models\Schedule;


class MerchandiserController extends Controller
{
    // home page
    public function index()
    {
        return view('CRUD');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Fetch all merchandisers
        return view('CRUD', compact('merchandisers'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Getting access to DB table
        $request->validate([
            'call_sign' => ['required'],
            'name' => ['required'],

        ]);
        $post = new Merchandiser();
        $post->call_sign = $request->call_sign;
        $post->name = $request->name;
        $post->status = $request->status == 'on' ? 1 : 0;
        $post->save();

        // Schedule
        $schedule = new Schedule();
        $schedule->merchandisers_id = $post->id;
        $schedule->monday = $request->monday == 'ON' ? 0 : 1;
        $schedule->monday_in = $request->mondayIn;
        $schedule->monday_out = $request->mondayOut;
        $schedule->tuesday = $request->tuesday == 'ON' ? 0 : 1;
        $schedule->tuesday_in = $request->tuesdayIn;
        $schedule->tuesday_out = $request->tuesdayOut;
        $schedule->wednesday = $request->wednesday == 'ON' ? 0 : 1;
        $schedule->wednesday_in = $request->wednesdayIn;
        $schedule->wednesday_out = $request->wednesdayOut;
        $schedule->thursday = $request->thursday == 'ON' ? 0 : 1;
        $schedule->thursday_in = $request->thursdayIn;
        $schedule->thursday_out = $request->thursdayOut;
        $schedule->friday = $request->friday == 'ON' ? 0 : 1;
        $schedule->friday_in = $request->fridayIn;
        $schedule->friday_Out = $request->fridayOut;
        $schedule->saturday = $request->saturday == 'ON' ? 0 : 1;
        $schedule->saturday_in = $request->saturdayIn;
        $schedule->saturday_out = $request->saturdayOut;
        $schedule->sunday = $request->sunday == 'ON' ? 0 : 1;
        $schedule->sunday_in = $request->sundayIn;
        $schedule->sunday_out = $request->sundayOut;
        $schedule->save();

        return redirect()->route('merchandiserCRUD');
        // Get ID of schedule
    }

    public function getMerchandiserName(Request $request)
    {
        $merchandiserId = $request->input('merchandiser_id');
        $merchandiser = Merchandiser::find($merchandiserId);

        return response()->json(['merchandiser_name' => $merchandiser->name ?? '']);
    }
}
