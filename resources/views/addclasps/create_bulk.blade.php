@extends('adminlte::page')

@section('content')
    <form action="{{ route('addclasp.store_bulk') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card mt-3">
                        <div class="card card-teal">
                            <div class="card-header">
                                <i class="nav-icon fa fa-users nav-icon"></i> {{ __('Bulk Import Clasp Assignments') }}
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="">Clasp Profile:</label>
                                    <select name="clasp_profile_id" id="clasp_profile_id" class="form-control" required>
                                        @foreach ($clasp_profiles as $clasp_profile)
                                            <option value="{{ $clasp_profile->id }}"
                                                is_un="{{ $clasp_profile->medal->is_un || '' }}">
                                                {{ $clasp_profile->rtype->rtype }}-{{ $clasp_profile->reference_no }}-{{ $clasp_profile->date }}
                                                : {{ $clasp_profile->medal->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">Regiment:</label>
                                    <select name="regiment_id" id="regiment_id" class="form-control" required>
                                        @foreach ($regiments as $regiment)
                                            <option value="{{ $regiment->id }}">{{ $regiment->regiment }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">File:</label>
                                    <input type="file" id="file" name="file" class="form-control"
                                        accept=".csv, .xlsx, .xls" />
                                </div>
                                <div class="mb-3">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-4">
                                            <a href="{{ asset('excel_import/sample-clasp-import.xlsx') }}"
                                                class="btn btn-sm btn-success" download>
                                                Empty Excel File
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ asset('excel_import/allowed_rank_names.xlsx') }}"
                                                class="btn btn-sm btn-info" download>
                                                Allowed Rank Names
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ asset('excel_import/allowed_unit_names.xlsx') }}"
                                                class="btn btn-sm btn-secondary" download>
                                                Allowed Unit Names
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
