@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @if (session('success'))
                <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
            @endif

            <div class="card mt-3">
                <div class="card card-teal">
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __('Medal Profile') }}<a href="{{ route('medal_profiles.create') }}" class="btn btn-primary float-right">Add New Medal Profile</a></div>

                <div class="card-body">

            <div class="table-responsive">
            {{ $dataTable->table() }}
            </div>
            </div>
            </div>
        </div>
    </div>

    {{-- remove the alert after 3 seconds --}}
    <script>
        setTimeout(function () {
            let alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 500); // remove from DOM after fade
            }
        }, 3000); // 3 seconds
    </script>

    @include('footer')
    @endsection

@push('js')
@section('plugins.Datatables', true)
{{ $dataTable->scripts() }}


@endpush



