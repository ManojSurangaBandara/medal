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

                <div class="card mt-3">
                    <div class="card card-teal">
                        <div class="card-header">
                            <i class="nav-icon fa fa-users nav-icon"></i> {{ __('Add Clasp Profile') }}
                        </div>
                        <div class="card-body">
                            <form action="{{ route('clasp_profiles.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="rtype_id">Reference Type:</label>
                                    <select name="rtype_id" id="rtype_id" class="form-control" required>
                                        @foreach ($rtypes as $rtype)
                                            <option value="{{ $rtype->id }}">{{ $rtype->rtype }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="reference_no">Reference No:</label>
                                    <input type="text" name="reference_no" required class="form-control" />
                                </div>

                                <div class="mb-3">
                                    <label for="date">Date:</label>
                                    <input type="date" name="date" required class="form-control" />
                                </div>

                                <div class="mb-3">
                                    <label for="file">File:</label>
                                    <input type="file" name="file" required class="form-control"
                                        accept="application/pdf" />
                                </div>

                                <div class="mb-3">
                                    <label for="medal_id">Medal:</label>
                                    <select name="medal_id" id="medal_id" class="form-control" required>
                                        @foreach ($medals as $medal)
                                            <option value="{{ $medal->id }}">{{ $medal->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('clasp_profiles.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection
