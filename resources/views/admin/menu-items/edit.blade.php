@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Menu Item</h2>
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

    <form action="{{ route('admin.menu-items.update', $menuItem->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Main Details -->
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label><strong>Name (English):</strong></label>
                            <input type="text" name="name[en]" class="form-control" value="{{ old('name.en', $menuItem->getTranslation('name', 'en')) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label><strong>Description (English):</strong></label>
                            <textarea class="form-control" style="height:150px" name="description[en]">{{ old('description.en', $menuItem->getTranslation('description', 'en')) }}</textarea>
                        </div>

                        <hr>
                        <p><strong>Translations (Optional)</strong></p>
                        <div class="row">
                            <div class="col-md-4"><label>Amharic</label><input type="text" name="name[am]" class="form-control mb-2" value="{{ old('name.am', $menuItem->getTranslation('name', 'am')) }}" placeholder="Name"></div>
                            <div class="col-md-4"><label>Somali</label><input type="text" name="name[so]" class="form-control mb-2" value="{{ old('name.so', $menuItem->getTranslation('name', 'so')) }}" placeholder="Name"></div>
                            <div class="col-md-4"><label>Oromo</label><input type="text" name="name[om]" class="form-control mb-2" value="{{ old('name.om', $menuItem->getTranslation('name', 'om')) }}" placeholder="Name"></div>
                        </div>
                        <div class="row">
                             <div class="col-md-4"><textarea class="form-control" name="description[am]" placeholder="Description">{{ old('description.am', $menuItem->getTranslation('description', 'am')) }}</textarea></div>
                             <div class="col-md-4"><textarea class="form-control" name="description[so]" placeholder="Description">{{ old('description.so', $menuItem->getTranslation('description', 'so')) }}</textarea></div>
                             <div class="col-md-4"><textarea class="form-control" name="description[om]" placeholder="Description">{{ old('description.om', $menuItem->getTranslation('description', 'om')) }}</textarea></div>
                        </div>
                    </div>

                    <!-- Sidebar Details -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label><strong>Price:</strong></label>
                            <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price', $menuItem->price) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label><strong>Category:</strong></label>
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $menuItem->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->getTranslation('name', 'en') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label><strong>Image:</strong></label>
                            <input type="file" name="image" class="form-control">
                            @if ($menuItem->image_path)
                                <img src="{{ asset('storage/' . $menuItem->image_path) }}" width="200px" class="mt-2">
                            @endif
                        </div>
                        <div class="form-check form-switch mb-3">
                             <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $menuItem->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Is Active?</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_special" id="is_special" value="1" {{ old('is_special', $menuItem->is_special) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_special">Feature as Chef's Special?</label>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Tags Section -->
                <div class="row">
                    <div class="col-md-12">
                        <h4>Tags & Allergens</h4>
                        @php
                            $selectedTags = old('tags', $menuItem->tags->pluck('id')->toArray());
                        @endphp
                        @foreach($tags as $type => $tagGroup)
                            <div class="mb-3">
                                <h5>{{ ucfirst($type) }}</h5>
                                <div class="d-flex flex-wrap">
                                    @foreach($tagGroup as $tag)
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                                                {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection