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
                <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __(' Add Person') }}</div>
                <div class="card-body">
                    <form action="{{ route('persons.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="">Service No:</label>
                            <input type="text" name="service_no" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">E No:</label>
                            <input type="text" name="service_no" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Rank: </label>
                            <select name="rank_id" id="rank_id" class="form-control" required>
                                @foreach ($rank as $rank)
                                    <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Regiment: </label>
                            <select name="regiment_id" id="regiment_id" class="form-control" required>
                                @foreach ($regiment as $regiment)
                                    <option value="{{ $regiment->id }}">{{ $regiment->regiment }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Unit: </label>
                            <select name="unit_id" id="unit_id" class="form-control" required>
                                @foreach ($unit as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                @endforeach
                            </select>
                        </div>
                     
                        <div class="mb-3">
                            <label for="">Name:</label>
                            <input type="text" name="name" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Data of enlishment: </label>
                            <input type="date" name="date_of_enlishment" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Data of commision: </label>
                            <input type="date" name="date_of_commision" required class="form-control"/>
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
     
                       

