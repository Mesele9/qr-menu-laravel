@extends('layouts.guest')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        /* All CSS from the previous step remains the same and is correct */
        body { font-family: 'Lato', sans-serif; background-color: var(--main-bg); background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='49' viewBox='0 0 28 49'%3E%3Cg fill-rule='evenodd'%3E%3Cg id='hexagons' fill='%23e9ecef' fill-opacity='0.4' fill-rule='nonzero'%3E%3Cpath d='M13.99 9.25l13 7.5v15l-13 7.5L1 31.75v-15l12.99-7.5zM3 17.9v12.7l10.99 6.34 11-6.35V17.9l-11-6.34L3 17.9zM0 15l12.99 7.5V30L0 22.5zM28 15v7.5L15 30V22.5z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
        h1, h2, h3, h4, h5, h6, .card-title, .display-6 { font-family: 'Poppins', sans-serif; font-weight: 700; }
        .menu-item-card { transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; cursor: pointer; }
        .menu-item-card:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
        .carousel-caption h3 { font-size: 2rem; }
        @media (min-width: 768px) { .carousel-caption h3 { font-size: 3.5rem; } }
        .rate { height: 46px; }
        .rate:not(:checked) > input { position:absolute; top:-9999px; }
        .rate:not(:checked) > label { float:right; width:1em; overflow:hidden; white-space:nowrap; cursor:pointer; font-size:30px; color:#ccc; }
        .rate:not(:checked) > label:before { content: '★ '; }
        .rate > input:checked ~ label { color: #ffc700; }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label { color: #deb217; }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label { color: #c59b08; }
    </style>
@endpush


@section('content')

<header class="shadow-sm py-3" style="background-color: var(--header-bg); color: var(--header-text);">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            @if(!empty($settings['company_logo_path']))
                <img src="{{ asset('storage/' . $settings['company_logo_path']) }}" alt="Logo" style="height: 50px; margin-right: 15px;">
            @endif
            <h1 class="h4 mb-0">{{ $settings['company_name'] ?? 'Digital Menu' }}</h1>
        </div>
        <div class="language-switcher">
            @php
                $supportedLangs = ['en' => 'English', 'am' => 'Amharic', 'so' => 'Somali', 'om' => 'Oromo'];
            @endphp
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-success dropdown-toggle rounded-pill px-2 py-1" style="color: var(--brand-primary);" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-language"></i> {{ $supportedLangs[app()->getLocale()] ?? 'Language' }}
                </button>
                <ul class="dropdown-menu">
                    @foreach ($supportedLangs as $code => $name)
                        <li><a class="dropdown-item {{ app()->getLocale() == $code ? 'active' : '' }}" href="{{ route('language.set', $code) }}">{{ $name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</header>

<main class="container my-5">


    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Search and Filtering -->
    <section id="search-filter" class="mb-5 p-3 rounded" style="background-color: #fff; border: 1px solid #dee2e6;">
        <form action="{{ route('menu.index') }}" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search for a dish..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center flex-wrap">
                    <span class="me-3 fw-bold d-none d-lg-block">Filter by:</span>
                    @foreach($filterableTags as $tag)
                        <button type="submit" name="filter_tag" value="{{ $tag->id }}" 
                                class="btn btn-sm me-2 mb-1 {{ request('filter_tag') == $tag->id ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="{{ $tag->icon_path }}"></i> {{ $tag->getTranslation('name', 'en') }}
                        </button>
                    @endforeach
                    @if(request('search') || request('filter_tag'))
                    <a href="{{ route('menu.index') }}" class="btn btn-sm btn-danger mb-1"><i class="fas fa-times"></i> Clear</a>
                    @endif
                </div>
            </div>
        </form>
    </section>

    <!-- === NEW: CHEF'S SPECIALS CAROUSEL === -->
    @if($specials->isNotEmpty())
    <section id="specials" class="mb-5">
        <h2 class="mb-4 text-center" style="color: var(--brand-primary);">Chef's Recommendations</h2>
        <div id="specialsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner rounded-3 shadow-lg">
                @foreach($specials as $special)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="card text-bg-dark border-0">
                        <img src="{{ asset('storage/' . $special->image_path) }}" class="d-block w-100" alt="{{ $special->name }}" style="height: 400px; object-fit: cover; filter: brightness(0.6);">
                        <div class="carousel-caption d-block text-start">
                            <!-- CHANGE: Use magic attribute -->
                            <h3>{{ $special->name }}</h3>
                            <p class="d-none d-sm-block">{{ Str::limit($special->description, 120) }}</p>
                            <p><a class="btn" style="background-color: var(--brand-primary); color: white;" href="#item-{{$special->id}}">View Item</a></p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#specialsCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></button>
            <button class="carousel-control-next" type="button" data-bs-target="#specialsCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></button>
        </div>
    </section>
    @endif

    <nav class="sticky-top bg-light py-2 mb-5 rounded shadow-sm" style="top: 10px;">
        <div class="container d-flex flex-wrap justify-content-center">
             @foreach($categories as $category)
            <a href="#category-{{ $category->id }}" class="btn me-2 mb-2" style="background-color: var(--brand-secondary); color: white;">{{ $category->name }}</a>
            @endforeach
        </div>
    </nav>

    @foreach($categories as $category)
    <section id="category-{{ $category->id }}" class="mb-5">
        <!-- CHANGE: Use magic attribute -->
        <h2 class="display-6 border-bottom pb-2 mb-4">{{ $category->name }}</h2>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($category->menuItems as $item)
            <div class="col">
                <div id="item-{{ $item->id }}" class="card h-100 shadow-sm border-0 menu-item-card" data-bs-toggle="modal" data-bs-target="#detailModal" data-item-json="{{ $item->toJson() }}">
                    <div class="row g-0">
                        <div class="col-sm-4">
                             @if($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid rounded-start w-100 h-100" alt="{{ $item->name }}" style="object-fit: cover; min-height: 150px;">
                            @endif
                        </div>
                        <div class="col-sm-8">
                            <div class="card-body d-flex flex-column h-100">
                                <div class="d-flex justify-content-between">
                                    <!-- CHANGE: Use magic attribute -->
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <h5 class="card-title text-nowrap" style="color: var(--brand-primary);">Br{{ number_format($item->price, 2) }}</h5>
                                </div>
                                <!-- CHANGE: Use magic attribute -->
                                <p class="card-text text-muted small">{{ Str::limit($item->description, 100) }}</p>
                                
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    {{-- Star rating display remains correct --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endforeach
</main>

<!-- Footer -->
<footer class="py-4 mt-auto" style="background-color: var(--footer-bg); color: var(--footer-text);">
    <div class="container text-center">
        @if(!empty($settings['company_name']))<p class="mb-1 fw-bold">{{ $settings['company_name'] }}</p>@endif
        @if(!empty($settings['company_address']))<p class="mb-1">{{ $settings['company_address'] }}</p>@endif
        @if(!empty($settings['company_phone']))<p class="mb-1">Phone: {{ $settings['company_phone'] }}</p>@endif
        <div class="social-icons mt-2">
            @if(!empty($settings['social_facebook']))<a href="{{ $settings['social_facebook'] }}" target="_blank" class="mx-2" style="color: var(--footer-text);"><i class="fab fa-facebook-f"></i></a>@endif
            @if(!empty($settings['social_instagram']))<a href="{{ $settings['social_instagram'] }}" target="_blank" class="mx-2" style="color: var(--footer-text);"><i class="fab fa-instagram"></i></a>@endif
            @if(!empty($settings['social_twitter']))<a href="{{ $settings['social_twitter'] }}" target="_blank" class="mx-2" style="color: var(--footer-text);"><i class="fab fa-twitter"></i></a>@endif
        </div>
    </div>
</footer>


<!-- === NEW: ITEM DETAIL MODAL === -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h4 class="modal-title" id="detailModalLabel">Item Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="modal_item_image" src="" class="img-fluid rounded mb-3" alt="Menu Item Image">
                    </div>
                    <div class="col-md-6">
                        <h2 id="modal_item_name" class="mb-1"></h2>
                        <h3 id="modal_item_price" class="mb-3" style="color: var(--brand-primary);"></h3>
                        <div id="modal_item_tags" class="mb-3"></div>
                        <p id="modal_item_description" class="text-muted"></p>
                    </div>
                </div>
                <hr>
                <!-- Reviews and Rating Form -->
                <div>
                    <h5>Reviews</h5>
                    <div id="modal_item_reviews" class="mb-4" style="max-height: 200px; overflow-y: auto;">
                        <!-- Reviews will be populated by JS -->
                    </div>
                    
                    <h5>Leave a Review</h5>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <x-honeypot />  
                        <input type="hidden" name="menu_item_id" id="modal_menu_item_id">
                    @if ($errors->has('rating'))
                            <div class="alert alert-danger p-2">Please select a star rating.</div>
                        @endif
                        <div class="mb-3 text-center">
                            <div class="rate">
                               <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 stars"></label>
                               <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars"></label>
                               <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars"></label>
                               <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars"></label>
                               <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea name="comment" class="form-control" rows="2" placeholder="Optional comment..."></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn" style="background-color: var(--brand-primary); color: white;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailModal = document.getElementById('detailModal');
    const currentLocale = '{{ app()->getLocale() }}'; 

    detailModal.addEventListener('show.bs.modal', function (event) {
        const triggerElement = event.relatedTarget;
        if (!triggerElement) return;

        // The magic is here: Parse the full item data from the data attribute
        const item = JSON.parse(triggerElement.getAttribute('data-item-json'));
        
        // --- Populate Modal Fields ---
        detailModal.querySelector('#modal_item_name').textContent = item.name[currentLocale] || item.name.en;
        detailModal.querySelector('#modal_item_price').textContent = 'Br' + parseFloat(item.price).toFixed(2);
        detailModal.querySelector('#modal_item_description').textContent = item.description[currentLocale] || item.description.en;
        detailModal.querySelector('#modal_menu_item_id').value = item.id;
        
        // Image
        const imageElement = detailModal.querySelector('#modal_item_image');
        if (item.image_path) {
            imageElement.src = '{{ asset('storage/') }}' + '/' + item.image_path;
            imageElement.style.display = 'block';
        } else {
            imageElement.style.display = 'none';
        }

        // Tags
        const tagsContainer = detailModal.querySelector('#modal_item_tags');
        tagsContainer.innerHTML = '';
        if (item.tags && item.tags.length > 0) {
            item.tags.forEach(tag => {
                const tagEl = document.createElement('span');
                tagEl.className = 'badge rounded-pill me-2';
                tagEl.style.backgroundColor = (tag.type === 'allergen') ? '#dc3545' : 'var(--brand-secondary)';
                // Also fix the tag name translation
                const tagName = tag.name[currentLocale] || tag.name.en;
                tagEl.innerHTML = `<i class="${tag.icon_path} me-1"></i> ${tagName}`;
                tagsContainer.appendChild(tagEl);
            });
        }
        
        // Reviews
        const reviewsContainer = detailModal.querySelector('#modal_item_reviews');
        reviewsContainer.innerHTML = ''; // Clear previous reviews
        if (item.reviews && item.reviews.length > 0) {
            item.reviews.forEach(review => {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    stars += `<i class="fas fa-star" style="font-size: 0.8em; color: ${i <= review.rating ? '#ffc107' : '#e4e5e9'};"></i>`;
                }
                reviewsContainer.innerHTML += `
                    <div class="mb-2">
                        <p class="mb-0">"${review.comment}"</p>
                        <small class="text-muted">${stars}</small>
                    </div><hr class="my-2">`;
            });
        } else {
            reviewsContainer.innerHTML = '<p class="text-muted">No reviews yet.</p>';
        }

        // Reset the form
        detailModal.querySelector('form').reset();
    });

    // Re-open modal on validation error
    @if ($errors->any())
        const erroredItemId = "{{ old('menu_item_id') }}";
        const triggerForErroredItem = document.getElementById('item-' + erroredItemId);
        if (triggerForErroredItem) {
            var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
            
            // We need to pass the trigger element to the event
            var modalEvent = new Event('show.bs.modal', { bubbles: true });
            modalEvent.relatedTarget = triggerForErroredItem;
            detailModal.dispatchEvent(modalEvent);
            
            myModal.show();
        }
    @endif
});
</script>
@endpush

@endsection
