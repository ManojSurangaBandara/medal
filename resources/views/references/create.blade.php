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
                <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __(' Add Reference') }}</div>
                <div class="card-body">
                    <form action="{{ route('references.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Reference:</label>
                            <input type="text" name="reference" required class="form-control" id="reference"/>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
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

