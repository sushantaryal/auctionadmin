@extends('layouts.app')

@section('title', 'Categories')

@section('heading', 'Categories')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">New Category</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="post" id="addCategory">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Category name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <table class="table table-bordered table-striped responsive">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
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
    $(function() {
        $('#addCategory').validate({
            rules: {
                name: 'required'
            }
        });
    });

    $('.table').DataTable({
        columnDefs: [
            {responsivePriority: 1, targets: -1}
        ],
        order: [],
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: "{{ route('categories.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'serial', searchable: false, orderable: false},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', class: 'actions text-right', searchable: false, orderable: false}
        ]
    });
</script>
@endpush
