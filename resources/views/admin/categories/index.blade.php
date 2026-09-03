@extends('layouts.admin')
@section('title','Categories')
@section('content')
<div class="admin-page-header"><div><h1 class="admin-page-title"><i class="fas fa-tags"></i>Categories</h1><p class="admin-page-description">Categories are sourced directly from the existing product catalogue.</p></div></div><div class="admin-card"><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Category</th><th>Products</th><th>Availability</th></tr></thead><tbody>@forelse($categories as $category)<tr><td>{{ $category }}</td><td>{{ \App\Models\Product::where('category',$category)->count() }}</td><td><span class="admin-badge admin-badge-success">In catalogue</span></td></tr>@empty<tr><td colspan="3"><div class="admin-empty"><i class="fas fa-tags"></i>No product categories exist yet.</div></td></tr>@endforelse</tbody></table></div></div>
@endsection
