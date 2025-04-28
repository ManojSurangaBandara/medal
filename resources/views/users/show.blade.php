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
                    <div class="card-header"><i class="nav-icon fa fa-users nav-icon"></i> {{ __('View User') }}</div>

                    <div class="card">
                        <div class="card-header">
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </div>

                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Service No:</strong> {{ $user->service_no }}
                            </li>
                            <li class="list-group-item">
                                <strong>Rank:</strong> {{ $user->ranks->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Name:</strong> {{ $user->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Email:</strong> {{ $user->email }}
                            </li>
                            <li class="list-group-item">
                                <strong>Regiment:</strong> {{ $user->regiments->regiment }}
                            </li>
                            <li class="list-group-item">
                                <strong>Unit:</strong> {{ $user->units->unit }}
                            </li>
                            <li class="list-group-item">
                                <strong>Role:</strong> {{ $user->role->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Active:</strong> {{ $user->active ? 'Yes' : 'No' }}
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
