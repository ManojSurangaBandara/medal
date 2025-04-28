@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card mt-3">
                <div class="card card-teal">
                    <div class="card-header">
                        <i class="nav-icon fa fa-users nav-icon"></i> {{ __('View Person') }}
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label>Service No:</label>
                            <p class="form-control">{{ $person->service_no }}</p>
                        </div>

                        <div class="mb-3">
                            <label>E No:</label>
                            <p class="form-control">{{ $person->eno }}</p>
                        </div>

                        <div class="mb-3">
                            <label>Rank:</label>
                            <p class="form-control">{{ $person->rank->name ?? '' }}</p>
                        </div>

                        <div class="mb-3">
                            <label>Name:</label>
                            <p class="form-control">{{ $person->name }}</p>
                        </div>

                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label>Regiment:</label>
                                <p class="form-control">{{ $person->regiment->regiment ?? '' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Unit:</label>
                                <p class="form-control">{{ $person->unit->unit ?? '' }}</p>
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label>Date of Enlistment:</label>
                            <p class="form-control">{{ $person->doe }}</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('persons.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
@endsection
