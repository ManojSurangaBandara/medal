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
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __(' Edit add medals') }}</div>
                <div class="card-body">
                    <form action="{{ route('addmedals.update', $addmedal->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                       
                        
                        <div class="mb-3">
                            <label for="">Person: </label>
                            <select name="person_id" id="person_id" class="form-control" required>
                                @foreach ($person as $person)
                                    <option value="{{ $person->id }}" @if($person->id == $addmedal->person->id) selected @endif>{{ $person->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Medal: </label>
                            <select name="medal_id" id="medal_id" class="form-control" required>
                                @foreach ($medal as $medal)
                                    <option value="{{ $medal->id }}" @if($medal->id == $addmedal->medal->id) selected @endif>{{ $medal->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Reference No: </label>
                            <select name="reference_id" id="reference_id" class="form-control" required>
                                @foreach ($reference as $reference)
                                    <option value="{{ $reference->id }}" @if($reference->id == $addmedal->reference->id) selected @endif>{{ $reference->reference }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Reference Type: </label>
                            <select name="rtype_id" id="rtype_id" class="form-control" required>
                                @foreach ($rtype as $rtype)
                                    <option value="{{ $rtype->id }}" @if($rtype->id == $addmedal->rtype->id) selected @endif>{{ $rtype->rtype }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Date:</label>
                            <input type="date" name="date" required class="form-control"id="date" value="{{$addmedal->date}}"/>
                        </div>
                        
                        <div class="mb-3">
                            <label for="">File: </label>
                           <input type="file" name="file" accept="application/pdf" class="form-control" id="file" value="{{$addmedal->file}}"required>
                        </div>
                      
                      
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
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
     
                       
