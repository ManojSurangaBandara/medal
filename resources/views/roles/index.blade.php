@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card mt-3">
                <div class="card card-teal">
                <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __('Roles') }}
                    @can('create_roles')
                        <a href="{{ route('roles.create') }}" class="btn btn-primary float-right">Add New Role</a>
                    @endcan
                </div>

                <div class="card-body">



            <div class="table-responsive">
            {{ $dataTable->table() }}
            </div>
        </div>
            </div>
        </div>
    </div>
    @include('footer')
    @endsection
    {{-- <script>
        function confirmDelete(){
            return confirm('Are You sure you want to delete this record? This action be undone.');

        }

    </script> --}}

@push('js')
@section('plugins.Datatables', true)
{{ $dataTable->scripts() }}
@endpush


