@extends('adminlte::page')

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

                <div class="card card-teal">
                    <div class="card-header">
                        <i class="nav-icon fa fa-users nav-icon"></i> {{ __('Edit Medal') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('addmedals.update', $addmedal->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="">Person:</label>
                                <input type="text" class="form-control" id="person_visible" value="{{ $addmedal->person->service_no . ' ' . $addmedal->person->name }}" />
                                <input type="hidden" name="person_id" id="person_id" value="{{ $addmedal->person->id }}" />
                                <div id="searchResults" class="search-results"></div>
                            </div>

                            <div class="mb-3">
                                <label for="">Medal Profile: </label>
                                <select name="medal_profile_id" id="medal_profile_id" class="form-control" required>
                                    @foreach ($medal_profiles as $medal_profile)
                                        <option value="{{ $medal_profile->id }}" is_un="{{ $medal_profile->medal->is_un }}"
                                            @selected($addmedal->medal_profile->id == $medal_profile->id)>
                                            {{ $medal_profile->rtype->rtype }}-{{ $medal_profile->reference_no }}-{{ $medal_profile->date }}
                                            : {{ $medal_profile->medal->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="country_div">
                                <div class="mb-3">
                                    <label for="">Country: </label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="">Please Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @selected($addmedal->country_id == $country->id)>
                                                {{ $country->country }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-6">
                                            <label for="">From:</label>
                                            <input type="date" class="form-control" name="from" id="from" value="{{ $addmedal->from }}" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">To:</label>
                                            <input type="date" class="form-control" name="to" id="to" value="{{ $addmedal->to }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('footer')
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#person_visible').on('input', function () {
            let serviceNo = $(this).val().trim();
            if (serviceNo.length > 0) {
                $.ajax({
                    url: "{{ route('persons.search.ajax') }}",
                    type: 'GET',
                    data: { service_no: serviceNo },
                    success: function (data) {
                        $('#searchResults').empty();
                        if (data.length > 0) {
                            data.forEach(person => {
                                $('#searchResults').append(`
                                    <div class="search-result" style="cursor:pointer; background:#f8f9fa; border:1px solid #ced4da; padding:0.25rem 0.5rem; margin-bottom:0.25rem;"
                                        onmouseover="this.style.backgroundColor='#e2e6ea';"
                                        onmouseout="this.style.backgroundColor='#f8f9fa';">
                                        <input type="hidden" class="person_id" value="${person.id}" />
                                        <strong>${person.service_no} ${person.rank_id} ${person.name} ${person.regiment_id} (${person.eno})</strong><br>
                                    </div>
                                `);
                            });

                            $('.search-result').on('click', function () {
                                $('#person_visible').val($(this).text().trim());
                                $('#person_id').val($(this).find('.person_id').val());
                                $('#searchResults').empty();
                            });
                        } else {
                            $('#searchResults').append('<span>No results found.</span>');
                        }
                    }
                });
            } else {
                $('#searchResults').empty();
            }
        });

        $('#medal_profile_id').on('change', function () {
            const isUn = $(this).find('option:selected').attr('is_un');
            if (isUn == 1) {
                $('#country_div').show();
            } else {
                $('#country_div').hide();
                $('#country_id').prop('selectedIndex', 0);
                $('#from').val('');
                $('#to').val('');
            }
        });

        // Trigger on load
        $('#medal_profile_id').trigger('change');
    });
</script>
@endpush
