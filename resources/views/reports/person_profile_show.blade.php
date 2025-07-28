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
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i> {{ __('Person Profile') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5><strong>Service No:</strong> {{ $person->service_no }}</h5>
                            <h5><strong>Rank:</strong> {{ $person->rank->name }}</h5>
                            <h5><strong>Name:</strong> {{ $person->name }}</h5>
                            <h5><strong>Regiment:</strong> {{ $person->regiment->regiment }}</h5>
                        </div>

                        <hr>

                        <h4 class="text-teal mb-3"><i class="fas fa-medal"></i> Awarded Medals</h4>

                        <div class="timeline">
                            @foreach ($person_addmedals as $addmedal)
                                <div class="time-label">
                                    <span class="bg-teal">
                                        {{ \Carbon\Carbon::parse($addmedal->date)->format('d M Y') }}
                                    </span>
                                </div>

                                <div>
                                    <i class="fas fa-medal bg-blue" data-toggle="tooltip" title="Medal: {{ $addmedal->medal_profile->rtype->rtype }}-{{ $addmedal->medal_profile->reference_no }}-{{ $addmedal->medal_profile->date }}"></i>
                                    <div class="timeline-item shadow-sm">

                                        @php
                                            switch ($addmedal->medal->is_un) {
                                                case 0:
                                                    $badgeClass = 'badge-danger';
                                                    $spanContent = 'Not UN';
                                                    break;
                                                case 1:
                                                    $badgeClass = 'badge-warning';
                                                    $spanContent = 'UN';
                                                    break;
                                                default:
                                                    $badgeClass = 'badge-danger';
                                                    $spanContent = 'Not UN';
                                            }
                                        @endphp

                                        <h3 class="timeline-header">
                                            {{ $addmedal->medal->name }}
                                            @if ($addmedal->clasps && $addmedal->clasps->where('person_id', $person->id)->count() > 0)
                                                @foreach ($addmedal->clasps->where('person_id', $person->id) as $clasp)
                                                    <a href="{{ asset('storage/' . $clasp->clasp_profile->file) }}"
                                                        target="_blank" style="text-decoration: none;">
                                                        <i class="fas fa-star text-warning ml-1" data-toggle="tooltip"
                                                            title="Clasp: {{ $clasp->clasp_profile->rtype->rtype }}-{{ $clasp->clasp_profile->reference_no }}-{{ $clasp->clasp_profile->date }}"></i>
                                                    </a>
                                                @endforeach
                                            @endif
                                            <span class="badge badge-secondary float-right ml-2">
                                                {{ $addmedal->medal->medal_type->medal_type }}
                                            </span>
                                            <span class="badge {{ $badgeClass }} float-right">
                                                {{ $spanContent }}
                                            </span>
                                        </h3>

                                        <div class="timeline-body d-flex align-items-center justify-content-between">
                                            <div>
                                                @if ($addmedal->medal->image)
                                                    <img src="data:image/jpeg;base64,{{ base64_encode($addmedal->medal->image) }}"
                                                        alt="Medal" width="50" />
                                                @endif
                                                @if ($addmedal->file)
                                                    <a href="{{ asset('storage/' . $addmedal->file) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-file-pdf"></i> Download Reference File
                                                    </a>
                                                @endif
                                            </div>
                                            <div>
                                                @can('create_addclasp')
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-toggle="modal" data-target="#addClaspModal"
                                                        data-medal-id="{{ $addmedal->medal_id }}"
                                                        data-person-id="{{ $person->id }}">
                                                        <i class="fas fa-plus"></i> Add Clasp
                                                    </button>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Add Clasp Modal -->
    <div class="modal fade" id="addClaspModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Clasp</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="addClaspForm" onsubmit="return false;">
                        <div class="form-group">
                            <label for="clasp_profile_id">Select Clasp Profile</label>
                            <select class="form-control" id="clasp_profile_id" name="clasp_profile_id" required>
                                <option value="">Select a clasp profile</option>
                                @foreach ($clasp_profiles as $clasp_profile)
                                    <option value="{{ $clasp_profile->id }}"
                                        data-is-un="{{ $clasp_profile->medal->is_un }}"
                                        data-medal-id="{{ $clasp_profile->medal_id }}">
                                        {{ $clasp_profile->rtype->rtype }}-{{ $clasp_profile->reference_no }}-{{ $clasp_profile->date }}
                                        : {{ $clasp_profile->medal->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="modal_medal_id" name="medal_id">
                        <input type="hidden" id="modal_person_id" name="person_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitClaspBtn">Add Clasp</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Initialize tooltips
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $('#addClaspModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var medalId = button.data('medal-id');
            var personId = button.data('person-id');

            $('#modal_medal_id').val(medalId);
            $('#modal_person_id').val(personId);

            // Filter clasp profile options based on medal ID
            $('#clasp_profile_id option').each(function() {
                if ($(this).val()) { // Skip the placeholder option
                    if ($(this).data('medal-id') == medalId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                }
            });

            // Reset selection
            $('#clasp_profile_id').val('');
        });

        $('#submitClaspBtn').on('click', function() {
            submitClaspForm();

        });

        function submitClaspForm() {
            $.ajax({
                url: "{{ route('addclasp.store_ajax') }}",
                method: 'POST',
                data: $('#addClaspForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        var medalId = $('#modal_medal_id').val();
                        var personId = $('#modal_person_id').val();
                        var addClaspBtn = $('button[data-medal-id="' + medalId + '"][data-person-id="' +
                            personId + '"]');
                        var medalHeader = addClaspBtn.closest('.timeline-item').find('.timeline-header');
                        var medalName = medalHeader.contents().first();
                        var selectedClasp = $('#clasp_profile_id option:selected');
                        var claspText = selectedClasp.text();

                        // Add new star with clasp details and correct file path
                        medalName.after(
                            ' <a href="{{ asset('storage') }}/' + response.clasp_file +
                            '" target="_blank" style="text-decoration: none;">' +
                            '<i class="fas fa-star text-warning ml-1" data-toggle="tooltip" title="Clasp: ' +
                            claspText + '"></i></a>'
                        );

                        // Initialize tooltip for new star
                        $('[data-toggle="tooltip"]').tooltip();

                        $('#addClaspModal').modal('hide');
                        alert('Clasp profile assigned successfully');
                    } else {
                        alert(response.message || 'Error assigning clasp profile');
                    }
                },
                error: function(xhr) {
                    alert('Error assigning clasp profile. Please try again.');
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
