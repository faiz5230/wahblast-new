@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30"> <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                            class="rounded-circle" width="150" />
                        <h4 class="card-title m-t-10">{{ $profile->email }}</h4>
                        <h6 class="card-subtitle">{{ $profile->name }}</h6>
                        <div class="text">
                            <span style="width: 50px;">ACCOUNT KEY:</span> &nbsp;<span><span class="entitas">{{ $profile->id }}&nbsp;&nbsp;<i class="mdi mdi-content-copy" style="text-decoration: none; color:black;"></i></span>
                        </div>
                    </center>
                </div>
                <div>
                    <hr>
                </div>
                <form action="{{ route('admin.profile.update', $profile->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="card-body"> 
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $profile->name }}">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $profile->email }}">
                        <br>
                        <button class="btn btn-primary"><i class=""></i>Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .entitas{
        display: inline-block; */
        word-break: break-all;
        border: 1px solid rgb(230, 230, 230);
        padding: 6px 10px;
        border-radius: 3px;
        font-size: 12px;
        color: rgb(40, 40, 40);
        background-color: rgb(248, 248, 248);
        margin: 5px 0px 15px;
    }
</style>
@endsection