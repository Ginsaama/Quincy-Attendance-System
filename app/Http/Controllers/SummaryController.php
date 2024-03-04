<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchandiser;
use TCPDF;
use Illuminate\Support\Facades\Log;


class SummaryController extends Controller
{

    public function index()
    {
        $Summary = Merchandiser::withCount([
            'dailies as totalAbsent' => function ($query) {
                $query->where('status', 'absent')
                    ->where('excused', 1)
                    ->orWhere(function ($query) {
                        $query->where('status', 'absent')
                            ->where('excused', 0);
                    })
                    ->orWhere(function ($query) {
                        $query->where('status', 'absent')
                            ->whereNotNull('offset');
                    });
            },
            'dailies as totalSchedule' => function ($query) {
                $query->selectRaw('count(*) as totalSchedule');
            },
            'dailies as totalWithExcuse' => function ($query) {
                $query->where('status', 'absent')->where('excused', 1);
            },
            'dailies as totalWithoutExcuse' => function ($query) {
                $query->where('status', 'absent')->where('excused', 0);
            },
            'dailies as totalOffset' => function ($query) {
                $query->where('status', 'absent')->whereNotNull('offset');
            },
            'dailies as totalDuty' => function ($query) {
                // Total duty is the count of all schedules regardless of absent or present
                $query->selectRaw('count(*) - sum(case when status = "absent" then 1 else 0 end) as totalDuty');
            },
        ])->get();


        return view('Summary', compact('Summary'));
        // return response()->json([
        //     'Summaries' => $Summary,
        // ]);
    }

    function filter(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('from') && $request->has('to')) {
                $fromDate = $request->get('from');
                $toDate = $request->get('to');
                $Summary = Merchandiser::withCount([
                    'dailies as totalAbsent' => function ($query) use ($fromDate, $toDate) {
                        $query->where('status', 'absent')->whereBetween('date', [$fromDate, $toDate]);
                    },
                    'dailies as totalSchedule' => function ($query) use ($fromDate, $toDate) {
                        $query->selectRaw('count(*) as totalSchedule')->whereBetween('date', [$fromDate, $toDate]);
                    },
                    'dailies as totalDuty' => function ($query) use ($fromDate, $toDate) {
                        $query->selectRaw('count(*) - sum(case when status = "absent" then 1 else 0 end) as totalDuty')->whereBetween('date', [$fromDate, $toDate]);;
                    },
                    'dailies as totalWithExcuse' => function ($query) use ($fromDate, $toDate) {
                        $query->where('status', 'absent')->where('excused', 1)->whereBetween('date', [$fromDate, $toDate]);
                    },
                    'dailies as totalWithoutExcuse' => function ($query) use ($fromDate, $toDate) {
                        $query->where('status', 'absent')->where('excused', 0)->whereBetween('date', [$fromDate, $toDate]);
                    },
                    'dailies as totalOffset' => function ($query) use ($fromDate, $toDate) {
                        $query->where('status', 'absent')->whereNotNull('offset')->whereBetween('date', [$fromDate, $toDate]);
                    },
                ])->get();
            } else {
                $Summary = Merchandiser::withCount([
                    'dailies as totalAbsent' => function ($query) {
                        $query->where('status', 'absent');
                    },
                    'dailies as totalDuty' => function ($query) {
                        $query->where('status', 'present');
                    },
                    'dailies as totalWithExcuse' => function ($query) {
                        $query->where('status', 'absent')->where('excused', 1);
                    },
                    'dailies as totalWithoutExcuse' => function ($query) {
                        $query->where('status', 'absent')->where('excused', 0);
                    },
                    'dailies as totalOffset' => function ($query) {
                        $query->where('status', 'absent')->whereNotNull('offset');
                    },
                ])->get();
            }
            // return view('Summary_pagination', compact('Summary'));
            // return dd($Summary);
            return response()->json([
                'Summaries' => $Summary,
                'from' => $fromDate,
                'to' => $toDate,
            ]);
        }
    }
    public function summaryPDF(Request $request)
    {
        // PDF Download
        if ($request->has('from') && $request->has('to')) {
            $fromDate = $request->get('from');
            $toDate = $request->get('to');
            $Summary = Merchandiser::withCount([
                'dailies as totalabsent' => function ($query) use ($fromDate, $toDate) {
                    $query->where('status', 'absent')->whereBetween('date', [$fromDate, $toDate]);
                },
                'dailies as totalSchedule' => function ($query) use ($fromDate, $toDate) {
                    $query->selectRaw('count(*) as totalSchedule')->whereBetween('date', [$fromDate, $toDate]);
                },
                'dailies as totalDuty' => function ($query) use ($fromDate, $toDate) {
                    $query->selectRaw('count(*) - sum(case when status = "absent" then 1 else 0 end) as totalDuty')->whereBetween('date', [$fromDate, $toDate]);;
                },
                'dailies as totalWithExcuse' => function ($query) use ($fromDate, $toDate) {
                    $query->where('status', 'absent')->where('excused', 1)->whereBetween('date', [$fromDate, $toDate]);
                },
                'dailies as totalWithoutExcuse' => function ($query) use ($fromDate, $toDate) {
                    $query->where('status', 'absent')->where('excused', 0)->whereBetween('date', [$fromDate, $toDate]);
                },
                'dailies as totalOffset' => function ($query) use ($fromDate, $toDate) {
                    $query->where('status', 'absent')->whereNotNull('offset')->whereBetween('date', [$fromDate, $toDate]);
                },
            ])->get();
        }
        $results = [];
        foreach ($Summary as $summaries) {
            $results[] = $summaries;
        }
        // return response()->json($results);

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

        // Set some content to print
        $html = '<h1>' . 'Summary' .   $fromDate . "   " . $toDate . '</h1>';
        $html .= '<table border="1">';
        $html .= '<tr>
                        <th>Call Sign</th>
                        <th>Full Name</th>
                        <th>T.Schedule</th>
                        <th>T.Duty</th>
                        <th>T.Absent</th>
                        <th>Absent with letter</th>
                        <th>Absent without letter</th>
                        <th>Offset</th>
                            </tr>';
        foreach ($results as $jay) {
            $scheduleCount = $jay->totalSchedule;
            $dutyCount = $jay->totalDuty;

            $html .= '<tr>
                    <td>' . $jay->call_sign . '</td>
                    <td>' . $jay->name . '</td>
                    <td>' . $scheduleCount . '</td>
                    <td>' . intval($dutyCount) . '</td>
                    <td>' . $jay->totalAbsent . '</td>
                    <td>' . $jay->totalWithExcuse . '</td>
                    <td>' . $jay->totalWithoutExcuse . '</td>
                    <td>' . $jay->totalOffset . '</td>
                    </tr>';
        }

        $html .= '</table>';


        // Print text using writeHTMLCell()
        $pdf->writeHTML($html, true, false, true, false, '');
        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output(rand() . 'Summary.pdf', 'I');
        //============================================================+
        // END OF FILE
        //============================================================+
    }








    // public function from_toDate(Request $request, $fromDate, $toDate)
    // {
    //     // $request->validate([
    //     //     'fromDate' => ['required'],
    //     //     'toDate' => ['required'],
    //     // ]);
    //     $dayto = $fromDate;
    //     $toDay = $toDate;
    //     if ($request->ajax()) {
    //         $Summary = Merchandiser::withCount([
    //             'dailies as totalAbsent' => function ($query) use ($fromDate, $toDate) {
    //                 $query->where('status', 'absent')->whereBetween('date', [$fromDate, $toDate]);
    //             }, 'dailies as totalDuty',
    //             'dailies as totalWithExcuse' => function ($query) use ($fromDate, $toDate) {
    //                 $query->where('status', 'absent')->where('excused', 1)->whereBetween('date', [$fromDate, $toDate]);
    //             },
    //             'dailies as totalWithoutExcuse' => function ($query) use ($fromDate, $toDate) {
    //                 $query->where('status', 'absent')->where('excused', 0)->whereBetween('date', [$fromDate, $toDate]);
    //             },
    //             'dailies as totalOffset' => function ($query) use ($fromDate, $toDate) {
    //                 $query->where('status', 'absent')->whereNotNull('offset')->whereBetween('date', [$fromDate, $toDate]);
    //             },
    //         ])->paginate(2);

    //         return view('Summary_pagination', compact('Summary'))->render();
    //     }

    // return response()->json([
    //     'date from' => $dayto,
    //     'date to' => $toDay,
    //     'Summaries' => $Summary,
    // ]);

    // return response()->json([
    //     'fromDate' => $request->fromDate,
    //     'toDate' => $request->toDate,
    //     'Summaries' => $Summary->items(),
    // ]);
    // }
}
