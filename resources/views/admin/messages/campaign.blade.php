@extends('admin.messages.index')
@section('content-messages')
<style>
    @media (min-width: 992px) {
        .breadcumb-custom {
            margin-top: -100px
        }
    }
</style>
<div class="page-breadcrumb breadcumb-custom">
    <div class="row align-items-center">
        <div class="col-6">
            {{-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Chats</li>
                </ol>
              </nav> --}}
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="{{ route('admin.add-campaign') }}" class="btn btn-primary text-white"><i class="mdi mdi-pencil-box-outline"></i> Create Campaign</a>
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
                        <div class="d-md-flex">
                        <div>
                            <h4 class="card-title">Campaign</h4>
                            <hr width="100px">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                @if (!empty($campaigns) && $campaigns->count())
                                    @foreach ($campaigns as $campaign)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $campaign->number }}</td>
                                            <td>{{ $campaign->text }}</td>
                                            @if($campaign->status == 1)
                                            <td><label for="status" class="badge bg-success">Success</label></td>
                                            @else
                                            <td><label for="status" class="badge bg-danger">Failed</label></td>
                                            @endif
                                            <td>{{ $campaign->id_device }}</td>
                                            <td>{{ $campaign->type }}</td>
                                            {{-- <td> --}}
                                            {{-- <a href="/admin/device/deleteDevice/{{ $chats->id }}" class="btn btn-danger"><i class="mdi mdi-delete"></i></a>
                                            <a href="" class="btn btn-warning"><i class="mdi mdi-border-color"></i></a> --}}
                                            {{-- <a href="" class="btn btn-info"><i class="mdi mdi-eye"></i></a>
                                            </td> --}}
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