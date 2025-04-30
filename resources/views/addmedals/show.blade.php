@extends('adminlte::page')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card card-teal">
                    <div class="card-header">
                        <i class="nav-icon fa fa-medal"></i> {{ __('Medal Details') }}
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Person</th>
                                    <td>{{ $addmedal->person->service_no ?? '' }} - {{ $addmedal->person->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Medal Profile</th>
                                    <td>
                                        {{ $addmedal->medal_profile->rtype->rtype ?? '' }}-{{ $addmedal->medal_profile->reference_no ?? '' }}-{{ $addmedal->medal_profile->date ?? '' }}
                                        :
                                        {{ $addmedal->medal_profile->medal->name ?? '' }}
                                    </td>
                                </tr>
                                @if ($addmedal->medal_profile->medal->is_un ?? false)
                                    <tr>
                                        <th>Country</th>
                                        <td>{{ $addmedal->country->country ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>From</th>
                                        <td>{{ $addmedal->from ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>To</th>
                                        <td>{{ $addmedal->to ?? '-' }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <a href="{{ route('addmedals.index') }}" class="btn btn-secondary mt-3">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
