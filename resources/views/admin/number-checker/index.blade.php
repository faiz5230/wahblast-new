@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Whatsapp Number Checker</li>
                </ol>
              </nav>
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
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex">
                            <div>
                                <h4 class="card-title">Whatsapp Number Checker</h4>
                                <hr width="60px">
                            </div>
                        </div>
                        <!-- title -->
                        <form class="form-horizontal form-material mx-2" action="{{ route('admin.process-number-checker') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-md-12">Number</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="contoh : 089519069792"
                                        class="form-control form-control-line @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" name="phone_number">
                                        @error('phone_number')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary text-white float-end">Check Number</button>
                                </div>
                            </div>
                        </form>
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