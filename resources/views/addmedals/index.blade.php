@extends('adminlte::page')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <style>
                    .alert {
                        animation: fadeOut 5s forwards;
                    }

                    @keyframes fadeOut {
                        0% {
                            opacity: 1;
                        }

                        90% {
                            opacity: 1;
                        }

                        100% {
                            opacity: 0;
                        }
                    }
                </style>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                {{--
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif --}}
                <div class="card mt-3">
                    <div class="card card-teal">
                        <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i>
                            {{ __('Add Person to Medal Profile') }} <a href="{{ route('addmedals.create') }}"
                                class="btn btn-primary float-right">Add Person to Medal Profile</a></div>

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

        @push('js')
            @section('plugins.Datatables', true)
            {{ $dataTable->scripts() }}
        @endpush
