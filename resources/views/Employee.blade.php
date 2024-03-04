<h1>Employee Details</h1>

<h2>Name: {{ $employee->name }} ({{ $employee->call_sign }})</h2>
<h2>Status: {{ $employee->status == 1 ? 'Active' : 'Inactive' }}</h2>
<h3>Attendance Records:</h3>
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
