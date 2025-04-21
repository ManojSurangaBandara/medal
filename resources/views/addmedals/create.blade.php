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
            <div class="card">
                <div class="card card-teal">
                <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __(' Add Medal') }}</div>
                <div class="card-body">
                    <form action="{{ route('addmedals.store') }}" method="POST">
                        @csrf
                       
                        <div class="mb-3">
                            <label for="">Referance Type: </label>
                            <select name="rtype_id" id="rtype_id" class="form-control" required>
                                @foreach ($rtype as $rtype)
                                    <option value="{{ $rtype->id }}">{{ $rtype->rtype }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Referance No:</label>
                            <input type="text" name="referance_no" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">File: </label>
                           <input type="file" name="file" accept="file/pdf" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Medal: </label>
                            <select name="medal_id" id="medal_id" class="form-control" required>
                                @foreach ($medal as $medal)
                                    <option value="{{ $medal->id }}">{{ $medal->name }}</option>
                                @endforeach
                            </select>
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
     
                       

