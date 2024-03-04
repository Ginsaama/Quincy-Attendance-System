@extends('layouts.header')

@section('content')
    <div class="main-container mt-5">
        <div class="d-flex">
            {{-- First Half --}}
            <div class="w-50">
                <h1>CRUD</h1>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif
                <form action="{{ route('merchandiser.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mt-3">
                        <label for="" class="form-label">Call Sign</label>
                        <div class="input-group">
                            <select name="category_id" id="merchandiserSelect" class="form-control" style="width: 2rem;">
                                @foreach ($merchandisers as $merchandiser)
                                    <option value="{{ $merchandiser->id }}">{{ $merchandiser->call_sign }}</option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control" name="call_sign" id=""style="width: 25rem;">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <div></div>
                        <div class="input-group">
                            <input type="text" class="form-control remarks" name="absent-offset[]" style="width: 25rem;"
                                list="input" id="Input">
                            <datalist id="merchandiserOptions">
                                <option value=""></option>
                            </datalist>
                        </div>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" name="status" type="checkbox" role="switch"
                            id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Active</label>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn mt-2 text-white"
                            style=" background-color:#185289;">Submit</button>
                    </div>
            </div>
            {{-- Second Half --}}
            <div class="ms-5">
                <table class="table table-borderless table align-middle table-responsive">
                    <colgroup>
                        <col style="width: 10%;">
                        <col style="width: 10rem;">
                        <col style="width: 10rem;">
                    </colgroup>
                    <thead>
                        <th></th>
                        <th>Time in</th>
                        <th>Time out</th>
                    </thead>
                    <tbody>
                        {{-- Monday --}}
                        <tr>
                            <th scope="row">
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        name="monday">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Monday
                                    </label>
                                </div>
                            </th>
                            <td class="">
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="mondayIn" />
                                </div>
                            </td>
                            <td>
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="mondayOut" />
                                </div>
                            </td>
                        </tr>
                        {{-- Tuesday --}}
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        name="tuesday">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Tuesday
                                    </label>
                                </div>
                            </th>
                            <td class="">
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="tuesdayIn" />
                                </div>
                            </td>
                            <td>
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="tuesdayOut" />
                                </div>
                            </td>
                        </tr>
                        {{-- Wednesday --}}
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        name="wednesday">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Wednesday
                                    </label>
                                </div>
                            </th>
                            <td class="">
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="wednesdayIn" />
                                </div>
                            </td>
                            <td>
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="wednesdayOut" />
                                </div>
                            </td>
                        </tr>
                        {{-- Thursday --}}
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        name="thursday">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Thursday
                                    </label>
                                </div>
                            </th>
                            <td class="">
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="thursdayIn" />
                                </div>
                            </td>
                            <td>
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="thursdayOut" />
                                </div>
                            </td>
                        </tr>
                        {{-- Friday --}}
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        name="friday">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Friday
                                    </label>
                                </div>
                            </th>
                            <td class="">
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="fridayIn" />
                                </div>
                            </td>
                            <td>
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="fridayOut" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            {{-- saturday --}}
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        name="saturday">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Saturday
                                    </label>
                                </div>
                            </th>
                            <td class="">
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="saturdayIn" />
                                </div>
                            </td>
                            <td>
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="saturdayOut" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            {{-- Sunday --}}
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                        name="sunday">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Sunday
                                    </label>
                                </div>
                            </th>
                            <td class="">
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="sundayIn" />
                                </div>
                            </td>
                            <td>
                                <div class="cs-form">
                                    <input type="time" class="form-control" value="" name="sundayOut" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#merchandiserSelect').change(function() {
                var merchandiserId = $(this).val();

                // Make an AJAX request
                $.ajax({
                    url: '/get-merchandiser-name',
                    type: 'GET',
                    data: {
                        merchandiser_id: merchandiserId
                    },
                    success: function(response) {
                        $('#merchandiserOptions').empty();

                        // Add the new option
                        if (response.merchandiser_name !== '') {
                            $('#merchandiserOptions').append('<option value="' + response
                                .merchandiser_name + '">');
                        }
                    },
                    error: function() {
                        console.log('Error in AJAX request');
                    }
                });
            });

            // Listen for the change event on the select element
            $('select[name="category_id"]').change(function() {
                // Get the selected option's text
                var selectedCallSign = $('select[name="category_id"] option:selected').text();

                // Set the input field value to the selected option's text
                $('input[name="call_sign"]').val(selectedCallSign);
            });
        });
    </script>
@endsection
