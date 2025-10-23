@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Devices</li>
                </ol>
              </nav>
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="{{ route('admin.device.addDevice') }}" class="btn btn-primary text-white"><i class="mdi mdi-plus"></i> Add Device</a>
            </div>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                    <div class="card-header" style="background: #fff;">
                        <div class="col">
                             <!-- title -->
                                    <h4 class="card-title" style="float: left;">Devices</h4>
                            <!-- title -->
                            <select class="form-select shadow-none" style="float: right; max-width: 150px; margin-right: 10px;">
                                <option value="0" selected>No Multi Device</option>
                                <option value="1">Multi Device</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableID">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">No</th>
                                        <th class="border-top-0">User</th>
                                        <th class="border-top-0">Number</th>
                                        <th class="border-top-0">Name</th>
                                        <th class="border-top-0">Description</th>
                                        <th class="border-top-0">Multi Device</th>
                                        <th class="border-top-0" style="text-align: center; ">Scan QR Code</th>
                                        <th class="border-top-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    @if (!empty($device) && $device->count())
                                        @foreach ($device as $devices)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td style="text-align: center;">
                                                    {{-- <div class="d-flex align-items-center">
                                                        <div class="m-r-10"><a
                                                                class="btn btn-circle d-flex btn-info text-white">EA</a>
                                                        </div>
                                                        <div class="">
                                                            <h4 class="m-b-0 font-16">{{ $devices->id_users }}</h4>
                                                        </div>
                                                    </div> --}}
                                                    {{ $devices->user->name }}
                                                </td>
                                                <td>{{ $devices->number }}</td>
                                                <td>{{ $devices->name }}</td>
                                                <td>{{ $devices->description }}</td>
                                                <td>{{ $devices->multidevice }}</td>
                                                <td>
                                                    {{-- badge for status connected --}}
                                                    @if ($devices->status == 'connected' )
                                                    <label class="badge bg-success">Connected</label>
                                                    <a href="/admin/device/disconnect/{{ $devices->id }}" class="badge btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus sesi {{ $devices->name }}')"><i class="mdi mdi-close"></i></a>
                                                    <a href="/admin/device/checkConnection/{{ $devices->id }}" class="badge btn-info"><i class="mdi mdi-refresh"></i></a>
                                                    @else
                                                    <a href="/admin/device/scan/{{ $devices->id }}" class="btn btn-primary" style="width: 100%;"><i class="mdi mdi-qrcode-scan"></i>&nbsp;Scan</a>
                                                    @endif
                                                </td>
                                                <td>
                                                <a href="#" class="btn btn-danger deleteDevice" data-id="{{ $devices->id }}"><i class="mdi mdi-delete text-white"></i></a>
                                                <a href="{{ route('admin.device.edit', $devices->id) }}" class="btn btn-warning"><i class="mdi mdi-border-color"></i></a>
                                                <a href="{{ route('admin.device.show', $devices->id) }}" class="btn btn-info"><i class="mdi mdi-eye text-white"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" style="text-align:center;">Data tidak ditemukan!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                    {{-- <h4 class="card-title">Device</h4>
                    <hr width="70px"> --}}
                {{-- <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Users</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Multi Device</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($device as $devices)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td>{{ $devices->id_users }}</td>
                                <td>{{ $devices->number }}</td>
                                <td>{{ $devices->name }}</td>
                                <td>{{ $devices->description }}</td>
                                <td>{{ $devices->multidevice }}</td>
                                <td><a href="/admin/device/scan/{{ $devices->name }}" class="btn btn-primary btn-sm"><i class="mdi mdi-qrcode-scan"></i>&nbsp;Scan</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div> --}}
            </div>
        </div>
    </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.deleteDevice').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const deviceId = this.getAttribute('data-id'); // Mendapatkan ID device dari data-id
            const deleteUrl = `/admin/device/deleteDevice/${deviceId}`; // URL untuk penghapusan device

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Device ini akan dihapus dan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX untuk menghapus device
                    $.ajax({
                        url: deleteUrl,
                        method: 'GET', // atau 'DELETE' sesuai kebutuhan
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                'Device berhasil dihapus.',
                                'success'
                            ).then(() => {
                                location.reload(); // Atau, hapus baris secara langsung tanpa reload halaman
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Gagal!',
                                'Gagal menghapus device.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@stop