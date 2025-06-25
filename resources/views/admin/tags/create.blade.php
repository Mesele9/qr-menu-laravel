@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>Add New Tag</h2>
            <a class="btn btn-secondary mb-3" href="{{ route('admin.tags.index') }}"> Back</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="name_en"><strong>Name (English):</strong></label>
                            <input type="text" id="name_en" name="name[en]" value="{{ old('name.en') }}" class="form-control" placeholder="English Name">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="type"><strong>Tag Type:</strong></label>
                        <select name="type" id="type" class="form-control">
                            <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                            <option value="dietary" {{ old('type') == 'dietary' ? 'selected' : '' }}>Dietary</option>
                            <option value="allergen" {{ old('type') == 'allergen' ? 'selected' : '' }}>Allergen</option>
                        </select>
                    </div>
                </div>

                <hr>
                <p><strong>Translations (Optional)</strong></p>

                <div class="row mt-2">
                     <div class="col-md-4 mb-3"><input type="text" name="name[am]" value="{{ old('name.am') }}" class="form-control" placeholder="Amharic Name"></div>
                     <div class="col-md-4 mb-3"><input type="text" name="name[so]" value="{{ old('name.so') }}" class="form-control" placeholder="Somali Name"></div>
                     <div class="col-md-4 mb-3"><input type="text" name="name[om]" value="{{ old('name.om') }}" class="form-control" placeholder="Oromo Name"></div>
                </div>

                <hr>
                
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="icon_path"><strong>Icon Class (Optional):</strong></label>
                            <input type="text" id="icon_path" name="icon_path" class="form-control" value="{{ old('icon_path') }}" placeholder="e.g., fas fa-leaf">
                            <small class="form-text text-muted">Find classes on the <a href="https://fontawesome.com/icons" target="_blank">Font Awesome</a> website. Example: for a leaf, enter "fas fa-leaf".</small>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection