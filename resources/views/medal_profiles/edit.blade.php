@extends('adminlte::page')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                    <div class="card-header"><i class="nav-icon fa fa-users nav-icon"></i> {{ __('Edit Medal Profile') }}</div>
                    <div class="card-body">
                        <form action="{{ route('medal_profiles.update', $medal_profile->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="">Reference Type: </label>
                                <select name="rtype_id" id="rtype_id" class="form-control" required>
                                    @foreach ($rtypes as $rtype)
                                        <option value="{{ $rtype->id }}" {{ $medal_profile->rtype_id == $rtype->id ? 'selected' : '' }}>{{ $rtype->rtype }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="reference_no">Reference No:</label>
                                <input type="text" name="reference_no" required class="form-control" id="reference_no" value="{{ old('reference_no', $medal_profile->reference_no) }}"/>
                            </div>

                            <div class="mb-3">
                                <label for="date">Date:</label>
                                <input type="date" name="date" required class="form-control" id="date" value="{{ old('date', $medal_profile->date) }}"/>
                            </div>

                            <div class="mb-3">
                                <label for="">File (Upload again if you want to change): </label>
                                <input type="file" name="file" accept="application/pdf">
                                @if($medal_profile->file)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/'.$medal_profile->file) }}" target="_blank">View Existing File</a>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="">Medal: </label>
                                <select name="medal_id" id="medal_id" class="form-control" required>
                                    @foreach ($medals as $medal)
                                        <option value="{{ $medal->id }}" {{ $medal_profile->medal_id == $medal->id ? 'selected' : '' }}>{{ $medal->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('medal_profiles.index') }}" class="btn btn-secondary">Cancel</a>
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
