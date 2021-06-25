@extends('layouts.app')

@section('title', 'Edit User')

@section('heading', 'Edit User')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Edit User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card card-outline card-primary">
            <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data" id="editUser">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" data-placeholder="Select a Role">
                            <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                            <option value="user" @if($user->role == 'user') selected @endif>User</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#role').select2();

        $('#editUser').validate({
            rules: {
                role: 'required',
                name: 'required',
                email: {
                    required: true,
                    email: true
                }
            }
        });
    });
</script>
@endpush
