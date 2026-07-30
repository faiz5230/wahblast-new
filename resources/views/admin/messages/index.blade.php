@extends('admin.layouts.master')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<style>
    .color-sidebar {
        color: #757575;
    }

    .selected .color-sidebar {
        color: #ffffff;
    }

</style>
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Messages</li>
                    @if (Request::path() == 'admin/messages/new-message')
                        <li class="breadcrumb-item active" aria-current="page">New Message</li>
                    @elseif (Request::path() == 'admin/messages/history-messages')
                        <li class="breadcrumb-item active" aria-current="page">History Messages</li>
                    @elseif (Request::path() == 'admin/messages/send-bulk-message')
                        <li class="breadcrumb-item active" aria-current="page">Send Bulk Message</li>
                    @elseif (Request::path() == 'admin/messages/schedule-message' || Request::is('admin/messages/send-schedule-message'))
                        <li class="breadcrumb-item active" aria-current="page">Schedule Message</li>
                    @elseif (Request::path() == 'admin/messages/campaign' || Request::is('admin/messages/send-campaign'))
                        <li class="breadcrumb-item active" aria-current="page">Campaign</li>
                    @endif

                    @if (Request::is('admin/messages/send-schedule-message'))
                        <li class="breadcrumb-item active" aria-current="page">Send Schedule Message</li>
                    @elseif (Request::is('admin/messages/send-campaign'))
                        <li class="breadcrumb-item active" aria-current="page">Send Campaign</li>
                    @endif
                </ol>
                </nav>
            {{-- <h1 class="mb-0 fw-bold">Dashboard</h1>  --}}
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
        <div class="col-lg-3">
            <div class="card" style="height: auto">
                <div style="margin-top:10px; margin-left: 20px;">
                    <b>Messages</b>
                </div>
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.messages') }}" aria-expanded="false"><i class="mdi mdi-pencil-box-outline" style="color: #757575"></i><span
                                        class="color-sidebar">New Message</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.send-bulk-message') }}" aria-expanded="false"><i class="mdi mdi-email-fast-outline" style="color: #757575"></i><span
                                    class="color-sidebar">New Bulk Message</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.history-messages') }}" aria-expanded="false"><i class="mdi mdi-clock" style="color: #757575"></i><span
                                        class="color-sidebar">History Message</span></a></li>
                            <li class="sidebar-item {{ Request::is('admin/messages/send-schedule-message') || Request::is('admin/messages/edit-schedule-message/*') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.schedule-message') }}" aria-expanded="false"><i class="mdi mdi-clock-edit-outline" style="color: #757575"></i><span
                                    class="color-sidebar">Schedule</span></a></li>
                            <li class="sidebar-item {{ Request::is('admin/messages/send-campaign') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.campaign') }}" aria-expanded="false"><i class="mdi mdi-bullhorn-outline" style="color: #757575"></i><span
                                    class="color-sidebar">Campaign</span></a></li>
                            {{-- <li class="sidebar-item {{ Request::is('admin/messages/send-campaign') ? 'selected' : '' }}"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.campaign') }}" aria-expanded="false"><i class="mdi mdi-robot-happy-outline" style="color: #757575"></i><span
                                    class="color-sidebar">Bot Autoreply</span></a></li> --}}
                                    
                            {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.rental.index') }}" aria-expanded="false"><i class="mdi mdi-car-multiple" style="color: #757575"></i><span
                                        class="hide-menu color-sidebar">Persewaan</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.transaction.index') }}" aria-expanded="false"><i class="mdi mdi-cash-sync" style="color: #757575"></i><span
                                        class="hide-menu color-sidebar">Transaksi</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.setting') }}" aria-expanded="false"><i class="mdi mdi-cog" style="color: #757575"></i><span
                                        class="hide-menu color-sidebar">Pengaturan</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.profile') }}" aria-expanded="false"><i
                                    class="mdi mdi-account-network" style="color: #757575"></i><span class="hide-menu color-sidebar">Profil</span></a></li> --}}
                        </ul>
            
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            @yield('content-messages')
        </div>
    </div>
 
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection