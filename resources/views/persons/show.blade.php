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
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __(' View Person') }}</div>
            
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Service No:</strong> {{ $person->service_no }}
                        </li>
                        <li class="list-group-item">
                            <strong>E No:</strong> {{ $person->eno }}
                        </li>
                        <li class="list-group-item">
                            <strong>Rank:</strong> {{ $unit->rank->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Name:</strong> {{ $person->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Regiment:</strong> {{ $person->regiment->regiment }}
                        </li>
                        <li class="list-group-item">
                            <strong>Unit:</strong> {{ $person->unit->unit }}
                        </li>
                        <li class="list-group-item">
                            <strong>Created At:</strong> {{ $person->created_at->format('d-m-Y H:i') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Last Updated:</strong> {{ $person->updated_at->format('d-m-Y H:i') }}
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
     
                       
