@extends('backend.layout.master')
@section('title', 'EditGuest')
@section('b_menu-open', 'menu-open')
@section('mb_active', 'active')
@section('sp_active', 'active')
@section( 'content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{route('guest.index')}}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-circle-left"></i> Back
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Guest</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Guest</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('/guest/'.$guests->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <label>Room Type <span class="text-danger">*</span></label>
                        <input type="text" name="guest_name" value="{{$guests->guest_name}}" class="form-control" placeholder="Enter Name...">
                        @error('guest_name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <input type="text" name="guest_contact" value="{{$guests->guest_contact}}" class="form-control" placeholder="Enter Contact...">
                        @error('guest_contact')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>

@endsection
