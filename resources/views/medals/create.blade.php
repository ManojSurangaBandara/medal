@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card mt-3">
                <div class="card card-teal">
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __(' Add Medal') }}</div>
                <div class="card-body">
                    <form action="{{ route('medals.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Name:</label>
                            <input type="text" name="name" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Description:</label>
                            <input type="text" name="description" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_un" name="is_un" checked>
                            <label class="form-check-label" for="is_un">Is UN?</label>
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
     
                       
