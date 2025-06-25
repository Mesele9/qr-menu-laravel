@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add New Menu Item</h2>
        <a class="btn btn-secondary" href="{{ route('admin.menu-items.index') }}"> Back</a>
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

    <form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Main Details -->
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="name_en"><strong>Name (English):</strong></label>
                            <input type="text" name="name[en]" class="form-control" value="{{ old('name.en') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="description_en"><strong>Description (English):</strong></label>
                            <textarea class="form-control" style="height:150px" name="description[en]">{{ old('description.en') }}</textarea>
                        </div>

                        <hr>
                        <p><strong>Translations (Optional)</strong></p>
                        <div class="row">
                            <div class="col-md-4"><label>Amharic</label><input type="text" name="name[am]" class="form-control mb-2" value="{{ old('name.am') }}" placeholder="Name"></div>
                            <div class="col-md-4"><label>Somali</label><input type="text" name="name[so]" class="form-control mb-2" value="{{ old('name.so') }}" placeholder="Name"></div>
                            <div class="col-md-4"><label>Oromo</label><input type="text" name="name[om]" class="form-control mb-2" value="{{ old('name.om') }}" placeholder="Name"></div>
                        </div>
                        <div class="row">
                             <div class="col-md-4"><textarea class="form-control" name="description[am]" placeholder="Description">{{ old('description.am') }}</textarea></div>
                             <div class="col-md-4"><textarea class="form-control" name="description[so]" placeholder="Description">{{ old('description.so') }}</textarea></div>
                             <div class="col-md-4"><textarea class="form-control" name="description[om]" placeholder="Description">{{ old('description.om') }}</textarea></div>
                        </div>
                    </div>

                    <!-- Sidebar Details -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="price"><strong>Price:</strong></label>
                            <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="category_id"><strong>Category:</strong></label>
                            <select name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->getTranslation('name', 'en') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image"><strong>Image:</strong></label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Is Active?</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_special" id="is_special" value="1" {{ old('is_special') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_special">Feature as Chef's Special?</label>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Tags Section -->
                <div class="row">
                    <div class="col-md-12">
                        <h4>Tags & Allergens</h4>
                        @foreach($tags as $type => $tagGroup)
                            <div class="mb-3">
                                <h5>{{ ucfirst($type) }}</h5>
                                <div class="d-flex flex-wrap">
                                    @foreach($tagGroup as $tag)
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                                                {{ (is_array(old('tags')) && in_array($tag->id, old('tags'))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                                {{ $tag->getTranslation('name', 'en') }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection