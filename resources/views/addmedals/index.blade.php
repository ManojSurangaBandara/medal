@extends('adminlte::page')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
{{-- 
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif --}}
            <div class="card mt-3">
                <div class="card card-teal">
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __('Addmedal') }}</div>
                
                <div class="card-body">
                    <a href="{{ route('addmedals.create') }}" class="btn btn-primary float-end">Add New medal</a>
                    
                    {{-- <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $unit)
                            <tr>
                                <td>{{ $unit->id }}</td>
                                <td>{{ $unit->name }}</td>
                            <td>
                                    <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit User" ><i class="fa fa-pen"></i></a>
                                    <form action="{{ route('units.destroy', $unit->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"   class="btn btn-xs btn-danger" data-toggle="tooltip"  title="Delete User" ><i class="fa fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('units.show', $unit->id) }}" class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit User" ><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>  --}}
            <div class="table-responsive">
            {{ $dataTable->table() }}
  

            </div>
            </div>
            </div>
        </div>
    </div>
    @include('footer')
    @endsection
    {{-- <script>
        function confirmDelete(){
            return confirm('Are You sure you want to delete this record? This action be undone.');

        }

    </script> --}}
    @push('js')
    @section('plugins.Datatables', true)
    {{ $dataTable->scripts() }}
    @endpush
    



