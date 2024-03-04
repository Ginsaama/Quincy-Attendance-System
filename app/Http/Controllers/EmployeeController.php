<?php

namespace App\Http\Controllers;

use App\Models\Daily;
use App\Models\Merchandiser;
use TCPDF;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $employees = Merchandiser::all();
        return view('Employees', compact('employees'));
    }
    public function show($id)
    {
        $employee = Merchandiser::findOrFail($id);
        $attendanceRecords = Daily::where('merchandisers_id', $id)->orderBy('date', 'asc')->get();

        return view('Employee', compact('employee', 'attendanceRecords'));
    }
    public function show2($id)
    {
        $employee = Merchandiser::findOrFail($id);
        $attendanceRecords = Daily::where('merchandisers_id', $id)->orderBy('date', 'asc')->get();

        return view('Employee_data', compact('employee', 'attendanceRecords'));
    }
    public function pdfEmployee($id)
    {
        // PDF Download
        $employee = Merchandiser::findOrFail($id);
        $attendanceRecords = Daily::where('merchandisers_id', $id)->orderBy('date', 'asc')->get();

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
        $html = '<h1>' . $employee->name . ' (' . $employee->call_sign . ')</h1>';
        $html .= '<table border="1">';
        $html .= '<tr>
                            <th>Date</th>
                            <th>Status</th>
                                </tr>';
        foreach ($attendanceRecords as $record) {
            $html .= '<tr>';
            $html .= '<td>' . \Carbon\Carbon::parse($record->date)->format('F j, Y') . '</td>';
            $html .= '<td>' . $record->status . '</td>';
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
}
