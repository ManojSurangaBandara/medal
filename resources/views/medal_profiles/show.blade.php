@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="card mt-3">
                <div class="card card-teal">
                    <div class="card-header"><i class="nav-icon fa fa-eye"></i> {{ __('View Medal Profile') }}</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Reference Type:</strong>
                            <p>{{ $medal_profile->rtype->rtype ?? '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Reference No:</strong>
                            <p>{{ $medal_profile->reference_no }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Date:</strong>
                            <p>{{ $medal_profile->date }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>File:</strong>
                            @if($medal_profile->file)
                                <p><a href="{{ asset('storage/'.$medal_profile->file) }}" target="_blank">View File</a></p>
                            @else
                                <p>-</p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <strong>Status:</strong><br>
                            @php
                                $status = $medal_profile->status;
                                $badgeClass = match ($status) {
                                    config('const.MEDAL_PROFILE_STATUS_PENDING_VALUE') => 'badge-warning',
                                    config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE') => 'badge-success',
                                    config('const.MEDAL_PROFILE_STATUS_CLOSE_VALUE') => 'badge-danger',
                                    default => 'badge-secondary',
                                };
                                $statusText = match ($status) {
                                    config('const.MEDAL_PROFILE_STATUS_PENDING_VALUE') => config('const.MEDAL_PROFILE_STATUS_PENDING_NAME'),
                                    config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE') => config('const.MEDAL_PROFILE_STATUS_ACTIVE_NAME'),
                                    config('const.MEDAL_PROFILE_STATUS_CLOSE_VALUE') => config('const.MEDAL_PROFILE_STATUS_CLOSE_NAME'),
                                    default => 'Unknown',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                        </div>


                        <div class="mb-3">
                            <strong>Medal:</strong>
                            <p>{{ $medal_profile->medal->name }}</p>
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('medal_profiles.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('footer')
@endsection
