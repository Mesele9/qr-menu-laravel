@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Manage Menu Items</h2>
            <a class="btn btn-primary" href="{{ route('admin.menu-items.create') }}">Create New Item</a>
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
                        <th width="10%">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th width="8%">Status</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menuItems as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                @if($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" width="100">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $item->getTranslation('name', 'en') }}</td>
                            <td>{{ $item->category->getTranslation('name', 'en') }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST">
                                    <a class="btn btn-sm btn-info" href="{{ route('admin.menu-items.edit', $item->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No menu items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $menuItems->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection