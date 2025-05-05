@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card mt-3">
                <div class="card card-teal">
                    <div class="card-header">
                        <i class="nav-icon fa fa-cogs"></i> {{ __('Medal Details') }}
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Name:</strong>
                            <p>{{ $medal->name }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Description:</strong>
                            <p>{{ $medal->description }}</p>
                        </div>

                        <div class="mb-3">
                            <label for="">Medal Type: </label>
                            <p>{{ $medal->medal_type->medal_type }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Image:</strong><br>
                            @if($medal->image)
                                @php
                                    $base64 = base64_encode($medal->image);
                                @endphp
                                <img src="data:image/jpeg;base64, {{$base64}} " alt="Medal Image" class="img-fluid" width="100">
                            @else
                                <p>No image uploaded.</p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <strong>Is UN:</strong>
                            <p>{{ $medal->is_un ? 'Yes' : 'No' }}</p>
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('medals.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('footer')
@endsection
