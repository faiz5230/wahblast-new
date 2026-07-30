@extends('admin.groups.index')
@section('content-groups')
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
                            <h4 class="card-title">Get list group</h4>
                            <hr width="100px">
                        </div>
                    </div>
                    <!-- title -->
                    <form class="form-horizontal form-material mx-2" action="{{ route('admin.process-get-list-group') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-12">Device ID</label>
                            <div class="col-md-12">
                                <select class="form-select shadow-none form-control-line @error('waKey') is-invalid @enderror" name="waKey">
                                    <option value="">-- PILIH --</option>
                                        @foreach ($devices as $device)
                                            <option value="{{ $device->id }}">{{ $device->name }}</option>
                                        @endforeach
                                </select>
                                    @error('waKey')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary text-white">Get group</button>
                            </div>
                        </div>
                    </form>
                </div>

        </div>
    </div>
    <div class="row">
        <div class="card">
                <div class="card-body">
                        <div class="d-md-flex">
                        <div>
                            <h4 class="card-title">List group</h4>
                            <hr width="100px">
                        </div>
                    </div>
                    <!-- title -->
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableID">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="border-top-0">Group Id</th>
                                    <th class="border-top-0">Group name</th>
                                    <th class="border-top-0">Device</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                @if (!empty($getListGroups) && $getListGroups->count())
                                    @foreach ($getListGroups as $group)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ Str::replace('@g.us', '', $group->group_id) }}</td>
                                            <td>{{ $group->group_name ? $group->group_name : 'Judul tidak didapatkan' }}</td>
                                            <td>{{ $group->devices->name }}</td>
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