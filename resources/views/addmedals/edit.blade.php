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
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __(' Edit add medals') }}</div>
                <div class="card-body">
                    <form action="{{ route('addmedals.update', $addmedal->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                       
                        
                        <div class="mb-3">
                            <label for="">Person: </label>
                            <select name="person_id" id="person_id" class="form-control" value="{{ old('person', $person->name) }}"required>
                                @foreach ($person as $person)
                                    <option value="{{ $person->id }}">{{ $person->name }}</option>
                                @endforeach
                            </select>
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
                            <label for="">Referance No: </label>
                            <select name="referance_id" id="referance_id" class="form-control" required>
                                @foreach ($referance as $referance)
                                    <option value="{{ $referance->id }}">{{ $referance->referance }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Referance Type: </label>
                            <select name="rtype_id" id="rtype_id" class="form-control" required>
                                @foreach ($rtype as $rtype)
                                    <option value="{{ $rtype->id }}">{{ $rtype->rtype }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Date:</label>
                            <input type="date" name="date" required class="form-control"/>
                        </div>
                        
                        <div class="mb-3">
                            <label for="">File: </label>
                           <input type="file" name="file" accept="file/pdf" required>
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
     
                       
