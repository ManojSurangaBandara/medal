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
                <div class="card-header"><i class="nav-icon fa fa fa-users nav-icon"></i> {{ __(' Person has multiple reference') }}</div>
                <div class="card-body">
                    <form action="{{ route('multiples.store') }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label for="">Year:</label>
                            <input type="number" name="year" required class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label for="">Issue Date: </label>
                            <input type="date" name="issue_date" required class="form-control"/>
                        </div>
                        </div>
                        <div class="mb-3">
                            <label for="">Remarks: </label>
                            <input type="text" name="remarks" required class="form-control"/>
                        </div>
                        <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label for="">Country: </label>
                            <input type="text" name="country"  class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Period of Service</label>
                            <div class="row g-3 align-items-end">
                              
                              <div class="col-md-6">
                                <label for="fromDate" class="form-label">From:</label>
                                <input type="date" name="from" id="fromDate" class="form-control" />
                              </div>
                              
                              <div class="col-md-6">
                                <label for="toDate" class="form-label">To:</label>
                                <input type="date" name="to" id="toDate" class="form-control" />
                              </div>
                            </div>
                            </div>
                          </div>
                          <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label for="">Diseases Date: </label>
                            <input type="date" name="diseases_date"  class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label for="">Location: </label>
                            <input type="name" name="location"  class="form-control"/>
                        </div>
                          </div>

                        <div class="mb-3">
                            <label for="">Description: </label>
                            <input type="name" name="description"  class="form-control"/>
                        </div>
                        <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label for="">Date of hospitalize: </label>
                            <input type="date" name="diseases_date"  class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hospitalize Duration</label>
                            <div class="row g-3 align-items-end">
                              
                              <div class="col-md-6">
                                <label for="fromDate" class="form-label">From:</label>
                                <input type="date" name="from" id="fromDate" class="form-control" />
                              </div>
                              
                              <div class="col-md-6">
                                <label for="toDate" class="form-label">To:</label>
                                <input type="date" name="to" id="toDate" class="form-control" />
                              </div>
                            </div>
                            </div>
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
     
                       

