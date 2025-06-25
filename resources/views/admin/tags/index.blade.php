@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Manage Tags & Allergens</h2>
            <a class="btn btn-primary" href="{{ route('admin.tags.create') }}">Create New Tag</a>
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
                        <th width="10%">Icon</th>
                        <th>Name (English)</th>
                        <th width="15%">Type</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td class="text-center">
                                @if($tag->icon_path)
                                    <i class="{{ $tag->icon_path }}" style="font-size: 1.5rem;"></i>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $tag->getTranslation('name', 'en') }}</td>
                            <td>
                                <span class="badge 
                                    @if($tag->type == 'general') bg-secondary 
                                    @elseif($tag->type == 'dietary') bg-info 
                                    @else bg-warning text-dark @endif">
                                    {{ ucfirst($tag->type) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST">
                                    <a class="btn btn-sm btn-info" href="{{ route('admin.tags.edit', $tag->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tag?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No tags found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $tags->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection