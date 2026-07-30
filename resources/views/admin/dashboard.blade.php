@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </nav>
            <h1 class="mb-0 fw-bold">Dashboard</h1> 
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
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <div class="row">
        {{-- <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Sales Summary</h4>
                            <h6 class="card-subtitle">Ample admin Vs Pixel admin</h6>
                        </div>
                        <div class="ms-auto d-flex no-block align-items-center">
                            <ul class="list-inline dl d-flex align-items-center m-r-15 m-b-0">
                                <li class="list-inline-item d-flex align-items-center text-info"><i class="fa fa-circle font-10 me-1"></i> Ample
                                </li>
                                <li class="list-inline-item d-flex align-items-center text-primary"><i class="fa fa-circle font-10 me-1"></i> Pixel
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="amp-pxl mt-4" style="height: 350px;">
                        <div class="chartist-tooltip"></div>
                    </div>
                </div>
            </div>
        </div> --}}
    <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <!-- title -->
                    <div class="d-md-flex">
                        <div>
                            <h4 class="card-title">Active Devices</h4>
                            <h5 class="card-subtitle">Active Device Now</h5>
                        </div>
                        {{-- <div class="ms-auto">
                            <div class="dl">
                                <select class="form-select shadow-none">
                                    <option value="0" selected>Monthly</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Weekly</option>
                                    <option value="3">Yearly</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                    <!-- title -->
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableID">
                            <thead>
                                <tr>
                                    {{-- <th class="border-top-0">ID Users</th> --}}
                                    <th class="border-top-0">No</th>
                                    <th class="border-top-0">Number</th>
                                    <th class="border-top-0">Name</th>
                                    <th class="border-top-0">Status</th>
                                </tr>
                            </thead>
                                <?php $i=1 ?>
                                @if (!empty($deviceStatus) && $deviceStatus->count())
                                    @foreach ($deviceStatus as $ds)
                                    <tbody>
                                        <tr>
                                            {{-- <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a
                                                            class="btn btn-circle d-flex btn-info text-white">EA</a>
                                                    </div>
                                                    <div class="">
                                                        <h4 class="m-b-0 font-16">Elite Admin</h4>
                                                    </div>
                                                </div>
                                            </td> --}}
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $ds->number }}</td>
                                            <td>{{ $ds->name }}</td>
                                            <td>
                                                <label class="badge bg-success">{{ $ds->status }}</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" style="text-align: center;">Tidak ada Device aktif!</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistic</h4>
                    <h6 class="card-subtitle">Statistic total</h6>
                    <div class="mt-5 pb-3 d-flex align-items-center">
                        <span class="btn btn-primary btn-circle d-flex align-items-center">
                            <i class="mdi mdi-laptop fs-4" ></i>
                        </span>
                        <a href="{{ route('admin.device') }}">
                            <div class="ms-3">
                                <h5 class="mb-0 fw-bold">Devices</h5>
                                <span class="text-muted fs-6">Total Device</span>
                            </div>
                        </a>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted"><a href="{{ route('admin.device') }}" style="text-decoration: none; color: #6C757D;">{{ $devices->count() }}</a></span>
                        </div>
                    </div>
                    <div class="py-3 d-flex align-items-center">
                        <span class="btn btn-secondary btn-circle d-flex align-items-center">
                            <i class="mdi mdi-laptop fs-4 text-white" ></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Active Devices</h5>
                            <span class="text-muted fs-6">Total Active Device</span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted">{{ $deviceStatus->count() }}</span>
                        </div>
                    </div>
                    <div class="py-3 d-flex align-items-center">
                        <span class="btn btn-danger btn-circle d-flex align-items-center">
                            <i class="mdi mdi-contacts fs-4 text-white" ></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Contacts</h5>
                            <span class="text-muted fs-6">Total Contact</span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted">{{ $contacts->count() }}</span>
                        </div>
                    </div>
                    <div class="py-3 d-flex align-items-center">
                        <span class="btn btn-success btn-circle d-flex align-items-center">
                            <i class="mdi mdi-comment-multiple-outline text-white fs-4" ></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Chats Send</h5>
                            <span class="text-muted fs-6">Total Chat Send</span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted">{{ $chats->count() }}</span>
                        </div>
                    </div>
                  

                    <div class="pt-3 d-flex align-items-center">
                        <span class="btn btn-warning btn-circle d-flex align-items-center">
                            <i class="mdi mdi-content-duplicate fs-4 text-white" ></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Group Chat Send</h5>
                            <span class="text-muted fs-6">Total Group Chat Send</span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-muted">{{ $groups->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Table -->
    <!-- ============================================================== -->
    {{-- <div class="row"> --}}
        <!-- column -->
        {{-- <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- title -->
                    <div class="d-md-flex">
                        <div>
                            <h4 class="card-title">Top Selling Products</h4>
                            <h5 class="card-subtitle">Overview of Top Selling Items</h5>
                        </div>
                        <div class="ms-auto">
                            <div class="dl">
                                <select class="form-select shadow-none">
                                    <option value="0" selected>Monthly</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Weekly</option>
                                    <option value="3">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- title -->
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover align-middle text-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-top-0">Products</th>
                                    <th class="border-top-0">License</th>
                                    <th class="border-top-0">Support Agent</th>
                                    <th class="border-top-0">Technology</th>
                                    <th class="border-top-0">Tickets</th>
                                    <th class="border-top-0">Sales</th>
                                    <th class="border-top-0">Earnings</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a
                                                    class="btn btn-circle d-flex btn-info text-white">EA</a>
                                            </div>
                                            <div class="">
                                                <h4 class="m-b-0 font-16">Elite Admin</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Single Use</td>
                                    <td>John Doe</td>
                                    <td>
                                        <label class="badge bg-danger">Angular</label>
                                    </td>
                                    <td>46</td>
                                    <td>356</td>
                                    <td>
                                        <h5 class="m-b-0">$2850.06</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a
                                                    class="btn btn-circle d-flex btn-orange text-white">MA</a>
                                            </div>
                                            <div class="">
                                                <h4 class="m-b-0 font-16">Monster Admin</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Single Use</td>
                                    <td>Venessa Fern</td>
                                    <td>
                                        <label class="badge bg-info">Vue Js</label>
                                    </td>
                                    <td>46</td>
                                    <td>356</td>
                                    <td>
                                        <h5 class="m-b-0">$2850.06</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a
                                                    class="btn btn-circle d-flex btn-success text-white">MP</a>
                                            </div>
                                            <div class="">
                                                <h4 class="m-b-0 font-16">Material Pro Admin</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Single Use</td>
                                    <td>John Doe</td>
                                    <td>
                                        <label class="badge bg-success">Bootstrap</label>
                                    </td>
                                    <td>46</td>
                                    <td>356</td>
                                    <td>
                                        <h5 class="m-b-0">$2850.06</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="m-r-10"><a
                                                    class="btn btn-circle d-flex btn-purple text-white">AA</a>
                                            </div>
                                            <div class="">
                                                <h4 class="m-b-0 font-16">Ample Admin</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Single Use</td>
                                    <td>John Doe</td>
                                    <td>
                                        <label class="badge bg-purple">React</label>
                                    </td>
                                    <td>46</td>
                                    <td>356</td>
                                    <td>
                                        <h5 class="m-b-0">$2850.06</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- ============================================================== -->
    <!-- Table -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
    {{-- <div class="row"> --}}
        <!-- column -->
        {{-- <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Comments</h4>
                </div>
                <div class="comment-widgets scrollable"> --}}
                    <!-- Comment Row -->
                    {{-- <div class="d-flex flex-row comment-row m-t-0">
                        <div class="p-2"><img src="{{ asset('assets/images/users/1.jpg')}}" alt="user" width="50"
                                class="rounded-circle"></div>
                        <div class="comment-text w-100">
                            <h6 class="font-medium">James Anderson</h6>
                            <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing
                                and type setting industry. </span>
                            <div class="comment-footer">
                                <span class="text-muted float-end">April 14, 2021</span> <span
                                    class="badge bg-primary">Pending</span> <span
                                    class="action-icons">
                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a>
                                </span>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Comment Row -->
                    {{-- <div class="d-flex flex-row comment-row">
                        <div class="p-2"><img src="{{ asset('assets/images/users/4.jpg')}}" alt="user" width="50"
                                class="rounded-circle"></div>
                        <div class="comment-text active w-100">
                            <h6 class="font-medium">Michael Jorden</h6>
                            <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing
                                and type setting industry. </span>
                            <div class="comment-footer ">
                                <span class="text-muted float-end">April 14, 2021</span>
                                <span class="badge bg-success">Approved</span>
                                <span class="action-icons active">
                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                    <a href="javascript:void(0)"><i class="icon-close"></i></a>
                                    <a href="javascript:void(0)"><i class="ti-heart text-danger"></i></a>
                                </span>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Comment Row -->
                    {{-- <div class="d-flex flex-row comment-row">
                        <div class="p-2"><img src="{{ asset('assets/images/users/5.jpg')}}" alt="user" width="50"
                                class="rounded-circle"></div>
                        <div class="comment-text w-100">
                            <h6 class="font-medium">Johnathan Doeting</h6>
                            <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing
                                and type setting industry. </span>
                            <div class="comment-footer">
                                <span class="text-muted float-end">April 14, 2021</span>
                                <span class="badge bg-danger">Rejected</span>
                                <span class="action-icons">
                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a>
                                </span>
                            </div>
                        </div>
                    </div> --}}
                {{-- </div>
            </div>
        </div> --}}
        <!-- column -->
        {{-- <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Temp Guide</h4>
                    <div class="d-flex align-items-center flex-row m-t-30">
                        <div class="display-5 text-info"><i class="wi wi-day-showers"></i>
                            <span>73<sup>°</sup></span></div>
                        <div class="m-l-10">
                            <h3 class="m-b-0">Saturday</h3><small>Ahmedabad, India</small>
                        </div>
                    </div>
                    <table class="table no-border mini-table m-t-20">
                        <tbody>
                            <tr>
                                <td class="text-muted">Wind</td>
                                <td class="font-medium">ESE 17 mph</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Humidity</td>
                                <td class="font-medium">83%</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pressure</td>
                                <td class="font-medium">28.56 in</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Cloud Cover</td>
                                <td class="font-medium">78%</td>
                            </tr>
                        </tbody>
                    </table>
                    <ul class="row list-style-none text-center m-t-30">
                        <li class="col-3">
                            <h4 class="text-info"><i class="wi wi-day-sunny"></i></h4>
                            <span class="d-block text-muted">09:30</span>
                            <h3 class="m-t-5">70<sup>°</sup></h3>
                        </li>
                        <li class="col-3">
                            <h4 class="text-info"><i class="wi wi-day-cloudy"></i></h4>
                            <span class="d-block text-muted">11:30</span>
                            <h3 class="m-t-5">72<sup>°</sup></h3>
                        </li>
                        <li class="col-3">
                            <h4 class="text-info"><i class="wi wi-day-hail"></i></h4>
                            <span class="d-block text-muted">13:30</span>
                            <h3 class="m-t-5">75<sup>°</sup></h3>
                        </li>
                        <li class="col-3">
                            <h4 class="text-info"><i class="wi wi-day-sprinkle"></i></h4>
                            <span class="d-block text-muted">15:30</span>
                            <h3 class="m-t-5">76<sup>°</sup></h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
</div>  
@stop