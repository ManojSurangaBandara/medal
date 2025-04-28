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
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __(' Edit Country') }}</div>
                <div class="card-body">
                    <form action="{{ route('countries.update', $country->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="">Country:</label>
                            <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $country->name) }}" required>

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

     
                       
