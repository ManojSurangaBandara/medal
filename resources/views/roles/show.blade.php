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
                <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __(' View Role') }}</div>
            <div class="card">
                <div class="card-header"><strong>{{ $role->name }}</strong>
                </div></div>
                <!-- Role Permissions -->
                <div class="form-group">
                    <label for="permissions">Permissions:</label>
                    <ul class="list-group">
                        @forelse ($role->permissions as $permission)
                            <li class="list-group-item">
                                {{ $permission->display_name }} ({{ $permission->name }})
                            </li>
                        @empty
                            <li class="list-group-item">No permissions assigned to this role.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                       
                        
                        <li class="list-group-item">
                            <strong>Created At:</strong> 
                            {{ $role->created_at ? $role->created_at->format('d-m-Y H:i') : 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Last Updated:</strong> 
                            {{ $role->updated_at ? $role->updated_at->format('d-m-Y H:i') : 'N/A' }}
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
     
                       
