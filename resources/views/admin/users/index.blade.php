@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
              </nav>
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="{{ route('users.create') }}" class="btn btn-primary text-white"><i class="mdi mdi-plus"></i> Add User</a>
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
                                    <h4 class="card-title" style="float: left;">Users</h4>
                            <!-- title -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableID">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">No</th>
                                        <th class="border-top-0">Name</th>
                                        <th class="border-top-0">Email</th>
                                        <th class="border-top-0">Status</th>
                                        <th class="border-top-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    @if (!empty($users) && $users->count())
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    {{ $user->name }}
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                @if ($user->status == 1)
                                                    <td><span class="badge bg-success">Active</span></td>
                                                @else
                                                    <td><span class="badge bg-warning">Inactive</span></td>
                                                @endif
                                                <td>
                                                <a href="{{ route('user.destroy', [$user->id]) }}" class="btn btn-danger"><i class="mdi mdi-delete" onclick="return confirm('Apakah anda yakin ingin menghapus Device {{ $user->name }}')"></i></a>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="mdi mdi-border-color"></i></a>
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
@stop