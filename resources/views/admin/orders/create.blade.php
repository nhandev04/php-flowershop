@extends('layouts.admin')

@section('title', 'Create New Order')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create New Order</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-default btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Order List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Order creation form is under development. Please check back later.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection