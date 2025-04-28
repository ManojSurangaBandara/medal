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
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Country:</strong> {{ $country->country }}
                        </li>
                        
                        <li class="list-group-item">
                            <strong>Created At:</strong> {{  $country->created_at ? $country->created_at->format('d-m-Y H:i') : 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Last Updated:</strong> {{ $country->updated_at ? $country->updated_at->format('d-m-Y H:i') : 'N/A' }}
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
     
                       
