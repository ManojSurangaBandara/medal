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
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __(' View Country') }}</div>

                <div class="card-body">
                    <div class="mb-3">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Country:</strong> {{ $country->country }}
                            </li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('countries.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
@endsection


