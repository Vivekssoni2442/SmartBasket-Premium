<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Orders | Smart Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/premium-dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order-tracking.css') }}">
</head>
<body>
<main class="order-page">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
            <div>
                <p class="text-primary fw-semibold mb-1">SELLER PANEL</p>
                <h1 class="h2 fw-bold mb-1">Order Management</h1>
                <p class="text-muted mb-0">Review customers, payment status, and delivery assignments.</p>
            </div>
            <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Please fix the following:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="order-card table-responsive">
            <table class="table seller-order-table align-middle">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Products</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            $delivery = $order->deliveryDetail;
                            $partner = $delivery?->deliveryPartner;
                        @endphp
                        <tr>
                            <td>#{{ $order->id }}
                                <small class="d-block text-muted">{{ $order->created_at?->format('d M Y') }}</small>
                            </td>
                            <td>{{ $order->name }}
                                <small class="d-block text-muted">{{ $order->address }}, {{ $order->city }}</small>
                            </td>
                            <td>
                                @foreach($order->seller_items ?? [] as $item)
                                    <div class="small">{{ $item['name'] ?? ($products[$item['product_id'] ?? null]?->name ?? 'Product') }} × {{ $item['quantity'] ?? 1 }}</div>
                                @endforeach
                            </td>
                            <td>{{ $order->payment_status ?? 'Pending' }}</td>
                            <td><span class="status-pill">{{ $delivery?->status ?? $order->order_status ?? 'Order Placed' }}</span></td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button"
                                            class="btn btn-success btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deliveryModal{{ $order->id }}"
                                            title="Set or update Delivery Boy details">
                                        <i class="fa-solid fa-box me-1"></i> Delivery Boy Details
                                    </button>
                                    <button type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewModal{{ $order->id }}"
                                            title="View full delivery details">
                                        <i class="fa-solid fa-eye me-1"></i> View Delivery Details
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

@foreach($orders as $order)
    @php
        $delivery = $order->deliveryDetail;
        $partner = $delivery?->deliveryPartner;
    @endphp

    {{-- Delivery Boy Details modal (form) --}}
    <div class="modal fade" id="deliveryModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="{{ route('seller.orders.delivery.store', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content bg-dark text-white border-secondary">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-box me-2"></i> Delivery Boy Details — Order #{{ $order->id }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Delivery Boy Photo</label>
                                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $partner?->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number *</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $partner?->phone) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $partner?->email) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vehicle Type</label>
                                <input type="text" name="vehicle_type" class="form-control" value="{{ old('vehicle_type', $partner?->vehicle_type) }}" placeholder="e.g. Bike / Scooter / Van">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vehicle Number</label>
                                <input type="text" name="vehicle_number" class="form-control" value="{{ old('vehicle_number', $partner?->vehicle_number) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Delivery Date</label>
                                <input type="date" name="delivery_date" class="form-control" value="{{ old('delivery_date', $partner?->delivery_date?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Expected Delivery Time</label>
                                <input type="time" name="expected_time" class="form-control" value="{{ old('expected_time', $partner?->expected_time) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Current Delivery Status</label>
                                <select name="status" class="form-select">
                                    @foreach(['Order Placed','Seller Confirmed','Packed','Picked By Delivery Partner','Out For Delivery','Near Customer','Delivered'] as $status)
                                        <option value="{{ $status }}" {{ old('status', $delivery?->status ?? 'Order Placed') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Any special instructions...">{{ old('notes', $partner?->notes) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk me-1"></i> Save Details</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- View Delivery Details modal --}}
    <div class="modal fade" id="viewModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-truck me-2"></i> Delivery Details — Order #{{ $order->id }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($partner)
                        <div class="row g-4">
                            <div class="col-md-4 text-center">
                                @if($partner->image)
                                    <img src="{{ asset('delivery-partners/'.$partner->image) }}" alt="Delivery Boy" class="rounded-circle border mb-2" style="width:120px;height:120px;object-fit:cover;">
                                @else
                                    <div class="rounded-circle border d-grid align-items-center justify-content-center mx-auto mb-2" style="width:120px;height:120px;background:#1e293b;">
                                        <i class="fa-solid fa-user" style="font-size:2.5rem;color:#64748b;"></i>
                                    </div>
                                @endif
                                <h5 class="mb-0">{{ $partner->name }}</h5>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-success fw-bold mb-3"><i class="fa-solid fa-box me-1"></i> Delivery Boy Information</h6>
                                <div class="row g-2 small">
                                    <div class="col-6"><strong>Mobile:</strong> {{ $partner->phone ?? '—' }}</div>
                                    <div class="col-6"><strong>Email:</strong> {{ $partner->email ?? '—' }}</div>
                                    <div class="col-6"><strong>Vehicle Type:</strong> {{ $partner->vehicle_type ?? '—' }}</div>
                                    <div class="col-6"><strong>Vehicle Number:</strong> {{ $partner->vehicle_number ?? '—' }}</div>
                                    <div class="col-6"><strong>Delivery Date:</strong> {{ $partner->delivery_date?->format('d M Y') ?? '—' }}</div>
                                    <div class="col-6"><strong>Expected Time:</strong> {{ $partner->expected_time ?? '—' }}</div>
                                    <div class="col-12"><strong>Current Delivery Status:</strong> <span class="status-pill">{{ $delivery?->status ?? 'Order Placed' }}</span></div>
                                    @if($partner->notes)
                                        <div class="col-12"><strong>Notes:</strong> {{ $partner->notes }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fa-solid fa-box-open mb-2" style="font-size:2rem;"></i>
                            <p>No delivery details assigned to this order yet.</p>
                        </div>
                    @endif

                    <hr>
                    <h6 class="text-primary fw-bold mb-3"><i class="fa-solid fa-user me-1"></i> Customer Information</h6>
                    <div class="row g-2 small">
                        <div class="col-6"><strong>Order Number:</strong> #{{ $order->id }}</div>
                        <div class="col-6"><strong>Customer Name:</strong> {{ $order->name }}</div>
                        <div class="col-6"><strong>Customer Mobile:</strong> {{ $order->mobile }}</div>
                        <div class="col-6"><strong>Customer Address:</strong> {{ $order->address }}, {{ $order->city }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-warning edit-delivery-btn"
                            data-view="#viewModal{{ $order->id }}"
                            data-edit="#deliveryModal{{ $order->id }}">
                        <i class="fa-solid fa-pen me-1"></i> Edit
                    </button>
                    <form action="{{ route('seller.orders.delivery.destroy', $order) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete delivery details for order #{{ $order->id }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash me-1"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Edit button: close the "View" modal and open the "Delivery Boy Details" form modal.
    document.querySelectorAll('.edit-delivery-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const viewModal = document.querySelector(btn.dataset.view);
            const editModal = document.querySelector(btn.dataset.edit);
            if (viewModal) {
                const vm = bootstrap.Modal.getInstance(viewModal);
                if (vm) vm.hide();
            }
            if (editModal) {
                const em = new bootstrap.Modal(editModal);
                em.show();
            }
        });
    });
</script>
</body>
</html>
