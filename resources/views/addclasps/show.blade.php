@extends('adminlte::page')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card card-teal">
                    <div class="card-header">
                        <i class="nav-icon fa fa-medal"></i> {{ __('Clasp Assignment Details') }}
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Person</th>
                                    <td>{{ $addclasp->person->service_no ?? '' }} - {{ $addclasp->person->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Clasp Profile</th>
                                    <td>
                                        {{ $addclasp->clasp_profile->rtype->rtype ?? '' }}-{{ $addclasp->clasp_profile->reference_no ?? '' }}-{{ $addclasp->clasp_profile->date ?? '' }}
                                        :
                                        {{ $addclasp->clasp_profile->medal->name ?? '' }}
                                    </td>
                                </tr>
                                @if ($addclasp->clasp_profile->medal->is_un ?? false)
                                    <tr>
                                        <th>Country</th>
                                        <td>{{ $addclasp->country->country ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>From</th>
                                        <td>{{ $addclasp->from ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>To</th>
                                        <td>{{ $addclasp->to ?? '-' }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <a href="{{ route('addclasps.index') }}" class="btn btn-secondary mt-3">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
