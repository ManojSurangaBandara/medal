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

                <div class="card mt-3">
                    <div class="card card-teal">
                        <div class="card-header">
                            <i class="nav-icon fa fa-users nav-icon"></i> {{ __('Add Person to Clasp Profile') }}
                        </div>
                        <div class="card-body">
                            <form action="{{ route('addclasps.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="">Person Search:</label>
                                    <input type="text" class="form-control" id="person_visible"
                                        placeholder="Type to search person..." />
                                    <input type="hidden" name="person_id" id="person_id" />
                                    <div id="searchResults" class="search-results"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="">Clasp Profile:</label>
                                    <select name="clasp_profile_id" id="clasp_profile_id" class="form-control" required>
                                        @foreach ($clasp_profiles as $clasp_profile)
                                            <option value="{{ $clasp_profile->id }}"
                                                is_un="{{ $clasp_profile->medal->is_un }}">
                                                {{ $clasp_profile->rtype->rtype }}-{{ $clasp_profile->reference_no }}-{{ $clasp_profile->date }}
                                                : {{ $clasp_profile->medal->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="country_div" style="display: none;">
                                    <div class="mb-3">
                                        <label for="">Country:</label>
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
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#person_visible').on('input', function() {
                let search = $(this).val();
                if (search.length > 2) {
                    $.ajax({
                        url: "{{ route('persons.search.ajax') }}",
                        method: 'GET',
                        data: {
                            search: search
                        },
                        success: function(response) {
                            $('#searchResults').empty();
                            if (response.length > 0) {
                                response.forEach(person => {
                                    $('#searchResults').append(`
                                    <div class="search-result" style="cursor:pointer; background:#f8f9fa; border:1px solid #ced4da; padding:0.25rem 0.5rem; margin-bottom:0.25rem; font-size: 0.875rem;"
                                        onmouseover="this.style.backgroundColor='#e2e6ea';"
                                        onmouseout="this.style.backgroundColor='#f8f9fa';">
                                        <input type="hidden" class="person_id" value="${person.id}" />
                                        <strong>${person.service_no} ${person.rank_id} ${person.name} ${person.regiment_id} (${person.eno})</strong><br>
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
                        }
                    });
                } else {
                    $('#searchResults').empty();
                }
            });

            $('#clasp_profile_id').on('change', function() {
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

            $('#clasp_profile_id').trigger('change');
        });
    </script>
@endpush
