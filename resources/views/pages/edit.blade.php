@extends('layouts.app')

@section('title', 'Edit Page')

@section('heading', 'Edit Page')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Edit Page</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card card-outline card-primary">
            <form action="{{ route('pages.update', $page->id) }}" method="post" id="editPage">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Page title" value="{{ old('title', $page->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control wysiwyg" cols="30" rows="10">{{ old('description', $page->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="published">Published</label>
                        <div class="custom-control custom-switch custom-switch-lg">
                            <input type="checkbox" name="published" class="custom-control-input" id="published" @if($page->published) checked @endif>
                            <label class="custom-control-label" for="published"></label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Page</button>
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
        $('#editPage').validate({
            rules: {
                title: 'required'
            }
        });
    });
</script>
@endpush
