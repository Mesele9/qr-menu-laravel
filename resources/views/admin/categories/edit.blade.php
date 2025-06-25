@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h2>Edit Category</h2>
            <a class="btn btn-secondary mb-3" href="{{ route('admin.categories.index') }}"> Back</a>
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
             <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_en"><strong>Name (English):</strong></label>
                            <input type="text" id="name_en" name="name[en]" value="{{ old('name.en', $category->getTranslation('name', 'en')) }}" class="form-control" placeholder="English Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="order"><strong>Display Order:</strong></label>
                            <input type="number" id="order" name="order" value="{{ old('order', $category->order) }}" class="form-control" placeholder="Order">
                        </div>
                    </div>
                </div>

                <hr>
                <p><strong>Translations (Optional)</strong></p>

                <div class="row mt-2">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_am"><strong>Name (Amharic):</strong></label>
                            <input type="text" id="name_am" name="name[am]" value="{{ old('name.am', $category->getTranslation('name', 'am')) }}" class="form-control" placeholder="Amharic Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_so"><strong>Name (Somali):</strong></label>
                            <input type="text" id="name_so" name="name[so]" value="{{ old('name.so', $category->getTranslation('name', 'so')) }}" class="form-control" placeholder="Somali Name">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_om"><strong>Name (Oromic):</strong></label>
                            <input type="text" id="name_om" name="name[om]" value="{{ old('name.om', $category->getTranslation('name', 'om')) }}" class="form-control" placeholder="Oromic Name">
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