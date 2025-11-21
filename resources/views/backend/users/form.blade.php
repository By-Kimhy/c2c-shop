@extends('backend.layout.master')
@section('title', $mode == 'create' ? 'Create User' : 'Edit User')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="m-0">{{ $mode == 'create' ? 'Create User' : 'Edit User' }}</h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">← Back to Users</a>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    {{-- show validation errors --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>There were some problems with your input:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- show single success / error flashes --}}
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if($mode=='create')
                    <form method="post" action="{{ route('admin.users.store') }}">
                        @else
                        <form method="post" action="{{ route('admin.users.update', $user->id) }}">
                            @method('PUT')
                            @endif
                            @csrf

                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Password {{ $mode=='edit' ? '(leave blank to keep current)' : '' }}</label>
                                <input name="password" type="password" class="form-control" {{ $mode=='create' ? 'required' : '' }}>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input name="password_confirmation" type="password" class="form-control" {{ $mode=='create' ? 'required' : '' }}>
                            </div>

                            <div class="form-group">
                                <label>Roles</label>
                                <select name="roles[]" class="form-control" multiple>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple roles.</small>
                            </div>

                            <button class="btn btn-primary" type="submit">{{ $mode=='create' ? 'Create' : 'Update' }}</button>
                        </form>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
