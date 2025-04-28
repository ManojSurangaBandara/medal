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
                        <i class="nav-icon fa fa-cogs nav-icon"></i> {{ __('View Medal') }}
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="">Name:</label>
                            <p class="form-control">{{ $medal->name }}</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('medals.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('footer')
@endsection
