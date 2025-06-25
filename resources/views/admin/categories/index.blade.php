@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Manage Categories</h2>
            <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">Create New Category</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Name (English)</th>
                        <th width="10%">Order</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->getTranslation('name', 'en') }}</td>
                            <td>{{ $category->order ?? '0' }}</td>
                            <td>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                    <a class="btn btn-sm btn-info" href="{{ route('admin.categories.edit', $category->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $categories->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection