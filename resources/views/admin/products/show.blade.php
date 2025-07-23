@extends('layouts.admin')

@section('title', ' - Chi tiết sản phẩm')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Chi tiết sản phẩm</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
            <li class="breadcrumb-item active">Chi tiết: {{ $product->name }}</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-info-circle me-1"></i>
                Thông tin sản phẩm
                <div class="float-end">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-edit me-1"></i> Chỉnh sửa
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
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
                    <div class="col-md-4 text-center mb-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="img-fluid img-thumbnail" style="max-height: 300px;">
                        @else
                            <div class="border p-5 text-center text-muted">
                                <i class="fas fa-image fa-5x mb-3"></i>
                                <p>Không có hình ảnh</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">Mã sản phẩm</th>
                                    <td>{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $product->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Danh mục</th>
                                    <td>{{ $product->category ? $product->category->name : 'Không có' }}</td>
                                </tr>
                                <tr>
                                    <th>Thương hiệu</th>
                                    <td>{{ $product->brand ? $product->brand->name : 'Không có' }}</td>
                                </tr>
                                <tr>
                                    <th>Giá</th>
                                    <td>{{ number_format($product->price, 0, ',', '.') }}₫</td>
                                </tr>
                                <tr>
                                    <th>Giá khuyến mãi</th>
                                    <td>
                                        {{ $product->sale_price ? number_format($product->sale_price, 0, ',', '.') . '₫' : 'Không có' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tồn kho</th>
                                    <td>
                                        {{ $product->stock }}
                                        @if($product->stock <= 5)
                                            <span class="badge bg-danger">Sắp hết hàng</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Đang bán</span>
                                        @else
                                            <span class="badge bg-danger">Ngừng bán</span>
                                        @endif

                                        @if($product->is_featured)
                                            <span class="badge bg-info">Nổi bật</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo</th>
                                    <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày cập nhật</th>
                                    <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <h5>Mô tả sản phẩm</h5>
                    <div class="p-3 border rounded">
                        {{ $product->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection