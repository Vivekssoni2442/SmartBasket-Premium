<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product | SMART BASKET Seller</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
* { font-family: 'Poppins', sans-serif; }
body { background: linear-gradient(135deg, #020617, #000, #111827); color: #fff; min-height: 100vh; padding: 30px 20px; }
.seller-header { display: flex; justify-content: space-between; align-items: center; max-width: 900px; margin: 0 auto 30px; }
.seller-header h1 { color: #00ff99; font-size: 28px; font-weight: 800; }
.seller-header a { color: #FFD700; text-decoration: none; font-weight: 600; }
.form-card { max-width: 900px; margin: 0 auto; background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(0,255,153,0.3); border-radius: 25px; padding: 40px; box-shadow: 0 0 50px rgba(0,255,153,0.15); }
.form-label { color: #ccc; font-size: 14px; font-weight: 600; margin-bottom: 6px; }
.form-control, .form-select { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); color: #fff; border-radius: 12px; padding: 12px 16px; }
.form-control:focus, .form-select:focus { background: rgba(255,255,255,0.15); border-color: #00ff99; color: #fff; box-shadow: 0 0 0 0.2rem rgba(0,255,153,0.15); }
.form-control::placeholder { color: #888; }
.form-select option { background: #111827; color: #fff; }
.btn-submit { background: linear-gradient(135deg, #00ff99, #00cc77); border: 0; border-radius: 15px; padding: 14px; font-weight: 700; font-size: 16px; color: #000; width: 100%; transition: 0.3s; }
.btn-submit:hover { transform: scale(1.02); box-shadow: 0 0 30px rgba(0,255,153,0.5); }
.image-preview { width: 100%; max-height: 250px; object-fit: cover; border-radius: 15px; margin-top: 12px; display: none; border: 2px solid rgba(0,255,153,0.3); }
.image-preview.show { display: block; }
.upload-zone { border: 2px dashed rgba(0,255,153,0.4); border-radius: 15px; padding: 30px; text-align: center; cursor: pointer; transition: 0.3s; background: rgba(0,255,153,0.05); }
.upload-zone:hover { border-color: #00ff99; background: rgba(0,255,153,0.1); }
.upload-zone i { font-size: 2.5rem; color: #00ff99; margin-bottom: 10px; }
.upload-zone p { color: #aaa; margin: 0; }
.alert-success-custom { background: rgba(0,255,153,0.15); border: 1px solid #00ff99; color: #00ff99; border-radius: 12px; padding: 15px; margin-bottom: 20px; }
.alert-error-custom { background: rgba(255,0,0,0.15); border: 1px solid #ff6b6b; color: #ff6b6b; border-radius: 12px; padding: 15px; margin-bottom: 20px; }
</style>
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
</head>
<body>
<div class="seller-header">
    <h1><i class="fa-solid fa-plus-circle"></i> Add New Product</h1>
    <a href="/seller-dashboard"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
</div>
<div class="form-card">
    @if(session('success'))
    <div class="alert-success-custom"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
    @endif
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
    <form method="POST" action="{{ route('seller.product.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <input type="text" name="category" class="form-control" placeholder="e.g. Electronics, Fashion" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" placeholder="e.g. Samsung, Nike">
            </div>
            <div class="col-md-6">
                <label class="form-label">Price (Rs) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" placeholder="0.00" step="0.01" min="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Discount Price (Rs)</label>
                <input type="number" name="discount_price" class="form-control" placeholder="0.00" step="0.01" min="0">
            </div>
            <div class="col-md-6">
                <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control" placeholder="0" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Size (optional)</label>
                <input type="text" name="size" class="form-control" placeholder="e.g. S, M, L, XL">
            </div>
            <div class="col-md-4">
                <label class="form-label">Color (optional)</label>
                <input type="text" name="color" class="form-control" placeholder="e.g. Black, Red">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" selected>Active (Visible to users)</option>
                    <option value="inactive">Inactive (Hidden from users)</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Enter product description"></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Product Image <span class="text-danger">*</span></label>
                <div class="upload-zone" onclick="document.getElementById('imageInput').click()">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <p>Click to upload product image (JPEG, PNG, JPG, WEBP - max 2MB)</p>
                </div>
                <input type="file" name="image" id="imageInput" class="form-control d-none" accept="image/jpeg,image/png,image/jpg,image/webp" required onchange="previewImage(this)">
                <img id="imagePreview" class="image-preview" src="" alt="Preview">
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-plus"></i> ADD PRODUCT
                </button>
            </div>
        </div>
    </form>
</div>
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.add('show');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
