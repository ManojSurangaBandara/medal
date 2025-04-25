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
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __(' View added medal') }}</div>
            {{-- <div class="card">
                <div class="card-header"><strong>{{ $unit->name }}</strong>
                </div>
                </div> --}}
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Person:</strong> {{ $addmedal->person->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Medal:</strong> {{ $addmedal->medal->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Reference No:</strong> {{ $addmedal->reference->reference }}
                        </li>
                        <li class="list-group-item">
                            <strong>Reference Type:</strong> {{ $addmedal->rtype->rtype }}
                        </li>
                        <li class="list-group-item">
                            <strong>Date:</strong> {{ $addmedal->date }}
                        </li>
                        <li class="list-group-item">
                            <strong>File:</strong> {{ $addmedal->file }}
                        </li>
                       
                        
                        <li class="list-group-item">
                            <strong>Created At:</strong> {{ $addmedal->created_at->format('d-m-Y H:i') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Last Updated:</strong> {{ $addmedal->updated_at->format('d-m-Y H:i') }}
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
     
                       
