@extends('layouts.header')

@section('content')
    {{-- Display of day --}}
    <h1 class="mt-2">Summary</h1>
    <button type="button" class="btn btn-primary mt-2" id="pdf">PDF</button>
    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mt-3">
            <label for="fromDate" class="form-label">From Date:</label>
            <input type="date" class="form-control" value=" {{ $fromDate }}" name="fromDate" id="fromDate" />

            <label for="toDate" class="form-label">To Date:</label>
            <input type="date" class="form-control" value="{{ $toDate }}" id="toDate" name="toDate" />
        </div>
        <!-- Other form fields and buttons go here -->

        <button class="btn btn-primary mt-2" type="button" id="dateButton">STUFF</button>
    </form>
    {{-- Table --}}
    <div class="main-container mt-5">
        {{-- <p>Showing data from {{ $fromDate }} to {{ $toDate }}</p> --}}
        <table class="table table-borderless table align-middle table-responsive">
            <thead>
                <th>Call Sign</th>
                <th>Full Name</th>
                <th>T.Schedule</th>
                <th>T.Duty</th>
                <th>T.Absent</th>
                <th>Absent with letter</th>
                <th>Absent without letter</th>
                <th>Offset</th>
            </thead>
            <tbody>
                <p>Number of Summaries: {{ count($Summaries) }}</p>
                @foreach ($Summaries as $summary)
                    <tr>
                        <td>{{ $summary->call_sign }}</td>
                        <td>{{ $summary->name }}</td>
                        <td>{{ $summary->totalDuty }}</td>
                        <td>{{ $summary->totalDuty }}</td>
                        <td>{{ $summary->totalAbsent }}</td>
                        <td>{{ $summary->totalWithExcuse }}</td>
                        <td>{{ $summary->totalWithoutExcuse }}</td>
                        <td>{{ $summary->totalOffset }}</td>
                    </tr>
                @endforeach
                @if ($Summaries->isEmpty())
                    <tr>
                        <td colspan="4">No absent merchandisers found.</td>
                    </tr>
                @endif
                {{-- <td>
                                 <div class="item assign-button" id="{{ $absentMerchandiser->merchandisers_id }}"
                                     merchandiser_id="{{ $absentMerchandiser->merchandisers_id }}">
                                     <label>{{ $absentMerchandiser->call_sign }}</label>
                                 </div>
                             </td> --}}
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

            $("#pdf").click(function() {
                var url = '/summary/pdf';
                window.open(url, '_blank');
            });

            $("#dateButton").click(function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally
                console.log('button clicked');
                // Make an AJAX request
                var formData = $('form').serialize();
                console.log('Initializing Ajax');
                // $.ajax({
                //     type: "POST",
                //     url: '/summary',
                //     data: formData,
                //     dataType: "json",
                //     success: function(response) {
                //         // Update the table with the new data
                //         console.log(response);
                //     },
                //     error: function(error) {
                //         console.error("AJAX Error:", error);
                //     }
                // });
            });

            // Function to update the table with new data
            function updateTable(data) {
                $("#fromDate").val(data.fromDate);
                $("#toDate").val(data.toDate);

                // Clear existing rows in the table body
                $("tbody").empty();

                // Check if Summaries is not empty
                if (data.Summaries.length > 0) {
                    $.each(data.Summaries, function(index, summary) {
                        // Append a new row to the table body
                        $("tbody").append(
                            "<tr>" +
                            "<td>" + summary.call_sign + "</td>" +
                            "<td>" + summary.name + "</td>" +
                            "<td>" + summary.totalDuty + "</td>" +
                            "<td>" + summary.totalAbsent + "</td>" +
                            "<td>" + summary.totalWithExcuse + "</td>" +
                            "<td>" + summary.totalWithoutExcuse + "</td>" +
                            "<td>" + summary.totalOffset + "</td>" +
                            "</tr>"
                        );
                    });
                } else {
                    // If Summaries is empty, display a message
                    $("tbody").append(
                        "<tr>" +
                        "<td colspan='7'>No absent merchandisers found.</td>" +
                        "</tr>"
                    );
                }
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endsection
