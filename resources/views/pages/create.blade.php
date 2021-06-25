@extends('layouts.app')

@section('title', 'Add Page')

@section('heading', 'Add Page')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Add Page</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card card-outline card-primary">
            <form action="{{ route('pages.store') }}" method="post" id="addPage">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Page title" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control wysiwyg" cols="30" rows="10">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="published">Published</label>
                        <div class="custom-control custom-switch custom-switch-lg">
                            <input type="checkbox" name="published" class="custom-control-input" id="published" checked>
                            <label class="custom-control-label" for="published"></label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add Page</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ mix('js/editor.js') }}"></script>
<script>
    $(function() {
        $('#addPage').validate({
            rules: {
                title: 'required'
            }
        });
    });
</script>
@endpush
