@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Billing</li>
                  <li class="breadcrumb-item active" aria-current="page">Invoice</li>
                </ol>
              </nav>
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="" class="btn btn-primary text-white"><i class="mdi mdi-update"></i> Invoice</a>
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
                        <div class="d-md-flex">
                            <div>
                                <h4 class="card-title">Invoice</h4>
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
                                       
                                    </tbody>
                                </table>
                                <br>
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