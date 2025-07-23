@extends('layouts.admin')

@section('title', 'Chỉnh sửa Banner')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Chỉnh sửa Banner</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}">Banner</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa Banner: {{ $banner->title }}</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-edit me-1"></i>
                Chỉnh sửa Banner
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Tiêu đề Banner <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" value="{{ old('title', $banner->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Thứ tự sắp xếp</label>
                                <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order"
                                    name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="4">{{ old('description', $banner->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Hình ảnh Banner</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                    name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kích thước khuyến nghị: 1920x800px. Dung lượng tối đa: 2MB. Để trống để giữ hình ảnh hiện tại.</div>
                                
                                @if($banner->image)
                                    <div class="mt-2">
                                        <label class="form-label">Hình ảnh hiện tại:</label><br>
                                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" 
                                             class="img-thumbnail" style="max-width: 300px; max-height: 150px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="link" class="form-label">Đường dẫn URL</label>
                                <input type="url" class="form-control @error('link') is-invalid @enderror" id="link"
                                    name="link" value="{{ old('link', $banner->link) }}" placeholder="https://example.com">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Kích hoạt (Hiển thị trên website)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary me-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">Cập nhật Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remove existing preview
                const existingPreview = document.getElementById('newImagePreview');
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                // Create preview
                const previewContainer = document.createElement('div');
                previewContainer.id = 'newImagePreview';
                previewContainer.className = 'mt-2';
                
                const label = document.createElement('label');
                label.className = 'form-label';
                label.textContent = 'Xem trước hình ảnh mới:';
                
                const preview = document.createElement('img');
                preview.src = e.target.result;
                preview.className = 'img-thumbnail d-block';
                preview.style.maxWidth = '300px';
                preview.style.maxHeight = '150px';
                
                previewContainer.appendChild(label);
                previewContainer.appendChild(preview);
                
                // Insert preview after the file input
                document.getElementById('image').parentNode.appendChild(previewContainer);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
