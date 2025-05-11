@extends('adminlte::page')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card mt-3">
                    <div class="card card-teal">
                        <div class="card-header">
                            <i class="nav-icon fa fa-cogs nav-icon"></i> {{ __('View Clasp Profile') }}
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Reference Type:</strong>
                                <p>{{ $clasp_profile->rtype->rtype }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Reference No:</strong>
                                <p>{{ $clasp_profile->reference_no }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Date:</strong>
                                <p>{{ $clasp_profile->date }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>File:</strong>
                                @if ($clasp_profile->file)
                                    <p>
                                        <a href="{{ asset('storage/' . $clasp_profile->file) }}" target="_blank">View File</a>
                                    </p>
                                @else
                                    <p>No file attached</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <strong>Medal:</strong>
                                <p>{{ $clasp_profile->medal->name }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Status:</strong>
                                @switch($clasp_profile->status)
                                    @case(config('const.MEDAL_PROFILE_STATUS_PENDING_VALUE'))
                                        <span
                                            class="badge badge-warning">{{ config('const.MEDAL_PROFILE_STATUS_PENDING_NAME') }}</span>
                                    @break

                                    @case(config('const.MEDAL_PROFILE_STATUS_ACTIVE_VALUE'))
                                        <span
                                            class="badge badge-success">{{ config('const.MEDAL_PROFILE_STATUS_ACTIVE_NAME') }}</span>
                                    @break

                                    @case(config('const.MEDAL_PROFILE_STATUS_CLOSE_VALUE'))
                                        <span
                                            class="badge badge-secondary">{{ config('const.MEDAL_PROFILE_STATUS_CLOSE_NAME') }}</span>
                                    @break
                                @endswitch
                            </div>

                            <div class="mb-3">
                                <a href="{{ route('clasp_profiles.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection
