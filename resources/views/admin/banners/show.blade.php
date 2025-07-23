@extends('layouts.admin')

@section('title', 'Banner Details')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Banner Details</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banners</a></li>
            <li class="breadcrumb-item active">Banner Details: {{ $banner->title }}</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle me-1"></i>
                Banner Information
                <div class="float-end">
                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure you want to delete this banner?');">
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
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">ID:</th>
                                <td>{{ $banner->id }}</td>
                            </tr>
                            <tr>
                                <th>Title:</th>
                                <td>{{ $banner->title }}</td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td>{{ $banner->description ?: 'No description' }}</td>
                            </tr>
                            <tr>
                                <th>Link URL:</th>
                                <td>
                                    @if($banner->link)
                                        <a href="{{ $banner->link }}" target="_blank"
                                            class="text-primary">{{ $banner->link }}</a>
                                    @else
                                        No link
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Sort Order:</th>
                                <td>{{ $banner->sort_order }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if($banner->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $banner->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Updated:</th>
                                <td>{{ $banner->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @if($banner->image)
                            <div class="text-center">
                                <h5>Banner Image</h5>
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
                                    class="img-fluid img-thumbnail" style="max-height: 400px;">
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-3x"></i>
                                <p class="mt-2">No image uploaded</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-eye me-1"></i>
                Preview
            </div>
            <div class="card-body">
                @if($banner->image)
                    <div class="position-relative"
                        style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-100 h-100"
                            style="object-fit: cover;">
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <h2 class="display-4 fw-bold mb-3">{{ $banner->title }}</h2>
                            @if($banner->description)
                                <p class="lead mb-3">{{ $banner->description }}</p>
                            @endif
                            @if($banner->link)
                                <a href="{{ $banner->link }}" class="btn btn-primary btn-lg">Learn More</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-image fa-3x"></i>
                        <p class="mt-2">No image to preview</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection