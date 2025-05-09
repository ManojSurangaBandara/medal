@extends('adminlte::page')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@section('content')

    <form action="{{ route('addmedal.store_bulk') }}" method="POST" enctype="multipart/form-data">
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

                    @if (session('status'))
                        <div class="alert alert-success" id="success-alert">{{ session('status') }}</div>
                    @endif
                    <div class="card mt-3">
                        <div class="card card-teal">
                            <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i>
                                {{ __(' Import From Excel') }}
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="">Medal Profile: </label>
                                    <select name="medal_profile_id" id="medal_profile_id" class="form-control" required>
                                        @foreach ($medal_profiles as $medal_profile)
                                            <option value="{{ $medal_profile->id }}"
                                                is_un="{{ $medal_profile->medal->is_un || '' }}">
                                                {{ $medal_profile->rtype->rtype }}-{{ $medal_profile->reference_no }}-{{ $medal_profile->date }}
                                                : {{ $medal_profile->medal->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">Regiment: </label>
                                    <select name="regiment_id" id="regiment_id" class="form-control" required>
                                        @foreach ($regiments as $regiment)
                                            <option value="{{ $regiment->id }}">{{ $regiment->regiment }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">File: </label>
                                    <input type="file" id="file" name="file" class="form-control"
                                        accept=".csv, .xlsx, .xls" />
                                </div>
                                <div class="mb-3">
                                    <div class="row g-3 align-items-end">

                                        <div class="col-md-4">
                                            <a href="{{ asset('excel_import/sample-medal-import.xlsx') }}"
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

    </form>

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
