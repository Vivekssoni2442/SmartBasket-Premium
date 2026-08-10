<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Basket Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            min-height: 100vh;
        }
        .product-card {
            border: 0;
            border-radius: 1.2rem;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.14);
        }
        .product-img {
            height: 220px;
            object-fit: cover;
            width: 100%;
        }
        .pill {
            font-size: 0.8rem;
            letter-spacing: 0.02em;
        }
        .action-btn {
            border-radius: 999px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <p class="text-primary fw-semibold mb-2">Smart Basket</p>
                <h1 class="display-6 fw-bold mb-0">Featured Products</h1>
                <p class="text-muted mb-0">Fresh items added by the seller, ready for customers.</p>
            </div>
            <div class="text-muted fw-semibold">{{ $pagedProducts->total() }} Products</div>
        </div>

        <form method="GET" action="{{ route('products.index') }}" class="row g-3 bg-white rounded-4 p-3 shadow-sm mb-4">
            <div class="col-12 col-md-6">
                <label class="form-label small text-muted">Search</label>
                <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search products or category">
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label small text-muted">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $categoryOption)
                        <option value="{{ $categoryOption }}" {{ $category === $categoryOption ? 'selected' : '' }}>{{ $categoryOption }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100 action-btn">Apply</button>
            </div>
        </form>

        @if($pagedProducts->count() > 0)
            <div class="row g-4">
                @foreach($pagedProducts as $product)
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card product-card h-100">
                            <img src="{{ asset('products/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $product->name }}</h5>
                                        <p class="text-muted mb-0 small">{{ $product->category }}</p>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary pill">In Stock</span>
                                </div>

                                <div class="d-flex align-items-center text-warning mb-2">
                                    <i class="fa-solid fa-star"></i>
                                    <span class="ms-2 fw-semibold">{{ number_format($product->rating, 1) }}</span>
                                    <span class="text-muted ms-2">• {{ $product->stock }} left</span>
                                </div>

                                <p class="text-muted small flex-grow-1">{{ $product->description ? \Illuminate\Support\Str::limit($product->description, 90) : 'Premium quality product from Smart Basket.' }}</p>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <div class="fw-bold fs-5 text-dark">₹{{ number_format($product->price, 2) }}</div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-outline-dark btn-sm action-btn">Buy Now</a>
                                        <a href="#" class="btn btn-primary btn-sm action-btn">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $pagedProducts->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-light border text-center py-5 rounded-4">
                <h4 class="fw-semibold mb-2">No products found</h4>
                <p class="text-muted mb-0">Try adjusting your search or category filter.</p>
            </div>
        @endif
    </div>
</body>
</html>
