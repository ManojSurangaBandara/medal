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
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __(' View Medal Type') }}</div>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Medal Type:</strong> {{ $medal_type->medal_type }}
                        </li>

                    
                    </ul>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
@endsection


