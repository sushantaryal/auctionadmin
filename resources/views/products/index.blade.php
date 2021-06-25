@extends('layouts.app')

@section('title', 'List Product')

@section('heading', 'List Product')

@section('breadcrumbs')
    <li class="breadcrumb-item active">List Product</li>
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
                            <th>Name</th>
                            <th>Current Bid</th>
                            <th>Expire Date</th>
                            <th>Total Bids</th>
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
        select: {
            style: 'multi'
        },
        order: [],
        autoWidth: false,
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: "{{ route('products.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'serial', searchable: false, orderable: false},
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'act_expire', name: 'expire_at'},
            {data: 'bids_count', name: 'bids_count', class: 'actions', searchable: false, orderable: false},
            {data: 'action', name: 'action', class: 'actions text-right', searchable: false, orderable: false}
        ]
    });
</script>
@endpush
