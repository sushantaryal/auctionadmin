@extends('layouts.app')

@section('title', 'Edit Order')

@section('heading', 'Edit Order')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Edit Order</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <form action="{{ route('orders.update', $order->id) }}" method="post" id="editOrder">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="order_id">Order ID</label>
                        <input type="text" id="order_id" class="form-control" value="{{ $order->id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user">User</label>
                        <input type="text" id="user" class="form-control" value="{{ $order->user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="product">Product</label>
                        <input type="text" id="product" class="form-control" value="{{ $order->product->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" @if($order->status == 1) selected @endif>Order Placed</option>
                            <option value="2" @if($order->status == 2) selected @endif>Processing</option>
                            <option value="3" @if($order->status == 3) selected @endif>On Route</option>
                            <option value="4" @if($order->status == 4) selected @endif>Delivered</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
