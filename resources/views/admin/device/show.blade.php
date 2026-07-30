@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-header" style="background-color: #fff;">
                    <h2>Detail Device</h2>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                        <div class="text">
                            <span style="width: 50px;">Device:</span> &nbsp;<span> {{ $device->name }}</span>
                        </div>
                        <br>
                        <div class="text">
                            <span style="width: 50px;">WA KEY:</span> &nbsp;<span><span class="entitas">{{ $device->id }}&nbsp;&nbsp;<i class="mdi mdi-content-copy" style="text-decoration: none; color:black;"></i></span>
                        </div>
                        <br>
                        <div class="text">
                            @if ($device->status=='connected')
                            <span style="width: 50px;">Status:</span> &nbsp; &nbsp;<span class="badge bg-success">{{ $device->status }}</span>
                            @else
                            <span style="width: 50px;">Status:</span> &nbsp; &nbsp;<span class="badge bg-danger">{{ $device->status }}</span>
                            @endif
                        </div>
                        <br>
                        <div class="text">
                            <span style="width: 50px;">Device:</span> &nbsp;</span> &nbsp;<span class="badge bg-primary">{{ $device->multidevice }}</span>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <!-- Column -->
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