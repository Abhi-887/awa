@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Category</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Category</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.taxonomy.update', $taxonomy->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $taxonomy->name }}">
                    </div>

                    <div class="form-group">
                        <label for="parent">Parent</label>
                        <select name="parent" class="form-control" id="parent">
                            <option value="" selected>Select Parent Category</option>
                            @foreach ($parentCategories as $cat)
                                <option value="{{ $cat->id }}" @if ($cat->id == $taxonomy->parent) selected @endif>
                                    {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($taxonomy->status === 1) value="1">Active</option>
                            <option @selected($taxonomy->status === 0) value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
