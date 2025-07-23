@extends('layouts.admin')

@section('title', 'Chi tiết Banner')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Chi tiết Banner</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banner</a></li>
            <li class="breadcrumb-item active">Chi tiết Banner: {{ $banner->title }}</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle me-1"></i>
                Thông tin Banner
                <div class="float-end">
                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-edit me-1"></i> Chỉnh sửa
                    </a>
                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash me-1"></i> Xóa
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
                                <th>Tiêu đề:</th>
                                <td>{{ $banner->title }}</td>
                            </tr>
                            <tr>
                                <th>Mô tả:</th>
                                <td>{{ $banner->description ?: 'Không có mô tả' }}</td>
                            </tr>
                            <tr>
                                <th>Đường dẫn URL:</th>
                                <td>
                                    @if($banner->link)
                                        <a href="{{ $banner->link }}" target="_blank"
                                            class="text-primary">{{ $banner->link }}</a>
                                    @else
                                        Không có đường dẫn
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Thứ tự sắp xếp:</th>
                                <td>{{ $banner->sort_order }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>
                                    @if($banner->is_active)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-danger">Không hoạt động</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày tạo:</th>
                                <td>{{ $banner->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Cập nhật lần cuối:</th>
                                <td>{{ $banner->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @if($banner->image)
                            <div class="text-center">
                                <h5>Hình ảnh Banner</h5>
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
                                    class="img-fluid img-thumbnail" style="max-height: 400px;">
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-3x"></i>
                                <p class="mt-2">Chưa tải lên hình ảnh</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-eye me-1"></i>
                Xem trước
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
                                <a href="{{ $banner->link }}" class="btn btn-primary btn-lg">Xem thêm</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-image fa-3x"></i>
                        <p class="mt-2">Không có hình ảnh để xem trước</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection