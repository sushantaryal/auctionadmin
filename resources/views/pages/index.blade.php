@extends('layouts.app')

@section('title', 'List Page')

@section('heading', 'List Page')

@section('breadcrumbs')
    <li class="breadcrumb-item active">List Page</li>
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
                            <th>Title</th>
                            <th>Published</th>
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
        ajax: "{{ route('pages.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'serial', searchable: false, orderable: false},
            {data: 'title', name: 'title'},
            {data: 'act_published', name: 'published'},
            {data: 'action', name: 'action', class: 'actions text-right', searchable: false, orderable: false}
        ]
    });
</script>
@endpush
