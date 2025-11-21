@extends('backend.layout.master')
@section('title', 'CreateRoom')
@section('r_menu-open', 'menu-open')
@section('mr_active', 'active')
@section('r_active', 'active')
@section( 'content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{route('room.index')}}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-circle-left"></i> Back
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create Room</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Room</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{url('/room')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Room Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Enter Name...">
                        @error('name')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Room Type</label>
                        <select class="form-control" name="roomType_id">
                            <option selected>--- Choose RoomType ---</option>
                            @foreach($roomtypes as $value)
                                <option value="{{$value->id}}">{{$value->roomType_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="room_status">
                            <option value="1">Free</option>
                            <option value="0">Booked</option>
                        </select>
                    </div>

                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>

@endsection
