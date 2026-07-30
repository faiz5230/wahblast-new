@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Chats</li>
                </ol>
              </nav>
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="{{ route('admin.chats.addChat') }}" class="btn btn-primary text-white"><i class="mdi mdi-plus"></i> Send Chat</a>
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
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Chats Log</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Chats</button>
                            </li>
                          </ul>
                          <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="d-md-flex">
                                    <div>
                                        <h4 class="card-title">Chats</h4>
                                        <hr width="60px">
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive">
                                    <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableID">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th class="border-top-0">Number</th>
                                                <th class="border-top-0">Text</th>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">Device ID</th>
                                                <th class="border-top-0">Type</th>
                                                <th class="border-top-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; ?>
                                            @if (!empty($chats) && $chats->count())
                                                @foreach ($chats as $chats)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $chats->number }}</td>
                                                        <td>{{ $chats->text }}</td>
                                                        @if($chats->status == 1)
                                                        <td><label for="status" class="badge bg-success">Success</label></td>
                                                        @else
                                                        <td><label for="status" class="badge bg-danger">Failed</label></td>
                                                        @endif
                                                        <td>{{ $chats->id_device }}</td>
                                                        <td>{{ $chats->type }}</td>
                                                        <td>
                                                        {{-- <a href="/admin/device/deleteDevice/{{ $chats->id }}" class="btn btn-danger"><i class="mdi mdi-delete"></i></a>
                                                        <a href="" class="btn btn-warning"><i class="mdi mdi-border-color"></i></a> --}}
                                                        <a href="" class="btn btn-info"><i class="mdi mdi-eye"></i></a>
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
                                    <div class="col">
                                        <nav aria-label="..." style="float: left;">
                                            <ul class="pagination">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                            </ul>
                                        </nav>

                                    </div>
                                </div>         
                            </div>
                            <div class="tab-pane fade show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                @include('admin.chats.components.detailChat')
                            </div>
                          </div>
                    </div>

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