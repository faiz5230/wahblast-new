@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.contacts') }}" style="text-decoration: none; color:#6C757D;">Contacts</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Contact</li>
                </ol>
              </nav>
            <h1 class="mb-0 fw-bold">Edit Contact</h1> 
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
                    <form class="form-horizontal form-material mx-2" action="{{ route('admin.contacts.updateContact', [$contact->id]) }}" method="post">
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="form-group">
                            <label class="col-md-12">Name</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="Masukkan nama Contact..."
                                    class="form-control form-control-line @error('name') is-invalid @enderror" name="name" value="{{ $contact->name }}">
                                    @error('name')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Number</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="6289519069792"
                                    class="form-control form-control-line @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ $contact->phone_number }}">
                                    @error('phone_number')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary text-white">Update Contact</button>
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
@stop