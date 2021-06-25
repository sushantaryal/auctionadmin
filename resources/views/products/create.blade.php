@extends('layouts.app')

@section('title', 'Add Product')

@section('heading', 'Add Product')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Add Product</li>
@endsection

@section('content')
<form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" id="addProduct">
    @csrf
    <div class="row">
        <div class="col-md-7">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="form-group">
                        <label for="category_id">Category <span style="color:red">*</span></label>
                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" data-placeholder="Select a category">
                            <option value=""></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name <span style="color:red">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Product name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="initial_price">Initial Price <span style="color:red">*</span></label>
                        <input type="number" name="initial_price" id="initial_price" class="form-control @error('initial_price') is-invalid @enderror" placeholder="Initial price" value="{{ old('initial_price') }}">
                        @error('initial_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="expire_at">Expiry Date <span style="color:red">*</span></label>
                        <input type="text" name="expire_at" id="expire_at" class="form-control @error('expire_at') is-invalid @enderror" placeholder="Expiry Date" value="{{ old('expire_at') }}">
                        @error('expire_at')
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
                </div>
            </div>

            <button type="submit" class="btn btn-success float-right" disabled>Add Product</button>
        </div>

        <div class="col-md-5">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <div class="form-group">
                        <label for="closing_price">Closing Price / Product Value <span style="color:red">*</span></label>
                        <input type="number" name="closing_price" id="closing_price" class="form-control @error('closing_price') is-invalid @enderror" placeholder="Closing price" value="{{ old('closing_price') }}">
                        @error('closing_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bid_credit">Per Bid Credit <span style="color:red">*</span></label>
                        <input type="number" name="bid_credit" id="bid_credit" class="form-control @error('bid_credit') is-invalid @enderror" placeholder="Per Bid Credit" value="{{ old('bid_credit') }}">
                        @error('bid_credit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="min_increment">Minimum Value Increment <span style="color:red">*</span></label>
                        <input type="number" name="min_increment" id="min_increment" class="form-control @error('min_increment') is-invalid @enderror" placeholder="Minimum Value Increment" value="{{ old('min_increment') }}">
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
            startDate: moment().endOf('hour'),
            locale: {
                format: 'M/DD/YYYY hh:mm:ss A'
            }
        });

        var form = $('#addProduct');
        form.validate({
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
                'image[]': 'required'
            }
        });

        $('input, select, input[type="file"]').on('blur, keydown, change', function (e) {
            if (form.valid()) {
                $('button[type="submit"]').attr('disabled', false);
            } else {
                $('button[type="submit"]').attr('disabled', true);
            }
        });
    });

    $("#upload-photo").fileinput({
        theme: "fas",
        browseLabel: 'Browse',
        removeClass: 'btn btn-danger',
        autoOrientImage: false,
        showCancel: false,
        showUpload: false,
        maxFileCount: 4,
        allowedFileTypes: ["image"]
    });
</script>
@endpush
