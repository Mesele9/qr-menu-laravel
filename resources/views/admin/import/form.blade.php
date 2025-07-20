@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Import Menu Items</h1>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Upload Excel/CSV File</h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.import.menu.handle') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="menu_import_file" class="form-label">Select File</label>
                <input class="form-control" type="file" name="menu_import_file" id="menu_import_file" required>
            </div>
            <button type="submit" class="btn btn-primary">Start Import</button>
        </form>

        <hr>

        <h5 class="mt-4">File Format Instructions</h5>
        <p>Your file must have a header row with the following exact column names:</p>
        <code>name, description, price, category_name, tags, is_active, is_special</code>
        <ul>
            <li><strong>name, price, category_name:</strong> are required.</li>
            <li><strong>tags:</strong> should be a comma-separated list (e.g., "Spicy, Vegan"). The system will create any tags or categories that do not already exist.</li>
            <li><strong>is_active, is_special:</strong> Use 1 for YES and 0 for NO.</li>
        </ul>
        <a href="#" class="btn btn-secondary btn-sm disabled">Download Sample Template (Coming Soon)</a>
    </div>
</div>
@endsection