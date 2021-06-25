@extends('layouts.app')

@section('title', 'List Order')

@section('heading', 'List Order')

@section('breadcrumbs')
    <li class="breadcrumb-item active">List Order</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <table class="table table-bordered table-striped responsive">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Ordered At</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var table = $('.table').DataTable({
        columnDefs: [
            {responsivePriority: 1, targets: -1}
        ],
        order: [],
        autoWidth: false,
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('orders.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'serial', searchable: false, orderable: false},
            {data: 'user.name', name: 'user.name'},
            {data: 'product.name', name: 'product.name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status_text', name: 'status'},
            {data: 'action', name: 'action', class: 'actions text-right', searchable: false, orderable: false}
        ]
    });
</script>
@endpush
