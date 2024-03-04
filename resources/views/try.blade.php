{{-- @foreach ($Summary as $summaries)
    <tr>
        <td>{{ $summaries->call_sign }}</td>
        <td>{{ $summaries->name }}</td>
        <td>{{ $summaries->totalDuty }}</td>
        <td>{{ $summaries->totalDuty }}</td>
        <td>{{ $summaries->totalAbsent }}</td>
        <td>{{ $summaries->totalWithExcuse }}</td>
        <td>{{ $summaries->totalWithoutExcuse }}</td>
        <td>{{ $summaries->totalOffset }}</td>
    </tr>
@endforeach

{{ $Summary->links('pagination::bootstrap-5') }} --}}
<div class="row">
    <div class="col-lg-12">

        <table class="table table-bordered" id="laravel">
            <thead>
                <tr>
                    <th>Call Sign</th>
                    <th>Name</th>
                    <th>T.Schedule</th>
                    <th>T.Duty</th>
                    <th>T.Absent</th>
                    <th>Absent w/letter</th>
                    <th>Absent wo/letter</th>
                    <th>Offset</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($Summary) && $Summary->count())
                    @foreach ($Summary as $summaries)
                        <tr>
                            <td>{{ $summaries->call_sign }}</td>
                            <td>{{ $summaries->name }}</td>
                            <td>{{ $summaries->totalDuty }}</td>
                            <td>{{ $summaries->totalDuty }}</td>
                            <td>{{ $summaries->totalAbsent }}</td>
                            <td>{{ $summaries->totalWithExcuse }}</td>
                            <td>{{ $summaries->totalWithoutExcuse }}</td>
                            <td>{{ $summaries->totalOffset }}</td>
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
        {{ $Summary->links('pagination::bootstrap-5') }}
    </div>
</div>
