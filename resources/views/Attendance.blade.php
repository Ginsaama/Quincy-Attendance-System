@extends('layouts.header')

@section('content')
    <div class="cs-form w-25 mt-5">
        <input type="date" class="form-control" value="" name="selectedDate" id="selectedDate" />
        <button type="submit" class="btn btn-primary mt-2" id="Schedule">Show Schedule</button>
    </div>
    {{-- Display of day --}}
    <h1>Schedule today</h1>

    {{-- Table --}}
    <div class="main-container mt-5">
        <table class="table table-borderless table align-middle table-responsive">
            <colgroup>
                <col style="width: 35%;">
                <col style="width: 35%;">
                <col style="width: 35%;">
            </colgroup>
            <thead>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $("#Schedule").click(function() {
                var selectedDate = $('#selectedDate').val();
                console.log(selectedDate);
                var newUrl = '/attendance/Daily/' + selectedDate;
                window.location.href = newUrl;
            });
        });
    </script>
@endsection
