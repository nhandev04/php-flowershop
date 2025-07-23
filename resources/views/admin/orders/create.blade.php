@extends('layouts.admin')

@section('title', 'Tạo Đơn Hàng Mới')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tạo Đơn Hàng Mới</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-default btn-sm">
                                <i class="fas fa-arrow-left"></i> Quay lại danh sách đơn hàng
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Chức năng tạo đơn hàng đang được phát triển. Vui lòng quay lại sau.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection