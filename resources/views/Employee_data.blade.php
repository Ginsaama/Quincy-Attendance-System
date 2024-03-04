@extends('layouts.header')

@section('content')
    <a href="javascript:void(0);" id="backButton" class="btn btn-secondary mt-2">
        <i class="bi bi-arrow-left"></i> Back
    </a>
    <div id="employeeDetails">

        <h1>Employee Details</h1>
        <h2>Name: {{ $employee->name }} ({{ $employee->call_sign }}) ({{ $employee->id }})</h2>
        <h2>Status</h2>
        <h3>Attendance Records:</h3>
        <button type="button" class="btn btn-primary ml-5" id="pdf">PDF</button>

        @if ($attendanceRecords->isNotEmpty())
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendanceRecords as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->date)->format('F j, Y') }}</td>
                                <td>{{ $record->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No attendance records found.</p>
        @endif
    </div>

    </div>
    <script>
        $(document).ready(function() {
            // AJAX request when the form is submitted
            $('#submitForm').click(function() {
                var selectedEmployee = $('#employeeSelect').val();
                $.ajax({
                    type: 'GET',
                    url: '/employee/' + selectedEmployee,
                    success: function(data) {
                        $('#employeeDetails').html(data);
                    },
                    error: function(error) {
                        console.error('Error fetching employee details:', error);
                    }
                });
            });
            // PDF Stuff
            $("#pdf").click(function() {
                console.log('Clicked');
                var id = {{ $employee->id }};
                if (!id) {
                    alert('Please select an employee before generating the PDF.');
                    return;
                }
                var url = '/employee/pdf/' + id;
                window.open(url, '_blank');
            });
            $("#backButton").click(function() {
                window.history.back();
            });

        });
    </script>
@endsection
