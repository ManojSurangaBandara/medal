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
                <div class="card-header"><i class="nav-icon fa fa fa-cogs nav-icon"></i> {{ __(' Add Medal') }}</div>
                <div class="card-body">
                    <form action="{{ route('medals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="">Name:</label>
                            <input type="text" name="name" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Description:</label>
                            <input type="text" name="description" required class="form-control"/>
                        </div>

                        <div class="mb-3">
                            <label for="">Medal Type: </label>
                            <select name="medal_type_id" id="medal_type_id" class="form-control" required>
                                @foreach ($medal_types as $medal_type)
                                    <option value="{{ $medal_type->id }}">{{ $medal_type->medal_type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control" id="image" name="image" />
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div> --}}


                            <!-- UN Checkbox -->
                            <div class="form-group form-check">
                                <input type="hidden" name="is_un" value="0"> <!-- Ensure 0 is sent if unchecked -->
                                <input type="checkbox" class="form-check-input" id="is_un" name="is_un" value="1" {{ old('is_un') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_un">Is UN?</label>
                            </div>
                        {{-- <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_un" name="is_un" checked>
                            <label class="form-check-label" for="is_un">Is UN?</label>
                        </div> --}}

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


