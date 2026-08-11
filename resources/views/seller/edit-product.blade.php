<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Product | SMART BASKET Seller</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
* { font-family: 'Poppins', sans-serif; }
body { background: linear-gradient(135deg, #020617, #000, #111827); color: #fff; min-height: 100vh; padding: 30px 20px; }
.seller-header { display: flex; justify-content: space-between; align-items: center; max-width: 900px; margin: 0 auto 30px; }
.seller-header h1 { color: #FFD700; font-size: 28px; font-weight: 800; }
.seller-header a { color: #00ff99; text-decoration: none; font-weight: 600; }
.form-card { max-width: 900px; margin: 0 auto; background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255,215,0,0.3); border-radius: 25px; padding: 40px; box-shadow: 0 0 50px rgba(255,215,0,0.15); }
.form-label { color: #ccc; font-size: 14px; font-weight: 600; margin-bottom: 6px; }
.form-control, .form-select { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); color: #fff; border-radius: 12px; padding: 12px 16px; }
.form-control:focus, .form-select:focus { background: rgba(255,255,255,0.15); border-color: #FFD700; color: #fff; box-shadow: 0 0 0 0.2rem rgba(255,215,0,0.15); }
.form-select option { background: #111827; color: #fff; }
.btn-submit { background: linear-gradient(135deg, #FFD700, #ff9900); border: 0; border-radius: 15px; padding: 14px; font-weight: 700; font-size: 16px; color: #000; width: 100%; transition: 0.3s; }
.btn-submit:hover { transform: scale(1.02); box-shadow: 0 0 30px rgba(255,215,0,0.5); }
.current-image { width: 100%; max-height: 200px; object-fit: cover; border-radius: 15px; margin-bottom: 10px; }
.alert-success-custom { background: rgba(0,255,153,0.15); border: 1px solid #00ff99; color: #00ff99; border-radius: 12px; padding: 15px; margin-bottom: 20px; }
.alert-error-custom { background: rgba(255,0,0,0.15); border: 1px solid #ff6b6b; color: #ff6b6b; border-radius: 12px; padding: 15px; margin-bottom: 20px; }
</style>
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body>
<div class="seller-header">
    <h1><i class="fa-solid fa-pen-to-square"></i> Edit Product</h1>
    <a href="/seller-dashboard"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
</div>
<div class="form-card">
    @if(session('error'))
    <div class="alert-error-custom"><i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if ($errors->any())
    <div class="alert-error-custom">
        @foreach($errors->all() as $error)
        <div><i class="fa-solid fa-exclamation-triangle"></i> {{ $error }}</div>
        @endforeach
    </div>
    @endif
    <form method="POST" action="{{ route('seller.product.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <input type="text" name="category" class="form-control" value="{{ $product->category }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ $product->brand }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Price (Rs) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" step="0.01" min="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Discount Price (Rs)</label>
                <input type="number" name="discount_price" class="form-control" value="{{ $product->discount_price }}" step="0.01" min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Size</label>
                <input type="text" name="size" class="form-control" value="{{ $product->size }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-control" value="{{ $product->color }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ ($product->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Current Image</label>
                <img src="{{ asset('products/'.$product->image) }}" class="current-image" alt="Current">
                <label class="form-label mt-2">Change Image (optional)</label>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp">
            </div>
            <div class="col-12">
                <label class="form-label">Add More Product Images</label>
                <input type="file" name="images[]" class="form-control" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                @if($product->images->isNotEmpty())<div class="d-flex gap-2 flex-wrap mt-2">@foreach($product->images as $extraImage)<img src="{{ asset('storage/'.$extraImage->path) }}" alt="Product view" width="90" height="70" style="object-fit:cover;border-radius:8px">@endforeach</div>@endif
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn-submit"><i class="fa-solid fa-save"></i> UPDATE PRODUCT</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
