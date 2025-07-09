@extends('adminlte::page')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card mt-3">
                    <div class="card card-teal">
                        <div class="card-header">
                            <i class="nav-icon fa fa-cogs nav-icon"></i> {{ __('View Application Form') }}
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label for="">Medal:</label>
                                <p class="form-control">{{ $application_form->medal->name }}</p>
                            </div>

                            <div class="mb-3">
                                <label for="">Application Form File:</label>
                                @if ($application_form->file && Storage::disk('public')->exists($application_form->file))
                                    <a href="{{ asset('storage/' . $application_form->file) }}" class="btn btn-primary"
                                        target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                @else
                                    <p class="text-danger">File not found</p>
                                @endif
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('application_forms.index') }}" class="btn btn-secondary">Back</a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('footer')
@endsection
