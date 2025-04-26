@extends('adminlte::page')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card mt-3">
                <div class="card card-teal">
                <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __(' Edit Person') }}</div>
                <div class="card-body">
                    <form action="{{ route('persons.update', $person->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="">Service No:</label>
                            <input type="text" name="service_no" required class="form-control" id="service_no" value="{{$person->service_no}}"/>
                        </div>
                        <div class="mb-3">
                            <label for="">E No:</label>
                            <input type="text" name="eno" required class="form-control" id="eno" value="{{$person->eno}}"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Rank:</label>
                            <select name="rank_id" id="rank_id" class="form-control" required>
                                @foreach ($ranks as $rank)
                                    <option value="{{ $rank->id }}" @if($rank->id == $person->rank->id) selected @endif>{{ $rank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Name:</label>
                            <input type="text" name="name" required class="form-control" id="name" value="{{$person->name}}"/>
                        </div>
                        <div class="mb-3">
                        <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label for="">Regiment: </label>
                            <select name="regiment_id" id="regiment_id" class="form-control" required>
                                @foreach ($regiments as $regiment)
                                    <option value="{{ $regiment->id }}" @if($regiment->id == $person->regiment->id) selected @endif>{{ $regiment->regiment }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Unit: </label>
                            <select name="unit_id" id="unit_id" class="form-control" required>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}" @if($unit->id == $person->unit->id) selected @endif>{{ $unit->unit }}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- <div class="mb-3">
                            <label for="">Data of enlishment: </label>
                            <input type="date" name="date_of_enlishment" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Data of commision: </label>
                            <input type="date" name="date_of_commision" required class="form-control"/>
                        </div> --}}

                    </div>
                </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
@endsection

{{-- @yield('third_party_scripts') --}}

{{-- @section('third_party_scripts') --}}
<script>
    $(document).ready(function () {
        // $('#service_no').on('change', function() {
        //     alert($('#service_no').val());
        // });


        $('#service_no').on('change', function() {

                var svcNo = $('#service_no').val();

                if(svcNo)
                {
                    // Make an AJAX request to fetch details from the API
                    $.ajax({
                        url: 'https://eportal1.army.lk/eportal/api/serach_person_by_no',
                        method: 'POST',
                        data: {
                            service_no: svcNo,
                            api_key: '44616e6a4030323231',
                        },
                        success: function(data) {
                            // Check if the response has a person and relevant information
                            if (data.person && data.person.length > 0) {
                                var person = data.person[0];

                                // Extract the required fields
                                var eno = person.eno || '';
                                var rank = person.rank || '';
                                var name = person.name_with_initial || '';
                                var regiment = person.regiment || '';
                                var unit = person.unit || '';

                                // console.log('Name' + name)

                                // Set the values in your form fields
                                $('#eno').val(eno);
                                $('#rank_id option').filter(function() {
                                    return $(this).text().trim() === rank;
                                }).prop('selected', true).change();

                                // $('#rank_id').val(rank).change(); // If using a dropdown, change the selected option
                                $('#name').val(name);
                                // $('#regiment').val(regiment);
                                $('#regiment_id option').filter(function() {
                                    return $(this).text().trim() === regiment;
                                }).prop('selected', true).change();
                                // $('#unit').val(unit);
                                $('#unit_id option').filter(function() {
                                    return $(this).text().trim() === unit;
                                }).prop('selected', true).change();
                            } else {
                                 alert('Service No not found');
                            }
                        },
                        error: function(error) {
                            alert('Invalid API response');
                        }
                    });
                }
            });
    });
</script>
{{-- @endsection --}}

