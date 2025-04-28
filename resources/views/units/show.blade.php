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
                    <div class="card-header">
                        <i class="nav-icon fa fa-cogs nav-icon"></i> {{ __('View Unit') }}
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="">Regiment:</label>
                            <p class="form-control">{{ $unit->regiments->regiment }}</p>
                        </div>

                        <div class="mb-3">
                            <label for="">Unit:</label>
                            <p class="form-control">{{ $unit->unit }}</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('units.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('footer')
@endsection
