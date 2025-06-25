@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>Edit Tag</h2>
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
             <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="name_en"><strong>Name (English):</strong></label>
                            <input type="text" id="name_en" name="name[en]" value="{{ old('name.en', $tag->getTranslation('name', 'en')) }}" class="form-control" placeholder="English Name">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="type"><strong>Tag Type:</strong></label>
                        <select name="type" id="type" class="form-control">
                            <option value="general" {{ old('type', $tag->type) == 'general' ? 'selected' : '' }}>General</option>
                            <option value="dietary" {{ old('type', $tag->type) == 'dietary' ? 'selected' : '' }}>Dietary</option>
                            <option value="allergen" {{ old('type', $tag->type) == 'allergen' ? 'selected' : '' }}>Allergen</option>
                        </select>
                    </div>
                </div>

                <hr>
                <p><strong>Translations (Optional)</strong></p>

                <div class="row mt-2">
                     <div class="col-md-4 mb-3"><input type="text" name="name[am]" value="{{ old('name.am', $tag->getTranslation('name', 'am')) }}" class="form-control" placeholder="Amharic Name"></div>
                     <div class="col-md-4 mb-3"><input type="text" name="name[so]" value="{{ old('name.so', $tag->getTranslation('name', 'so')) }}" class="form-control" placeholder="Somali Name"></div>
                     <div class="col-md-4 mb-3"><input type="text" name="name[om]" value="{{ old('name.om', $tag->getTranslation('name', 'om')) }}" class="form-control" placeholder="Oromo Name"></div>
                </div>

                <hr>
                
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="icon_path"><strong>Icon Class (Optional):</strong></label>
                            <input type="text" id="icon_path" name="icon_path" class="form-control" value="{{ old('icon_path', $tag->icon_path) }}" placeholder="e.g., fas fa-pepper-hot">
                            <small class="form-text text-muted">Find classes on the <a href="https://fontawesome.com/icons" target="_blank">Font Awesome</a> website. Leave blank for no icon.</small>
                            @if($tag->icon_path)
                                <div class="mt-2">
                                    Current Icon: <i class="{{ $tag->icon_path }}" style="font-size: 1.5rem;"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection