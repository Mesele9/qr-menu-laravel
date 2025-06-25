@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-lg-12">
            <h2>Manage Guest Reviews</h2>
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
                        <th width="20%">Menu Item</th>
                        <th width="10%" class="text-center">Rating</th>
                        <th>Comment</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="15%" class="text-center">Date</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr>
                            <td>{{ $review->menuItem->getTranslation('name', 'en') ?? 'Deleted Item' }}</td>
                            <td class="text-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#ffc107' : '#e4e5e9' }};"></i>
                                @endfor
                            </td>
                            <td>{{ $review->comment ?? 'No comment provided.' }}</td>
                            <td class="text-center">
                                @if($review->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $review->created_at->format('Y-m-d') }}</td>
                            <td class="d-flex justify-content-start">
                                <!-- Approve/Disapprove Form -->
                                <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" class="me-2">
                                    @csrf
                                    @method('PUT')
                                    @if($review->is_approved)
                                        <input type="hidden" name="is_approved" value="0">
                                        <button type="submit" class="btn btn-sm btn-outline-warning">Hide</button>
                                    @else
                                        <input type="hidden" name="is_approved" value="1">
                                        <button type="submit" class="btn btn-sm btn-outline-success">Approve</button>
                                    @endif
                                </form>

                                <!-- Delete Form -->
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to permanently delete this review?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No reviews found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $reviews->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection