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
                                <i class="fas fa-medal bg-blue"></i>
                                <div class="timeline-item shadow-sm">
                                    <span class="time"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($addmedal->date)->diffForHumans() }}</span>
                                    <h3 class="timeline-header">
                                        {{ $addmedal->medal->name }}
                                    </h3>

                                    <div class="timeline-body d-flex align-items-center gap-3">
                                        @if ($addmedal->medal->image)

                                                 <img src="data:image/jpeg;base64,{{ base64_encode($addmedal->medal->image) }}" alt="Medal"  width="50" />
                                        @endif
                                        <div>

                                            @if ($addmedal->file)
                                                <a href="{{ asset('storage/' . $addmedal->file) }}" target="_blank"
                                                   class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="fas fa-file-pdf"></i> Download Reference File
                                                </a>
                                            @endif
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
@endsection
