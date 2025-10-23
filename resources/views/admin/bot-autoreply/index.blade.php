@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Bot Auto Reply</li>
                </ol>
              </nav>
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="{{ route('admin.bot-auto-reply.create') }}" class="btn btn-primary text-white"><i class="mdi mdi-plus"></i> Create Bot</a>
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
                                <h4 class="card-title">Bot Auto Reply</h4>
                                <hr width="60px">
                            </div>
                        </div>
                        <!-- title -->
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableID">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="border-top-0">Title</th>
                                        <th class="border-top-0">Device</th>
                                        <th class="border-top-0">Default Message</th>
                                        <th class="border-top-0">Status</th>
                                        <th class="border-top-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    @if (!empty($bots) && $bots->count())
                                        @foreach ($bots as $bot)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $bot->title }}</td>
                                                <td>{{ $bot->device->number }}</td>
                                                <td>{{ $bot->default_message }}</td>
                                                <td>{{ $bot->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                <td class="text-center">
                                                <a href="{{ route('admin.delete-bot-auto-reply', $bot->id) }}" class="btn btn-danger text-white"><i class="mdi mdi-delete"></i></a>
                                                <a href="{{ route('admin.bot-auto-reply.edit-bot-auto-reply', $bot->id) }}" class="btn btn-warning"><i class="mdi mdi-border-color"></i></a>
                                                <a href="{{ route('admin.bot-auto-reply.edit-auto-reply', $bot->id) }}" class="btn btn-info text-white"><i class="mdi mdi-tune"></i> Edit Auto Reply Flow</a>
                                                {{-- <a href="" class="btn btn-info"><i class="mdi mdi-eye"></i></a> --}}
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