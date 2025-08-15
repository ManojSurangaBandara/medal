@extends('adminlte::page')

@section('content')
<div class="container">
    <h2>Medal Data - Old</h2>

    <div class="d-flex justify-content-end mb-2">
        <form action="{{ route('medal_data_old.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all data?');">
            @csrf
            <button type="submit" class="btn btn-danger">Clear Data</button>
        </form>
    </div>

    @php
        // Map attribute keys to custom column names
        $customColumns = [
            'id' => 'Id',
            'service_no' => 'Service No',
            'rank' => 'Rank',
            'name' => 'Name',
            'regiment' => 'Regiment',
            'medal' => 'Medal',
            'reference_string' => 'Reference',
        ];

        // Remove last 2 columns if needed
        // $customColumns = array_slice($customColumns, 0, -2);
    @endphp

    <table id="medalDataOldTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                @foreach($customColumns as $label)
                    <th>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($medalDataOld as $row)
                <tr>
                    @foreach(array_keys($customColumns) as $key)
                        <td>{{ $row->$key }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $medalDataOld->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#medalDataOldTable').DataTable({
        "pageLength": 10
    });
});
</script>
@endpush
