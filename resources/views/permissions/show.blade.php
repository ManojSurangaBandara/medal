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
                <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __(' View Permission') }}</div>
            <div class="card">
                <div class="card-header"><strong>{{ $permission->name }}</strong>
                </div></div>
               
                        <li class="list-group-item">
                            <strong>Created At:</strong> 
                            {{ $permission->created_at ? $permission->created_at->format('d-m-Y H:i') : 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Last Updated:</strong> 
                            {{ $permission->updated_at ? $permission->updated_at->format('d-m-Y H:i') : 'N/A' }}
                        </li>
                        
                        
                        {{-- <li class="list-group-item">
                            <strong>Created At:</strong> {{ $user->created_at->format('d-m-Y H:i') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Last Updated:</strong> {{ $user->updated_at->format('d-m-Y H:i') }}
                        </li> --}}
                    </ul>
                       
                </div>
            </div>
        </div>
    </div>
   </div>
   @include('footer')
   @endsection
     
                       
