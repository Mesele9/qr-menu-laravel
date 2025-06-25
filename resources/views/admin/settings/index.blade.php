@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Branding & Customization</h1>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

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

    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header"><h4>Company Details</h4></div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="company_logo"><strong>Company Logo:</strong></label>
                            <input type="file" name="company_logo" class="form-control">
                            <small class="form-text text-muted">Recommended: 4:3 ratio (e.g., 1200x900px).</small>
                            @if(isset($settings['company_logo_path']))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['company_logo_path']) }}" alt="Current Logo" style="max-height: 80px; background: #f1f1f1; padding: 5px; border-radius: 4px;">
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="company_name">Company Name:</label>
                            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $settings['company_name'] ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="company_address">Company Address:</label>
                            <input type="text" name="company_address" class="form-control" value="{{ old('company_address', $settings['company_address'] ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="company_phone">Company Phone:</label>
                            <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone', $settings['company_phone'] ?? '') }}">
                        </div>
                        <hr>
                        <p><strong>Social Media Links:</strong></p>
                        <div class="form-group mb-2"><input type="url" name="social_facebook" class="form-control" placeholder="Facebook URL" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}"></div>
                        <div class="form-group mb-2"><input type="url" name="social_instagram" class="form-control" placeholder="Instagram URL" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}"></div>
                        <div class="form-group mb-2"><input type="url" name="social_twitter" class="form-control" placeholder="Twitter/X URL" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}"></div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Color Scheme -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header"><h4>Color Scheme</h4></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 form-group mb-3"><label>Primary Brand Color</label><input type="color" name="primary_brand_color" class="form-control form-control-color" value="{{ old('primary_brand_color', $settings['primary_brand_color'] ?? '#dc3545') }}"></div>
                            <div class="col-sm-6 form-group mb-3"><label>Secondary Brand Color</label><input type="color" name="secondary_brand_color" class="form-control form-control-color" value="{{ old('secondary_brand_color', $settings['secondary_brand_color'] ?? '#ffc107') }}"></div>
                            <div class="col-sm-6 form-group mb-3"><label>Main Background</label><input type="color" name="main_bg_color" class="form-control form-control-color" value="{{ old('main_bg_color', $settings['main_bg_color'] ?? '#f8f9fa') }}"></div>
                            <div class="col-sm-6 form-group mb-3"></div>
                            <div class="col-sm-6 form-group mb-3"><label>Header Background</label><input type="color" name="header_bg_color" class="form-control form-control-color" value="{{ old('header_bg_color', $settings['header_bg_color'] ?? '#ffffff') }}"></div>
                            <div class="col-sm-6 form-group mb-3"><label>Header Text</label><input type="color" name="header_text_color" class="form-control form-control-color" value="{{ old('header_text_color', $settings['header_text_color'] ?? '#212529') }}"></div>
                            <div class="col-sm-6 form-group mb-3"><label>Footer Background</label><input type="color" name="footer_bg_color" class="form-control form-control-color" value="{{ old('footer_bg_color', $settings['footer_bg_color'] ?? '#343a40') }}"></div>
                            <div class="col-sm-6 form-group mb-3"><label>Footer Text</label><input type="color" name="footer_text_color" class="form-control form-control-color" value="{{ old('footer_text_color', $settings['footer_text_color'] ?? '#ffffff') }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================= -->
        <!-- === NEW: LOCALIZATION SETTINGS CARD === -->
        <!-- ============================================= -->
        <div class="row">
            <div class="col-12">
                 <div class="card">
                    <div class="card-header"><h4>Localization Settings</h4></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="default_language" class="form-label"><strong>Default Language for New Visitors</strong></label>
                                    @php
                                        $supportedLangs = ['en' => 'English', 'am' => 'Amharic', 'so' => 'Somali', 'om' => 'Oromo'];
                                        $currentDefault = old('default_language', $settings['default_language'] ?? 'en');
                                    @endphp
                                    <select class="form-select" id="default_language" name="default_language">
                                        @foreach ($supportedLangs as $code => $name)
                                            <option value="{{ $code }}" {{ $currentDefault == $code ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">This will be the language shown to first-time visitors.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-center mt-4 mb-4">
            <button type="submit" class="btn btn-primary btn-lg">Save All Settings</button>
        </div>
    </form>
</div>
@endsection