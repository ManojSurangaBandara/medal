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
                        <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __(' Edit Person') }}
                        </div>
                        <div class="card-body">
                            <form action="{{ route('persons.update', $person->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="">Service No:</label>
                                    <input type="text" name="service_no" required class="form-control" id="service_no"
                                        value="{{ $person->service_no }}" disabled/>
                                </div>
                                <input type="hidden" name="service_no" id="service_no" value="{{ $person->service_no }}" />
                                <div class="mb-3">
                                    <label for="">E No:</label>
                                    <input type="text" name="eno" class="form-control" id="eno"
                                        value="{{ $person->eno }}" />
                                </div>
                                <div class="mb-3">
                                    <label for="">Rank:</label>
                                    <select name="rank_id" id="rank_id" class="form-control" required>
                                        <option value=""></option>
                                        @foreach ($ranks as $rank)
                                            @php
                                                if($person->rank){
                                                    $selected = $rank->id == $person->rank->id ? 'selected' : '';
                                                } else {
                                                    $selected = '';
                                                }
                                            @endphp
                                            <option value="{{ $rank->id }}" {{ $selected }}>
                                                {{ $rank->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">Name:</label>
                                    <input type="text" name="name" required class="form-control" id="name"
                                        value="{{ $person->name }}" />
                                </div>
                                <div class="mb-3">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-6">
                                            <label for="">Regiment: </label>
                                            <select name="regiment_id" id="regiment_id" class="form-control" required>
                                                <option value=""></option>

                                                @foreach ($regiments as $regiment)
                                                @php
                                                if($person->regiment){
                                                    $selected = $regiment->id == $person->regiment->id ? 'selected' : '';
                                                } else {
                                                    $selected = '';
                                                }
                                                @endphp
                                                    <option value="{{ $regiment->id }}" {{ $selected }} >
                                                        {{ $regiment->regiment }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Unit: </label>
                                            <select name="unit_id" id="unit_id" class="form-control" required>
                                                <option value=""></option>
                                                @foreach ($units as $unit)
                                                    @php
                                                    if($person->unit){
                                                        $selected = $unit->id == $person->unit->id ? 'selected' : '';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    @endphp
                                                    <option value="{{ $unit->id }}" {{ $selected }}>
                                                        {{ $unit->unit }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        {{-- <div class="mb-3">
                            <label for="">Data of enlishment: </label>
                            <input type="date" name="date_of_enlishment" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Data of commision: </label>
                            <input type="date" name="date_of_commision" required class="form-control"/>
                        </div> --}}

                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="">Date of Enlistment:</label>
                                    <input type="date" name="doe" required class="form-control"
                                        id="doe" value="{{$person->doe}}"/>
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


