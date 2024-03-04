<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Merchandiser;
use Illuminate\Http\Request;
use App\Models\Daily;
use Illuminate\Pagination\LengthAwarePaginator;
use TCPDF;

class DailyController extends Controller
{
    // Display the schedule once a date is picked
    public function display(Request $request, $selectedDate)
    {
        // $request->validate([
        //     'selectedDate' => ['required'],
        // ]);
        $selectedDateValue = $selectedDate;
        $day = date('l', strtotime($selectedDate));
        $schedule = Schedule::where($day, true)
            ->whereNotNull($day . '_in')
            ->with('merchandiser')
            ->get();
        // ->get();
        // $schedule = Schedule::paginate(2);
        // return view('pagination_data')->with(['schedule' => $schedule, 'selectedDate' => $selectedDate, 'day' => $day]);
        // return response()->json([
        //     'Schedules' => $schedule,
        // ]);
        // If Condition here
        return view('attendance2', compact('schedule', 'day', 'selectedDateValue'));
        // If it's a regular request, return the view with the paginated data
    }
    function get_ajax_data(Request $request, $selectedDate)
    {
        $selectedDateValue = $selectedDate;
        $day = date('l', strtotime($selectedDate));
        if ($request->ajax()) {
            $schedule = Schedule::where($day, true)
                ->whereNotNull($day . '_in')
                ->with('merchandiser')
                ->paginate(2);
            return view('pagination_data', compact('schedule', 'day', 'selectedDateValue'))->render();
        }
    }

    // Store datas in an array
    public function store(Request $request)
    {

        $status = $request->input('status');
        $statuses = [];
        $schedule = Schedule::all();
        $callSigns = [];
        $names = [];
        $daily = new Daily();
        $existingRecord = Daily::where('date', $request->selectedDate)->first();
        if ($existingRecord) {
            // Record already exists, you can handle this case accordingly
            return response()->json([
                'Errors' => 'A record for this date already exists.',
            ]);
        }
        foreach ($status as $index => $status) {
            // Accessing data from the $schedules array
            $callSign = $schedule[$index]->merchandiser->call_sign;
            $name = $schedule[$index]->merchandiser->name;
            $present = $status;
            $statuses[] = $present;
            $callSigns[] = $callSign;
            $names[] = $name;
            // Now you can use $callSign as needed
            // For example, you can store it in the database, log it, etc.
        }
        foreach ($statuses as $index => $present) {

            $daily = new Daily();
            $daily->merchandisers_id = $schedule[$index]->merchandiser->id;
            $daily->date = $request->selectedDate;
            $daily->status = $present;
            $daily->save();
        }
        return response()->json([
            'Success' => 'YEAH SUCCESS BABY',
            'stuff' => $daily,
        ]);
    }
    // PDF Stuff
    public function pdfdownload(Request $request, $selectedDate)
    {
        // PDF Download
        $day = date('l', strtotime($selectedDate));

        $schedule = Schedule::where($day, true)
            ->whereNotNull($day . '_in')
            ->with('merchandiser')
            ->get();

        $statuses = Daily::where('date', $selectedDate)
            ->pluck('status', 'merchandisers_id');


        // PDF Stuff
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        // set header and footer fonts

        // set default monospaced fon
        // set margins

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        // Set some content to print
        $html = '<h1>' . $day . '</h1>';
        $html .= '<table border="1">';
        $html .= '<tr>
                    <th>Merchandiser</th>
                    <th>Name</th>
                    <th>Time/Memo</th>
                    <th>Remarks</th>
                    </tr>';

        foreach ($schedule as $schedules) {
            $html .= '<tr>';
            $html .= '<td>' . $schedules->merchandiser->call_sign . '</td>';
            $html .= '<td>' . $schedules->merchandiser->name . '</td>';
            $html .= '<td>' . $schedules->{strtolower($day) . '_in'} . ' - ' . $schedules->{strtolower($day) . '_out'} . '</td>';
            if (isset($statuses[$schedules->merchandiser->id])) {
                $html .= '<td>' . $statuses[$schedules->merchandiser->id] . '</td>';
            } else {
                $html .= '<td>No status</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table>';

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+
    }

    // Storing in dailies table

}
