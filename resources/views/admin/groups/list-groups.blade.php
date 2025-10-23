@extends('admin.groups.index')
@section('content-groups')
<div class="page-breadcrumb" style="margin-top: -100px">
    <div class="row align-items-center">
        <div class="col-6">
           
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="{{ route('admin.send-group-message') }}" class="btn btn-primary text-white"><i class="mdi mdi-plus"></i> Send New Message to Group</a>
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
        <div class="card">
                <div class="card-body">
                    {{-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Group Chat Log</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Group Chats</button>
                        </li>
                        </ul> --}}
                        <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="d-md-flex">
                                <div>
                                    <h4 class="card-title">Group Chat Logs</h4>
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
                                        @if (!empty($groupChats) && $groupChats->count())
                                            @foreach ($groupChats as $groupChats)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $groupChats->number }}</td>
                                                    <td>{{ $groupChats->text }}</td>
                                                    @if($groupChats->status == 1)
                                                    <td><label for="status" class="badge bg-success">Success</label></td>
                                                    @else
                                                    <td><label for="status" class="badge bg-danger">Failed</label></td>
                                                    @endif
                                                    <td>{{ $groupChats->id_device }}</td>
                                                    <td>{{ $groupChats->type }}</td>
                                                    <td>
                                                    {{-- <a href="/admin/device/deleteDevice/{{ $groupChats->id }}" class="btn btn-danger"><i class="mdi mdi-delete"></i></a> --}}
                                                    {{-- <a href="" class="btn btn-warning"><i class="mdi mdi-border-color"></i></a> --}}
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
                            </div>         
                        </div>
                        {{-- <div class="tab-pane fade show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            @include('admin.chats.components.detailChat')
                        </div> --}}
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