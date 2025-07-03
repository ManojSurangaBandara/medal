@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">

            {{-- @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif --}}
             @if (session('success'))
                <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
            @endif

             @if (session('error'))
                <div class="alert alert-danger" id="danger-alert">{{ session('error') }}</div>
            @endif

            <div class="card mt-3">
                <div class="card card-teal">
                <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __('Users') }}
                    @can('create_users')
                        <a href="{{ route('users.create') }}" class="btn btn-primary float-right">Add New User</a>
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


    <script>
        setTimeout(function () {
            let alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500); // remove from DOM after fade
            }
        }, 3000); // 3 seconds
        setTimeout(function () {
            let alert = document.getElementById('danger-alert');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500); // remove from DOM after fade
            }
        }, 3000); // 3 seconds
    </script>

@push('js')
@section('plugins.Datatables', true)
{{ $dataTable->scripts() }}
@endpush


