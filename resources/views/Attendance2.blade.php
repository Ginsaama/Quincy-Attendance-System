@extends('layouts.header')
<style>
    /* Add this style to your CSS or within a style tag in your HTML */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        /* semi-transparent white background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        /* adjust the z-index based on your needs */
    }

    .loading-spinner {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@section('content')
    <form method="POST" enctype="multipart/form-data" id="time">
        @csrf
        <div class="cs-form w-25 mt-5">
            <input type="date" class="form-control" name="selectedDate" id="selectedDate" value="{{ $selectedDateValue }}" />
            <button type="button" class="btn btn-primary mt-2" id="Schedules">Show Schedule</button>
            <button type="button" class="btn btn-primary mt-2" id="pdf">PDF</button>
        </div>
    </form>
    {{-- Display of day --}}
    <h1 class="mt-2">Schedule today</h1>
    <h2>{{ $day }} {{ $selectedDateValue }}</h2>


    {{-- Table --}}
    <form method="POST" enctype="multipart/form-data" id="form2">
        @csrf
        <div class="main-container mt-5">
            <table class="table table-borderless table align-middle table-responsive" id="table">
                <thead>
                    <th class="w-25">Merchandiser</th>
                    <th>Name</th>
                    <th class="w-25">Time/Memo</th>
                    <th>Remarks</th>
                </thead>
                <tbody id="table_data">

                    @if ($schedule)
                        @foreach ($schedule as $schedules)
                            <tr>
                                <td>{{ $schedules->merchandiser->call_sign }}</td>
                                <td>{{ $schedules->merchandiser->name }}</td>
                                <td>{{ $schedules->{strtolower($day) . '_in'} . ' - ' . $schedules->{strtolower($day) . '_out'} }}
                                </td>
                                <td>
                                    <div class="input-group">
                                        <select id="" class="form-control" style="width: 2rem;" name="status">
                                            <option value="" selected disabled>Select Status</option>
                                            <option value="present">Present</option>
                                            <option value="absent">Absent</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">No schedule found for the selected date.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <button type="button" class="btn btn-primary mt-2" id="button">Submit</button>

        </div>
    </form>
    <div id="loadingOverlay" class="loading-overlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>


    <script>
        function clearInputFields() {
            // Clear input fields as needed
            $('#selectedDate').val('');
            // Add more fields if needed
        }

        function showLoadingScreen() {
            // Display the loading overlay
            $('#loadingOverlay').show();
        }

        function hideLoadingScreen() {
            // Hide the loading overlay
            $('#loadingOverlay').hide();
        }
        $(document).ready(function() {
            $("#Schedules").click(function() {
                var selectedDate = $('#selectedDate').val();
                console.log(selectedDate);
                var newUrl = '/attendance/Daily/' + selectedDate;
                window.location.href = newUrl;
                console.log('New URL:', newUrl);
            });
            // PDF Stuff
            $("#pdf").click(function() {
                var selectedDate = $('#selectedDate').val();
                console.log(selectedDate);
                var url = '/attendance/Daily/report/' + selectedDate;
                window.open(url, '_blank');
            });
            // Putting it in Dailies DB
            $('#button').click(function(e) {
                e.preventDefault();

                // Display loading screen (you can customize this based on your needs)
                console.log('working')

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
                        if (response.Success) {
                            alert(response.Success)
                            $('#table_data').html("");
                        } else {
                            alert(response.Errors)
                            $('#table_data').html("");
                        }
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
            //CSRF Stuff
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endsection

{{-- Controller and Routes of PDF lang --}}
