@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.device') }}" style="text-decoration: none; color:#6C757D;">Devices</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Create Bot</li>
                </ol>
              </nav>
            <h1 class="mb-0 fw-bold">Create Bot</h1> 
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7" style="max-width: 500px">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal form-material mx-2" action="{{ route('admin.process-bot-auto-reply') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-12">Bot Name</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="Masukkan nama bot..."
                                    class="form-control form-control-line @error('title') is-invalid @enderror" name="title">
                                    @error('title')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Default Message</label>
                            <div class="col-md-12">
                                <textarea name="default_message" id="default_message" type="text" placeholder="Isi Pesan disini..." class="form-control form-control-line @error('default_message') is-invalid @enderror" cols="30" rows="6" @error('default_message') is-invalid @enderror>{{ old('default_message') }}</textarea>
                                    @error('default_message')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Device ID</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none form-control-line @error('waKey') is-invalid @enderror" name="waKey">
                                    <option value="">-- PILIH --</option>
                                        @foreach ($devices as $device)
                                            <option value="{{ $device->id }}">{{ $device->name }}</option>
                                        @endforeach
                                </select>
                                    @error('id_device')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Status</label>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status">
                                    <label class="form-check-label" for="flexSwitchCheckDefault" id="switchLabel">Inactive</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="multidevice" name="multidevice" value="YES">
                        {{-- <div class="form-group">
                            <label class="col-sm-12">Multi Device</label>
                            <div class="col-sm-12">
                                <select class="form-select shadow-none form-control-line @error('multidevice') is-invalid @enderror" name="multidevice">
                                    <option value="">-- PILIH --</option>
                                    <option value="YES">Ya</option>
                                    <option value="NO">Tidak</option>
                                </select>
                                @error('multidevice')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary text-white">Add Device</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    <!-- Row -->
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<script>
    const toggleSwitch = document.getElementById('flexSwitchCheckDefault');
    const switchLabel = document.getElementById('switchLabel');

    toggleSwitch.addEventListener('change', function() {
        if (this.checked) {
            switchLabel.textContent = 'Active';
        } else {
            switchLabel.textContent = 'Inactive';
        }
    });
</script>
@stop