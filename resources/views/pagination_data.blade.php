@extends('layouts.header')

@section('content')
    {{-- Display of day --}}
    <form method="POST" enctype="multipart/form-data" id="time">
        @csrf
        <div class="cs-form w-25 mt-5">
            <input type="date" class="form-control" name="selectedDate" id="selectedDate" value="{{ $selectedDateValue }}" />
            <button type="button" class="btn btn-primary mt-2" id="Schedule">Show Schedule</button>
            <button type="button" class="btn btn-primary mt-2" id="pdf">PDF</button>
        </div>
    </form>
    <h1 class="mt-2">Schedule today</h1>
    <h2></h2>
    <div class="main-container mt-5">
        <h1>{{ $day }}</h1>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered" id="scheduleTable">
                    <thead>
                        <tr>
                            <th>Merchandiser</th>
                            <th>Name</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Remarks</th>

                            <!-- Add other columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($schedule) && $schedule->count())
                            @foreach ($schedule as $schedules)
                                <tr>
                                    <td>{{ $schedules->merchandiser->call_sign }}</td>
                                    <td>{{ $schedules->merchandiser->name }}</td>
                                    <td>{{ $schedules->monday_in }}</td>
                                    <td>{{ $schedules->monday_out }}</td>
                                    <td>{{ $schedules->monday_out }}</td>
                                    <td> <select name="category_id" id="" class="form-control">
                                            <option> Present</option>
                                            <option> Absent</option>
                                        </select></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">No data found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{ $schedule->links('pagination::bootstrap-5') }}
                <button type="submit" class="btn btn-primary mt-2" id="button">Submit</button>

            </div>

        </div>

    </div>
    <script>
        $(document).ready(function() {
            $("#Schedule").click(function() {
                var selectedDate = $('#selectedDate').val();
                console.log(selectedDate);
                // If the URL contains the selectedDate, clear the URL
                window.location.href = "";
                var newUrl = "/attendance/Daily/" + selectedDate;
                window.location.href = newUrl;
                $('#selectedDate').val(selectedDate);
            });

            $("#pdf").click(function() {
                var selectedDate = $('#selectedDate').val();
                console.log(selectedDate);
                var url = '/attendance/Daily/report/' + selectedDate;
                window.open(url, '_blank');
            });

        });
        $('#button').click(function(e) {
            e.preventDefault();

            // Display loading screen (you can customize this based on your needs)
            showLoadingScreen();

            // Serialize form data into an array
            var formData = $('#form2').serializeArray();

            // Get the selected date from the time form and append it
            var selectedDate = $('#selectedDate').val();
            formData.push({
                name: 'selectedDate',
                value: selectedDate
            });

            // Convert the form data array to a serialized string
            var serializedData = $.param(formData);

            $.ajax({
                type: 'POST',
                url: '/attendance/Daily/submit-form',
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    // Handle success response (if needed)
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Log the complete response for debugging
                    console.error(error);
                },
                complete: function() {
                    // Hide loading screen and clear input fields
                    clearInputFields();
                }
            });

        });
    </script>
@endsection
