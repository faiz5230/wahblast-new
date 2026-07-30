@extends('admin.messages.index')
@section('content-messages')
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal form-material mx-2" action="{{ route('admin.process-bulk-message') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group" id="autoswitch_device" style="display: none">
                        <div class="alert alert-warning" role="alert">
                            Note: Automatic + Autoswitch Device (Pastikan device aktif lebih dari 1)
                            <br>Setiap kali <span id="message_count"></span> pesan terkirim, pengiriman akan dilanjutkan oleh perangkat berikutnya. Jika perangkat terakhir sudah digunakan, pengiriman akan kembali ke perangkat pertama
                          </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Device Method</label>
                        <div class="col-md-12">
                            <select class="form-select shadow-none form-control-line @error('device_method') is-invalid @enderror" name="device_method" id="device_method">
                                <option value="">-- PILIH --</option>
                                <option value="selected_device" {{ old('device_method') == 'selected_device' ? 'selected' : '' }}>Selected Device</option>
                                <option value="autoswitch_device" {{ old('device_method') == 'autoswitch_device' ? 'selected' : '' }}>Automatic + Autoswitch Device</option>
                            </select>
                                @error('device_method')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group" id="device_id_group" style="display: none">
                        <label class="col-md-12">Device ID</label>
                        <div class="col-md-12">
                            <select class="form-select shadow-none form-control-line @error('waKey') is-invalid @enderror" name="waKey">
                                <option value="">-- PILIH --</option>
                                    @foreach ($devices as $device)
                                        <option value="{{ $device->id }}" {{ old('waKey') == $device->id ? 'selected' : '' }}>{{ $device->name }}</option>
                                    @endforeach
                            </select>
                                @error('waKey')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group" id="max_message" style="display: none">
                        <label class="col-md-12"> <i class="mdi mdi-message"></i> Pesan yang akan dikirim setiap device</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="10" value="{{ old('maxMessage') }}" id="maxMessageInput"
                                class="form-control form-control-line @error('maxMessage') is-invalid @enderror" name="maxMessage">
                                @error('maxMessage')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Message</label>
                        <div class="col-md-12">
                            <textarea name="text" id="text" type="text" placeholder="Isi Pesan disini..." class="form-control form-control-line @error('text') is-invalid @enderror" cols="30" rows="6" @error('text') is-invalid @enderror>{{ old('text') }}</textarea>
                                @error('text')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12"> <i class="mdi mdi-timer"></i> Delay pengiriman (detik)  <span style="color: red"><small>*Kosongkan jika tidak ingin ada delay</small></span></label>
                        <div class="col-md-12">
                            <input type="text" placeholder="10" value="{{ old('second') }}"
                                class="form-control form-control-line @error('second') is-invalid @enderror" name="second">
                                @error('second')
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
                                <option value="Text" {{ old('type') == 'Text' ? 'selected' : '' }}>Text</option>
                                <option value="Image" {{ old('type') == 'Image' ? 'selected' : '' }}>Image</option>
                                <option value="Video" {{ old('type') == 'Video' ? 'selected' : '' }}>Video</option>
                                <option value="PDF" {{ old('type') == 'PDF' ? 'selected' : '' }}>PDF/Dokumen</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label class="col-md-12">Image</span></label>
                        <div class="col-md-12">
                            <input type="file" placeholder="contoh : 6289519069792"
                                class="form-control form-control-line @error('number') is-invalid @enderror" name="url_file">
                                @error('number')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div> --}}
                    <div class="form-group files">
                        <label class="col-sm-12">File</label>
                        <div class="col-sm-12">
                            <input type="file" id="input-file-now" class="file-upload" name="url_file" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary text-white">Send Bulk Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to toggle the visibility of the device_id_group based on the selected option
        function toggleDeviceID() {
            var selectedMethod = $('#device_method').val();
            if (selectedMethod === 'selected_device') {
                $('#device_id_group').show();  
                $('#autoswitch_device').hide();  
                $('#max_message').hide();  
            } else if(selectedMethod === 'autoswitch_device') {
                $('#autoswitch_device').show();  
                $('#max_message').show();  
                $('#device_id_group').hide();  
            } else {
                $('#device_id_group').hide();  
                $('#autoswitch_device').hide();  
                $('#max_message').hide();  
            }
        }

        // Run the function on page load in case an option is pre-selected
        toggleDeviceID();

        // Run the function whenever the Device Method dropdown changes
        $('#device_method').change(function() {
            toggleDeviceID();
        });
        

        document.getElementById('maxMessageInput').addEventListener('input', function() {
            var messageCount = this.value || 10; // Jika input kosong, gunakan default 10
            document.getElementById('message_count').innerText = messageCount;
        });
    });
</script>
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