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
                <div class="card">
                    <div class="card card-teal">
                        <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __(' Add Medal') }}</div>
                        <div class="card-body">
                            <form action="{{ route('addmedals.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="">Person:</label>
                                    <input type="text" class="form-control" id="person_visible"
                                        placeholder="Type to Search" />
                                    <input type="hidden" name="person_id" id="person_id" />
                                    <div id="searchResults" class="search-results"></div>

                                </div>

                                <div class="mb-3">
                                    <label for="">Medal Profile: </label>
                                    <select name="medal_profile_id" id="medal_profile_id" class="form-control" required>
                                        @foreach ($medal_profiles as $medal_profile)
                                            <option value="{{ $medal_profile->id }}"
                                                is_un="{{ $medal_profile->medal->is_un || '' }}">
                                                {{ $medal_profile->rtype->rtype }}-{{ $medal_profile->reference_no }}-{{ $medal_profile->date }}
                                                : {{ $medal_profile->medal->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="country_div">
                                    <div class="mb-3">69
                                        <label for="">Country: </label>
                                        <select name="country_id" id="country_id" class="form-control">
                                            <option value="">Please Select</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-6">
                                                <label for="">From:</label>
                                                <input type="date" class="form-control" name="from" id="from" />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="">To:</label>
                                                <input type="date" class="form-control" name="to" id="to" />
                                            </div>
                                        </div>
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

<script>
    $(document).ready(function() {


        // Array to store selected service numbers
        let selectedServiceNos = [];

        $('#person').val('');

        // Attach event listener to the search input
        $('#person_visible').on('input', function() {
            let serviceNo = $(this).val();
            // Check if the input is not empty
            if (serviceNo.length > 0 && serviceNo.trim() !== '') {

                $.ajax({
                    url: "{{ route('persons.search.ajax') }}",
                    type: 'GET',
                    data: {
                        service_no: serviceNo
                    },
                    success: function(data) {

                        // Clear previous results
                        $('#searchResults').empty();

                        // Check if data is available
                        if (data.length > 0) {
                            // Create result list with checkboxes
                            data.forEach(person => {
                                $('#searchResults').append(`
                                    <div class="search-result" style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.25rem 0.5rem; margin-bottom: 0.25rem; cursor: pointer; font-size: 0.875rem;"
                                            onmouseover="this.style.backgroundColor='#e2e6ea';"
                                            onmouseout="this.style.backgroundColor='#f8f9fa';">
                                            <input type="hidden" class="person_id" value="${person.id}" />
                                        <strong>${person.service_no} ${person.rank.name} ${person.name} ${person.regiment.regiment} (${person.eno})</strong><br>
                                    </div>
                                `);
                            });

                            $('.search-result').on('click', function() {
                                $('#person_visible').val($(this).text().trim());
                                $('#person_id').val($(this).find('.person_id')
                                    .val());
                                $('#searchResults').empty();
                            });

                        } else {
                            $('#searchResults').append('<span>No results found.</span>');
                        }
                    },
                    error: function(xhr) {
                        $('#searchResults').empty();
                        $('#searchResults').append(
                            '<span>Error fetching data. Please try again.</span>');
                    }
                });
            } else {
                // Clear results if the input is empty
                $('#searchResults').empty();
            }
        });

        // show/hide country div when page loads

        // Attach event listener to the medal profile dropdown
        $('#medal_profile_id').on('change', function() {

            if ($(this).find('option:selected').attr('is_un') == 1) {
                $('#country_div').show();
            } else {
                $('#country_div').hide();
                $('#country_id').prop('selectedIndex', 0);
                $('#from').val('');
                $('#to').val('');
            }
        });
        $('#medal_profile_id').trigger('change');

    });
</script>
