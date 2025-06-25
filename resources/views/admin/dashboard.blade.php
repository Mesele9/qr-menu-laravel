@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <!-- Stat Cards -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-utensils me-2"></i> Total Menu Items</h5>
                    <p class="card-text fs-2 fw-bold">{{ $stats['menu_items'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-folder-open me-2"></i> Total Categories</h5>
                    <p class="card-text fs-2 fw-bold">{{ $stats['categories'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-dark bg-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-comments me-2"></i> Pending Reviews</h5>
                    <p class="card-text fs-2 fw-bold">{{ $stats['reviews_pending'] }}</p>
                    <a href="{{ route('admin.reviews.index') }}" class="stretched-link text-dark">View Reviews</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-4">
        <h3>Quick Actions</h3>
        <hr>
        <div class="d-grid gap-2 d-md-block">
            <a href="{{ route('admin.menu-items.create') }}" class="btn btn-lg btn-success"><i class="fas fa-plus-circle me-2"></i> Add New Menu Item</a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-lg btn-info"><i class="fas fa-plus-circle me-2"></i> Add New Category</a>
            <a href="{{ route('admin.tags.create') }}" class="btn btn-lg btn-secondary"><i class="fas fa-plus-circle me-2"></i> Add New Tag</a>
        </div>
    </div>
@endsection