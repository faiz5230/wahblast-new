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
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    @if (Request::path() == 'admin/system-setting')
                    <li class="breadcrumb-item active" aria-current="page">System Setting</li>
                    @elseif (Request::is('admin/setting-account/*'))
                    <li class="breadcrumb-item active" aria-current="page">Account Setting</li>
                    @elseif (Request::path() == 'admin/app-setting')
                    <li class="breadcrumb-item active" aria-current="page">App Setting</li>
                    @elseif (Request::path() == 'admin/template-message-setting')
                    <li class="breadcrumb-item active" aria-current="page">Template Message Setting</li>
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
                    <b>Settings</b>
                </div>
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.account-setting',Auth::id()) }}" aria-expanded="false"><i class="mdi mdi-account" style="color: #757575"></i><span
                                        class="color-sidebar">Account Setting</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.template-message-setting') }}" aria-expanded="false"><i class="mdi mdi-file-cog-outline" style="color: #757575"></i><span
                                    class="color-sidebar">Template Message Setting</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.system-setting') }}" aria-expanded="false"><i class="mdi mdi-cog" style="color: #757575"></i><span
                                        class="color-sidebar">System Setting</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.app-setting') }}" aria-expanded="false"><i class="mdi mdi-application-cog" style="color: #757575"></i><span
                                    class="color-sidebar">App Setting</span></a></li>
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
        @yield('content-settings')
        </div>
    </div>
 
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection