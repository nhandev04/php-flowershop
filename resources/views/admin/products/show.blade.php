@extends('layouts.admin')

@section('title', ' - Product Details')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Product Details</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">Product Details: {{ $product->name }}</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle me-1"></i>
                Product Information
                <div class="float-end">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="img-fluid img-thumbnail" style="max-height: 300px;">
                        @else
                            <div class="border p-5 text-center text-muted">
                                <i class="fas fa-image fa-5x mb-3"></i>
                                <p>No image available</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">Product ID</th>
                                    <td>{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $product->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Brand</th>
                                    <td>{{ $product->brand ? $product->brand->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Sale Price</th>
                                    <td>{{ $product->sale_price ? '$' . number_format($product->sale_price, 2) : 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Stock</th>
                                    <td>
                                        {{ $product->stock }}
                                        @if($product->stock <= 5)
                                            <span class="badge bg-danger">Low Stock</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif

                                        @if($product->is_featured)
                                            <span class="badge bg-info">Featured</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $product->created_at->format('F j, Y, g:i a') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $product->updated_at->format('F j, Y, g:i a') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <h5>Product Description</h5>
                    <div class="p-3 border rounded">
                        {{ $product->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection