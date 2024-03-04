@extends('layouts.header')

@section('content')
    {{-- Display of day --}}
    <h1 class="mt-2">Absent Module</h1>

    {{-- Table --}}
    <form action="{{ route('Absent.update') }}" method="POST" enctype="multipart/form-data" id="form2">
        @csrf
        <div class="main-container mt-5">
            <table class="table table-borderless table align-middle table-responsive">
                <thead>
                    <th class="w-25">Merchandiser</th>
                    <th>Name</th>
                    <th class="w-25">Date</th>
                    <th>Remarks</th>
                </thead>
                <tbody>
                    @foreach ($absents as $absentMerchandiser)
                        <tr>
                            <td>{{ $absentMerchandiser->call_sign }}
                                <input type="hidden" name="merchandisers_id[]"
                                    value="{{ $absentMerchandiser->merchandisers_id }}">
                            </td>
                            <td>{{ $absentMerchandiser->name }}</td>
                            <td><span class="date-column"> {{ $absentMerchandiser->date }}
                                </span>
                                <input type="hidden" name="schedule_dates[]" value="{{ $absentMerchandiser->date }}">
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control remarks" name="absent-offset[]"
                                        style="width: 25rem;" list="input" id="Input">
                                    <datalist id="input">
                                        <option value="With Excuse">
                                        <option value="Without Excuse">
                                        <option value="Offset">
                                    </datalist>
                                    <input type="date" class="form-control date-input"
                                        style="width: 25rem; display: none;" id="">
                                </div>
                            </td>
                            {{-- <td>
                                <div class="item assign-button" id="{{ $absentMerchandiser->merchandisers_id }}"
                                    merchandiser_id="{{ $absentMerchandiser->merchandisers_id }}">
                                    <label>{{ $absentMerchandiser->call_sign }}</label>
                                </div>
                            </td> --}}
                        </tr>
                    @endforeach
                    @if ($absents->isEmpty())
                        <tr>
                            <td colspan="4">No absent merchandisers found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary mt-2" id="button">Submit</button>
        </div>
    </form>
    <div id="loadingOverlay" class="loading-overlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>


    <script>
        $(document).ready(function() {
            // Assuming you have included the jQuery library
            $('.date-column').each(function() {
                var dateString = $(this).text();
                var formattedDate = new Date(dateString).toLocaleDateString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                });
                $(this).text(formattedDate);
            });

            $('.remarks').on('input', function() {
                // Get the selected option value
                var selectedOption = $(this).val();

                // Toggle the visibility of the date input based on the selected option
                var dateInput = $(this).closest('.input-group').find('.date-input');
                if (selectedOption === 'Offset') {
                    dateInput.show();
                    $('.date-input').on('change', function() {
                        // Get the selected date value
                        var selectedDate = $(this).val();
                        // Update the corresponding text input value in the input-group
                        $(this).closest('.input-group').find('.remarks').val(selectedOption +
                            " at " + selectedDate);
                        dateInput.hide();
                    });
                } else {
                    dateInput.hide();
                }
            });
            // Use this in case I dont want to use form in Laravel
            // $(".assign-button").click(function(e) {
            //     var $id = $(this).attr("id");
            //     var $merchandiser_id = $(this).attr("merchandiser_id");
            //     console.log($merchandiser_id);
            // });
        });
    </script>
@endsection
