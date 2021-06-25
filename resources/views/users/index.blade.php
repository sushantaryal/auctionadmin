@extends('layouts.app')

@section('title', 'List User')

@section('heading', 'List User')

@section('breadcrumbs')
    <li class="breadcrumb-item active">List User</li>
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
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date Joined</th>
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
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'serial', searchable: false, orderable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', class: 'actions text-right', searchable: false, orderable: false}
        ]
    });
</script>
@endpush
