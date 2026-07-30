@extends('admin.groups.index')
@section('content-groups')
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal form-material mx-2" action="{{ route('admin.process-schedule-group-message') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-12">Device ID</label>
                        <div class="col-md-12">
                            <select class="form-select shadow-none form-control-line @error('waKey') is-invalid @enderror" name="waKey">
                                <option value="">-- PILIH --</option>
                                    @foreach ($devices as $device)
                                        <option value="{{ $device->id }}">{{ $device->name }}</option>
                                    @endforeach
                            </select>
                                @error('waKey')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Group Id</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="masukan group id"
                                class="form-control form-control-line @error('number') is-invalid @enderror" name="number" data-role="tagsinput">
                                @error('number')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="schedule-date">Tanggal</label>
                            <input type="date" id="schedule-date"
                                class="form-control form-control-line @error('schedule') is-invalid @enderror" name="schedule_date">
                            @error('schedule_date')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <div class="col-md-6">
                            <label for="schedule-time">Waktu</label>
                            <input type="time" id="schedule-time"
                                class="form-control form-control-line @error('schedule') is-invalid @enderror" name="schedule_time">
                            @error('schedule_time')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Message</label>
                        <div class="col-md-12">
                            <textarea name="text" id="text" type="text" placeholder="Isi Pesan disini..." class="form-control form-control-line @error('text') is-invalid @enderror" cols="30" rows="6" @error('text') is-invalid @enderror></textarea>
                                @error('text')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12">Type</label>
                        <div class="col-sm-12">
                            <select class="form-select shadow-none form-control-line @error('type') is-invalid @enderror" name="type">
                                <option value="">-- PILIH --</option>
                                <option value="Text">Text</option>
                                <option value="Image">Image</option>
                                <option value="Video">Video</option>
                                <option value="PDF">PDF/Dokumen</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group files">
                        <label class="col-sm-12">File</label>
                        <div class="col-sm-12">
                            <input type="file" id="input-file-now" class="file-upload" name="url_file" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary text-white">Send Schedule Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    padding: 120px 0px 85px 35%;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    height: 56px;
    content: "";
    background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.color input{ background-color:#f1f1f1;}
.files:before {
    position: absolute;
    bottom: 10px;
    left: 0;  pointer-events: none;
    width: 100%;
    right: 0;
    height: 57px;
    content: " or drag it here. ";
    display: block;
    margin: 0 auto;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
    text-align: center;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('tagsinput-assets/css/tagsinput.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script src="{{ asset('tagsinput-assets/js/tagsinput.js') }}"></script>
@endsection