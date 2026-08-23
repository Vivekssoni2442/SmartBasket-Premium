<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller verification requests · SmartBasket Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-5">
        <h1 class="h3 mb-4">Seller verification requests</h1>
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Application</th><th>Seller</th><th>Shop</th><th>Status</th><th>Submitted</th><th></th></tr></thead>
                    <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td>#{{ $application->id }}</td>
                            <td>{{ $application->seller_name }}<br><small class="text-muted">{{ $application->email }}</small></td>
                            <td>{{ $application->shop_name }}</td>
                            <td><span class="badge text-bg-secondary">{{ str_replace('_', ' ', $application->verification_status) }}</span></td>
                            <td>{{ $application->verification_submitted_at?->format('d M Y, H:i') ?? '—' }}</td>
                            <td><a class="btn btn-sm btn-primary" href="{{ route('admin.seller-verifications.show', $application) }}">Review</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No seller verification requests yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $applications->links() }}</div>
    </main>
</body>
</html>
