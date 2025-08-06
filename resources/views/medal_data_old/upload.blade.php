@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <h3>Upload Old Medal Data (.xlsx)</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('medal_data_old.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control mb-3" required>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>

@endsection
