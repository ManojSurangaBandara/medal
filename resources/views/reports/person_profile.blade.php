@extends('adminlte::page')

@section('content')
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
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card mt-3">
                    <div class="card card-teal">
                        <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __('Person Profile') }}
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reports.person_profile_show') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="">Service No:</label>
                                    <input type="text" name="service_no" required class="form-control" />
                                </div>



                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('footer') --}}
@endsection
