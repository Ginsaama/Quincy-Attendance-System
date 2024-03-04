@extends('layouts.header')

@section('content')
    <form id="employeeForm" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="employeeSelect" class="form-label mt-5">Select Employee:</label>
            <select name="employee_id" id="employeeSelect" class="form-select">
                <option value="" selected disabled>Select your Employee</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex">
            <button type="button" id="submitForm" class="btn btn-primary mr-5">Submit</button>
            <button type="button" class="btn btn-primary ml-4" id="pdf" style="margin-left: 15px;">PDF</button>
        </div>

    </form>

    <div id="employeeDetails"></div>
    <script>
        $(document).ready(function() {
            var selectedEmployee;
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
                console.log('Clicked')
                var selectedEmployee = $('#employeeSelect').val();
                if (!selectedEmployee) {
                    alert('Please select an employee before generating the PDF.');
                    return;
                }
                var url = '/employee/pdf/' + selectedEmployee;
                window.open(url, '_blank');
            });

        });
    </script>
@endsection
