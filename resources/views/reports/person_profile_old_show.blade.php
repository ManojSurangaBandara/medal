@extends('adminlte::page')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card card-teal shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i> {{ __('Person Profile') }}
                        </h3>

                    </div>
                    <div class="d-flex justify-content-end">
                        <form action="{{ route('reports.person_profile_show') }}" method="POST" class="mr-2 mt-2">
                            @csrf
                            <input type="hidden" name="service_no" value="{{ $person->service_no }}">
                            <button type="submit" class="btn-sm btn-primary">
                                <i class="fas fa-database"></i> New Data
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5><strong>Service No:</strong> {{ $person->service_no }}</h5>
                            <h5><strong>Rank:</strong> {{ $person->rank ? $person->rank->name : '' }}</h5>
                            <h5><strong>Name:</strong> {{ $person->name }}</h5>
                            <h5><strong>Regiment:</strong> {{ $person->regiment ? $person->regiment->regiment : '' }}</h5>
                        </div>

                        <hr>

                        <h4 class="text-teal mb-3"><i class="fas fa-medal"></i> Awarded Medals</h4>

                        @php
                            // Map attribute keys to custom column names
                            $customColumns = [
                                'rank' => 'Rank',
                                'medal' => 'Medal',
                                'reference_string' => 'Reference',
                            ];

                        @endphp

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    @foreach ($customColumns as $label)
                                        <th>{{ $label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medalDataOld as $row)
                                    <tr>
                                        @foreach (array_keys($customColumns) as $key)
                                            <td>
                                                @if ($key === 'reference_string' && false)
                                                    <a href="{{ asset('storage/medal_reference_files_old/' . $row->reference_string) }}"
                                                        target="_blank" class="btn btn-sm btn-link">
                                                        <i class="fas fa-download"></i> {{ $row->reference_string }}
                                                    </a>
                                                @else
                                                    {{ $row->$key }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>
        // Initialize tooltips
        // $(document).ready(function() {
        //     $('[data-toggle="tooltip"]').tooltip();
        // });

        // $('#addClaspModal').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget);
        //     var medalId = button.data('medal-id');
        //     var personId = button.data('person-id');

        //     $('#modal_medal_id').val(medalId);
        //     $('#modal_person_id').val(personId);

        //     // Filter clasp profile options based on medal ID
        //     $('#clasp_profile_id option').each(function() {
        //         if ($(this).val()) { // Skip the placeholder option
        //             if ($(this).data('medal-id') == medalId) {
        //                 $(this).show();
        //             } else {
        //                 $(this).hide();
        //             }
        //         }
        //     });

        //     // Reset selection
        //     $('#clasp_profile_id').val('');
        // });

        // $('#submitClaspBtn').on('click', function() {
        //     submitClaspForm();

        // });

        // function submitClaspForm() {
        //     $.ajax({
        //         url: "{{ route('addclasp.store_ajax') }}",
        //         method: 'POST',
        //         data: $('#addClaspForm').serialize(),
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             if (response.success) {
        //                 var medalId = $('#modal_medal_id').val();
        //                 var personId = $('#modal_person_id').val();
        //                 var addClaspBtn = $('button[data-medal-id="' + medalId + '"][data-person-id="' +
        //                     personId + '"]');
        //                 var medalHeader = addClaspBtn.closest('.timeline-item').find('.timeline-header');
        //                 var medalName = medalHeader.contents().first();
        //                 var selectedClasp = $('#clasp_profile_id option:selected');
        //                 var claspText = selectedClasp.text();

        //                 // Add new star with clasp details and correct file path
        //                 medalName.after(
        //                     ' <a href="{{ asset('storage') }}/' + response.clasp_file +
        //                     '" target="_blank" style="text-decoration: none;">' +
        //                     '<i class="fas fa-star text-warning ml-1" data-toggle="tooltip" title="Clasp: ' +
        //                     claspText + '"></i></a>'
        //                 );

        //                 // Initialize tooltip for new star
        //                 $('[data-toggle="tooltip"]').tooltip();

        //                 $('#addClaspModal').modal('hide');
        //                 alert('Clasp profile assigned successfully');
        //             } else {
        //                 alert(response.message || 'Error assigning clasp profile');
        //             }
        //         },
        //         error: function(xhr) {
        //             alert('Error assigning clasp profile. Please try again.');
        //             console.log(xhr.responseText);
        //         }
        //     });
        // }
    </script>
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
