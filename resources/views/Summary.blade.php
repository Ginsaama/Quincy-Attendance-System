@extends('layouts.header')

@section('content')
    <div class="container mt-5">
        <form>
            <div class="form-row align-items-center">
                <div class="col-sm-3 my-1">
                    <label class="sr-only" for="from">From</label>
                    <input type="date" class="form-control" id="from" placeholder="Index from">
                </div>
                <div class="col-sm-3 my-1">
                    <label class="sr-only" for="to">To</label>
                    <input type="date" class="form-control" id="to" placeholder="Index to">
                </div>
                <div class="col-auto my-1">
                    <button type="button" class="btn btn-primary" id="filterButton">Filter</button>
                    <button type="button" class="btn btn-primary" id="pdf">PDF</button>
                </div>
            </div>
        </form>
        <div id="table_datas">
            @include('summary_pagination')
        </div>
    </div>
    </body>
    <script>
        $(document).ready(function() {
            $('#filterButton').on('click', function(event) {
                console.log('clicked')
                filter();

            });
            $('#pdf').on('click', function(event) {
                console.log('clicked')
                var from = $('#from').val();
                var to = $('#to').val();
                $.ajax({
                    url: "/summary/pdf?from=" + from + "&to=" + to,
                    success: function() {
                        var url = "/summary/pdf?from=" + from + "&to=" + to
                        window.open(url, '_blank');
                    },
                    error: function() {
                        console.log('Error generating PDF');
                    }
                });

            });


            function filter() {
                var from = $('#from').val();
                var to = $('#to').val();
                $.ajax({
                    url: "getSummary?from=" + from + "&to=" + to,
                    method: 'POST',
                    success: function(data) {
                        updateTable(data);
                        console.log('Received data:', data);
                    }
                });
            }

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
                            "<td><a href='{{ route('employee.click', '') }}/" + summary.id + "'>" +
                            summary.name + "</a></td>" +
                            "<td>" + summary.totalSchedule + "</td>" +
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
