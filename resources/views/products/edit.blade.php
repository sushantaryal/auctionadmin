@extends('layouts.app')

@section('title', 'Edit Product')

@section('heading', 'Edit Product')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('content')
<form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data" id="editProduct">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-7">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" data-placeholder="Select a category">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if($product->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Product name" value="{{ old('name', $product->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="initial_price">Initial Price</label>
                        <input type="number" name="initial_price" id="initial_price" class="form-control @error('initial_price') is-invalid @enderror" placeholder="Initial price" value="{{ old('initial_price', $product->initial_price) }}">
                        @error('initial_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="expire_at">Expiry Date</label>
                        <input type="text" name="expire_at" id="expire_at" class="form-control @error('expire_at') is-invalid @enderror" placeholder="Expiry Date" value="{{ old('expire_at', $product->expire_at->format('m/d/Y h:i:s A')) }}">
                        @error('expire_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control wysiwyg" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success float-right">Update Product</button>
        </div>

        <div class="col-md-5">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="form-group">
                        <label for="closing_price">Closing Price / Product Value</label>
                        <input type="number" name="closing_price" id="closing_price" class="form-control @error('closing_price') is-invalid @enderror" placeholder="Closing price" value="{{ old('closing_price', $product->closing_price) }}">
                        @error('closing_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bid_credit">Per Bid Credit</label>
                        <input type="number" name="bid_credit" id="bid_credit" class="form-control @error('bid_credit') is-invalid @enderror" placeholder="Per Bid Credit" value="{{ old('bid_credit', $product->bid_credit) }}">
                        @error('bid_credit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="min_increment">Minimum Value Increment</label>
                        <input type="number" name="min_increment" id="min_increment" class="form-control @error('min_increment') is-invalid @enderror" placeholder="Minimum Value Increment" value="{{ old('min_increment', $product->min_increment) }}">
                        @error('min_increment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <input type="file" name="image[]" id="upload-photo" accept="image/*" multiple>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ mix('js/editor.js') }}"></script>
<script>
    $(function() {
        $('#category_id').select2();
        $('#expire_at').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            locale: {
                format: 'M/DD/YYYY hh:mm:ss A'
            }
        });

        $('#editProduct').validate({
            rules: {
                category_id: 'required',
                name: 'required',
                expire_at: 'required',
                initial_price: {
                    required: true,
                    number: true,
                    min: 0.01
                },
                closing_price: {
                    required: true,
                    number: true,
                    min: 0.01
                },
                bid_credit: {
                    required: true,
                    number: true,
                    min: 0.01
                },
                min_increment: {
                    required: true,
                    number: true,
                    min: 0.01
                },
                @if($product->photos->count() <= 0)
                    'image[]': 'required'
                @endif
            }
        });
    });

    $("#upload-photo").fileinput({
            theme: "fas",
            browseLabel: 'Browse',
            removeClass: 'btn btn-danger',
            overwriteInitial: false,
            validateInitialCount: true,
            autoOrientImage: false,
            showCancel: false,
            showRemove: false,
            showUpload: false,
            allowedFileTypes: ["image"],
            initialPreview: [
                @php($photos = $product->parent ? $product->parent->photos : $product->photos)
                @foreach($photos as $photo)
                    "<img class='kv-preview-data file-preview-image' src='{{ filter_var($photo->path, FILTER_VALIDATE_URL) ? $photo->path : Storage::url($photo->path) }}'>",
                @endforeach
            ],
            initialPreviewConfig: [
                @php($photos = $product->parent ? $product->parent->photos : $product->photos)
                @foreach($photos as $photo)
                    {size: {{ Storage::exists($photo->path) ? Storage::size($photo->path) : 0 }}, url: "{{ route('products.photo.destroy', $photo->id) }}", key: {{ $loop->iteration }}},
                @endforeach
            ]
        }).on('filebeforedelete', function() {
            return new Promise(function(resolve, reject) {
                bootbox.confirm({
                    title: "Delete",
                    message: 'Are you sure you want to delete this image?',
                    centerVertical: true,
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancel'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Delete',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            resolve();
                        }
                    }
                });
            });
        });
</script>
@endpush
